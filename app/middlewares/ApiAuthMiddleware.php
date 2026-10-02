<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuthMiddleware
{
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('api');

        $token = $lava->api->get_bearer_token();
        $payload = $lava->api->validate_jwt($token ?? '');

        if (
            !$payload
            || ($payload['type'] ?? '') !== 'access'
            || !isset($payload['sub'])
            || !is_numeric($payload['sub'])
            || (int) $payload['sub'] < 1
        ) {
            $lava->api->respond_error('Unauthorized', 401);
        }

        $admin_email = strtolower(trim((string) getenv('ADMIN_EMAIL')));
        if ($admin_email === '') {
            $lava->api->respond_error('Admin access is not configured.', 403);
        }

        $lava->call->database();
        $lava->call->model('AuthModel');
        $user = $lava->AuthModel->find((int) $payload['sub']);
        if (
            !$user
            || !hash_equals($admin_email, strtolower(trim((string) ($user['email'] ?? ''))))
        ) {
            $lava->api->respond_error('Admin access required.', 403);
        }

        return $next();
    }
}
