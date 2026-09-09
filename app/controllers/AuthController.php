<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    private function boot(): void
    {
        $this->call->library('session');
        $this->call->helper('url');
    }

    public function login()
    {
        $this->boot();

        if ($this->session->userdata('logged_in')) {
            redirect('products');
            exit;
        }

        $data['page_title'] = 'Login — Product Management';
        $data['error'] = $this->session->flashdata('error');
        $data['success'] = $this->session->flashdata('success');

        $this->call->view('auth/login', $data);
    }

    public function authenticate()
    {
        $this->boot();
        $this->call->database();
        $this->call->model('AuthModel');
        $this->call->library('form_validation');

        $this->form_validation
            ->name('username')
            ->required('Username is required.')
            ->min_length(3, 'Username must be at least 3 characters.');

        $this->form_validation
            ->name('password')
            ->required('Password is required.');

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('error', $this->form_validation->errors());
            redirect('login');
            exit;
        }

        $username = trim((string) $this->request->post('username', ''));
        $password = (string) $this->request->post('password', '');

        $user = $this->AuthModel->find_by('username', $username);

        if (!$user || !password_verify($password, $user['password'] ?? '')) {
            $this->session->set_flashdata('error', 'Invalid username or password.');
            redirect('login');
            exit;
        }

        if (($user['is_active'] ?? 1) != 1) {
            $this->session->set_flashdata('error', 'Your account is inactive.');
            redirect('login');
            exit;
        }

        $this->session->sess_regenerate(true);
        $this->session->set_userdata([
            'logged_in' => true,
            'user_id'    => $user['id'],
            'username'   => $user['username'],
        ]);

        redirect('products');
        exit;
    }

    public function logout()
    {
        $this->boot();
        $this->session->unset_userdata(['logged_in', 'user_id', 'username']);
        $this->session->sess_destroy();
        $this->call->library('session');
        $this->session->set_flashdata('success', 'You have been logged out.');
        redirect('login');
        exit;
    }
}
