<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthMiddleware
{
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('session');
        $lava->call->helper('url');

        if (!$lava->session->userdata('logged_in')) {
            $lava->session->set_flashdata('error', 'Please log in to manage products.');
            redirect('login');
            exit;
        }

        return $next();
    }
}
