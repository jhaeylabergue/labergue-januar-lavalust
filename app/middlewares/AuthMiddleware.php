<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('session');
        $lava->call->helper('url');

        $admin_email = strtolower(trim((string) getenv('ADMIN_EMAIL')));
        $session_email = strtolower(trim((string) $lava->session->userdata('user_email')));
        $is_admin = $admin_email !== ''
            && $session_email !== ''
            && hash_equals($admin_email, $session_email)
            && $lava->session->userdata('logged_in');

        if (!$is_admin) {
            $lava->session->unset_userdata(['logged_in', 'user_id', 'username', 'user_email']);
            $lava->session->set_flashdata('error', 'Please log in to manage products.');
            redirect('login');
            exit;
        }

        return $next();
    }
}
