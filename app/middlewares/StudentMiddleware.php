<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle(Closure $next)
    {
        $lava = lava_instance();
        $lava->call->library('session');
        $lava->call->helper('url');

        if (!$lava->session->userdata('student_access')) {
            redirect('student');
            return;
        }

        return $next();
    }
}
