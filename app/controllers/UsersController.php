<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    public function index()
    {
        $this->call->database();
        $this->call->model('UsersModel');

        $users = $this->UsersModel->all();

        $data['users'] = $users ?: [];
        $data['page_title'] = 'User Management — Lab 4';

        $this->call->view('users/users', $data);
    }
}
