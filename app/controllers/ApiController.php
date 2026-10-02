<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiController extends Controller
{
    private function boot(): void
    {
        $this->call->library('api');
        $this->call->database();
        $this->call->model('AuthModel');
        $this->call->model('ProductModel');
    }

    private function jsonBody(): array
    {
        $body = $this->request->json();
        if (!is_array($body)) {
            $this->api->respond_error('Request body must be valid JSON.', 400);
        }

        return $body;
    }

    public function preflight(): void
    {
        $this->call->library('api');
        $this->api->respond([], 204);
    }

    public function register(): void
    {
        $this->call->library('api');
        $this->api->respond_error('Public registration is disabled.', 403);
    }

    public function login(): void
    {
        $this->boot();
        $body = $this->jsonBody();
        $email = $body['email'] ?? null;
        $password = $body['password'] ?? null;

        if (
            !is_string($email)
            || !filter_var(trim($email), FILTER_VALIDATE_EMAIL)
            || !is_string($password)
            || $password === ''
        ) {
            $this->api->respond_error('A valid email and password are required.', 422);
        }

        $email = strtolower(trim($email));
        $user = $this->AuthModel->find_by('email', $email);
        $admin_email = strtolower(trim((string) getenv('ADMIN_EMAIL')));
        if (
            !$user
            || $admin_email === ''
            || !hash_equals($admin_email, $email)
            || !password_verify($password, $user['password'] ?? '')
        ) {
            $this->api->respond_error('Invalid email or password.', 401);
        }

        $tokens = $this->issueTokens((int) $user['id']);
        $this->api->respond([
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
            'expires_in' => $tokens['expires_in'],
            'token_type' => 'Bearer',
            'user' => ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']],
        ]);
    }

    public function refresh(): void
    {
        $this->boot();
        $body = $this->jsonBody();
        $refreshToken = $body['refresh_token'] ?? null;

        if (!is_string($refreshToken) || trim($refreshToken) === '') {
            $this->api->respond_error('Refresh token is required.', 400);
        }
        $refreshToken = trim($refreshToken);

        $payload = $this->api->validate_jwt($refreshToken);
        if (!$payload || ($payload['type'] ?? '') !== 'refresh') {
            $this->api->respond_error('Invalid refresh token.', 401);
        }

        $tokenHash = $this->hashRefreshToken($refreshToken);
        $statement = $this->AuthModel->raw(
            'SELECT user_id FROM refresh_tokens WHERE token = ? AND expires_at > NOW() LIMIT 1',
            [$tokenHash]
        );
        $storedToken = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$storedToken || (string) $storedToken['user_id'] !== (string) $payload['sub']) {
            $this->api->respond_error('Refresh token has expired or been revoked.', 401);
        }

        $accessToken = $this->createAccessToken((int) $storedToken['user_id']);
        $this->api->respond([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => (int) config_item('payload_token_expiration'),
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(): void
    {
        $this->boot();
        $body = $this->jsonBody();
        $refreshToken = $body['refresh_token'] ?? null;

        if (!is_string($refreshToken) || trim($refreshToken) === '') {
            $this->api->respond_error('Refresh token is required.', 400);
        }
        $refreshToken = trim($refreshToken);

        $this->AuthModel->raw(
            'DELETE FROM refresh_tokens WHERE token = ?',
            [$this->hashRefreshToken($refreshToken)]
        );
        $this->api->respond(['message' => 'Logged out.']);
    }

    public function products(): void
    {
        $this->boot();
        $this->api->respond($this->ProductModel->order_by('id', 'DESC'));
    }

    public function show_product($id): void
    {
        $this->boot();
        $product = $this->ProductModel->find((int) $id);

        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->api->respond($product);
    }

    public function create_product(): void
    {
        $this->boot();
        $body = $this->jsonBody();
        $errors = [];
        $product = $this->validatedProduct($body, false, $errors);

        if ($errors) {
            $this->api->respond(['error' => 'Invalid product data.', 'errors' => $errors], 422);
        }

        $id = $this->ProductModel->insert($product);
        if (!$id) {
            throw new RuntimeException('The product could not be saved.');
        }

        $this->api->respond($this->ProductModel->find((int) $id), 201);
    }

    public function update_product($id): void
    {
        $this->boot();
        $product = $this->ProductModel->find((int) $id);

        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
        }

        $body = $this->jsonBody();
        $errors = [];
        $updates = $this->validatedProduct($body, true, $errors);

        if ($errors) {
            $this->api->respond(['error' => 'Invalid product data.', 'errors' => $errors], 422);
        }
        if (!$updates) {
            $this->api->respond_error('At least one product field is required.', 422);
        }

        $this->ProductModel->update((int) $id, $updates);
        $this->api->respond($this->ProductModel->find((int) $id));
    }

    public function delete_product($id): void
    {
        $this->boot();
        if (!$this->ProductModel->find((int) $id)) {
            $this->api->respond_error('Product not found.', 404);
        }

        $this->ProductModel->soft_delete((int) $id);
        $this->api->respond(['message' => 'Product deleted.']);
    }

    private function issueTokens(int $userId): array
    {
        $refreshToken = $this->api->encode_jwt(['sub' => $userId, 'type' => 'refresh']);
        if (!is_string($refreshToken)) {
            throw new RuntimeException('A refresh token could not be created.');
        }

        $expiresIn = (int) config_item('refresh_token_expiration');
        $this->AuthModel->raw(
            'INSERT INTO refresh_tokens (user_id, token, expires_at) VALUES (?, ?, ?)',
            [$userId, $this->hashRefreshToken($refreshToken), date('Y-m-d H:i:s', time() + $expiresIn)]
        );

        return [
            'access_token' => $this->createAccessToken($userId),
            'refresh_token' => $refreshToken,
            'expires_in' => (int) config_item('payload_token_expiration'),
        ];
    }

    private function createAccessToken(int $userId): string
    {
        $token = $this->api->encode_jwt(['sub' => $userId, 'type' => 'access']);
        if (!is_string($token)) {
            throw new RuntimeException('An access token could not be created.');
        }

        return $token;
    }

    private function hashRefreshToken(string $token): string
    {
        return hash_hmac('sha256', $token, (string) config_item('refresh_token_key'));
    }

    private function validatedProduct(array $body, bool $partial, array &$errors): array
    {
        $product = [];

        if (!$partial || array_key_exists('product_name', $body)) {
            $name = $body['product_name'] ?? null;
            if (!is_string($name) || trim($name) === '' || strlen(trim($name)) > 100) {
                $errors['product_name'] = 'Product name is required and must be 100 characters or fewer.';
            } else {
                $product['product_name'] = trim($name);
            }
        }

        if (!$partial || array_key_exists('description', $body)) {
            if (array_key_exists('description', $body) && $body['description'] !== null && !is_string($body['description'])) {
                $errors['description'] = 'Description must be text.';
            } else {
                $product['description'] = trim((string) ($body['description'] ?? ''));
            }
        }

        if (!$partial || array_key_exists('price', $body)) {
            $price = $body['price'] ?? null;
            if (!is_numeric($price) || (float) $price < 0 || (float) $price > 99999999.99) {
                $errors['price'] = 'Price must be a number greater than or equal to zero.';
            } else {
                $product['price'] = number_format((float) $price, 2, '.', '');
            }
        }

        if (!$partial || array_key_exists('quantity', $body)) {
            $quantityInput = $body['quantity'] ?? null;
            $quantity = is_int($quantityInput) || is_string($quantityInput)
                ? filter_var($quantityInput, FILTER_VALIDATE_INT)
                : false;
            if ($quantity === false || $quantity < 0) {
                $errors['quantity'] = 'Quantity must be a whole number greater than or equal to zero.';
            } else {
                $product['quantity'] = $quantity;
            }
        }

        return $product;
    }
}
