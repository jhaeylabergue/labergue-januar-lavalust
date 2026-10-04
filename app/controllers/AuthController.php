<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    private function boot(): void
    {
        $this->call->library('session');
        $this->call->helper('url');
    }

    private function admin_email(): string
    {
        return strtolower(trim((string) getenv('ADMIN_EMAIL')));
    }

    private function has_admin_session(): bool
    {
        $admin_email = $this->admin_email();
        $session_email = strtolower(trim((string) $this->session->userdata('user_email')));

        return $admin_email !== ''
            && $session_email !== ''
            && hash_equals($admin_email, $session_email)
            && $this->session->userdata('logged_in');
    }

    public function login()
    {
        $this->boot();

        if ($this->has_admin_session()) {
            redirect('products');
            exit;
        }

        $this->session->unset_userdata(['logged_in', 'user_id', 'username', 'user_email']);
        $data['page_title'] = 'Login — Product Management';
        $data['error'] = $this->session->flashdata('error');
        $data['success'] = $this->session->flashdata('success');

        $this->call->view('auth/login', $data);
    }

    public function register()
    {
        $this->boot();

        if ($this->has_admin_session()) {
            redirect('products');
            exit;
        }

        $this->session->unset_userdata(['logged_in', 'user_id', 'username', 'user_email']);
        $this->call->database();
        $this->call->model('AuthModel');

        $admin_email = $this->admin_email();
        $setup_token = (string) getenv('ADMIN_SETUP_TOKEN');
        $existing_admin = $admin_email !== ''
            ? $this->AuthModel->find_by('email', $admin_email)
            : null;

        $data['page_title'] = 'Admin Setup — Product Management';
        $data['error'] = $this->session->flashdata('error');
        $data['setup_available'] = filter_var($admin_email, FILTER_VALIDATE_EMAIL)
            && $setup_token !== ''
            && (!$existing_admin || empty($existing_admin['password']));
        $this->call->view('auth/register', $data);
    }

    public function create_account()
    {
        $this->boot();
        $this->call->database();
        $this->call->model('AuthModel');

        $name = trim((string) $this->request->post('name', ''));
        $email = strtolower(trim((string) $this->request->post('email', '')));
        $password = (string) $this->request->post('password', '');
        $admin_email = $this->admin_email();
        $setup_token = (string) getenv('ADMIN_SETUP_TOKEN');
        $submitted_token = (string) $this->request->post('setup_token', '');

        if (
            $name === ''
            || strlen($name) > 100
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($email) > 255
            || strlen($password) < 8
            || !filter_var($admin_email, FILTER_VALIDATE_EMAIL)
            || $setup_token === ''
            || !hash_equals($admin_email, $email)
            || !hash_equals($setup_token, $submitted_token)
        ) {
            $this->session->set_flashdata('error', 'Admin setup is unavailable or the provided details are invalid.');
            redirect('register');
            exit;
        }

        $existing_admin = $this->AuthModel->find_by('email', $admin_email);
        if ($existing_admin && !empty($existing_admin['password'])) {
            $this->session->set_flashdata('error', 'Admin setup is already complete. Please log in.');
            redirect('register');
            exit;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if ($existing_admin) {
            $this->AuthModel->raw(
                'UPDATE users SET name = ?, password = ? WHERE id = ?',
                [$name, $password_hash, $existing_admin['id']]
            );
        } else {
            $this->AuthModel->insert([
                'name' => $name,
                'email' => $admin_email,
                'password' => $password_hash,
            ]);
        }

        $this->session->set_flashdata('success', 'Admin account configured. You can now log in.');
        redirect('login');
        exit;
    }

    public function authenticate()
    {
        $this->boot();
        $this->call->database();
        $this->call->model('AuthModel');
        $this->call->library('form_validation');

        $this->form_validation
            ->name('email')
            ->required('Email is required.')
            ->valid_email('Enter a valid email address.');

        $this->form_validation
            ->name('password')
            ->required('Password is required.');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', $this->form_validation->errors());
            redirect('login');
            exit;
        }

        $email = strtolower(trim((string) $this->request->post('email', '')));
        $password = (string) $this->request->post('password', '');
        $admin_email = $this->admin_email();

        $user = $this->AuthModel->find_by('email', $email);

        if (
            !$user
            || $admin_email === ''
            || !hash_equals($admin_email, $email)
            || !password_verify($password, $user['password'] ?? '')
        ) {
            $this->session->set_flashdata('error', 'Invalid username or password.');
            redirect('login');
            exit;
        }

        $this->session->sess_regenerate(true);
        $this->session->set_userdata([
            'logged_in' => true,
            'user_id'    => $user['id'],
            'username'   => $user['name'],
            'user_email' => strtolower(trim((string) ($user['email'] ?? ''))),
        ]);

        redirect('products');
        exit;
    }

    public function logout()
    {
        $this->boot();
        $this->session->unset_userdata(['logged_in', 'user_id', 'username', 'user_email']);
        $this->session->sess_destroy();
        $this->call->library('session');
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('login');
        exit;
    }
}
