<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthModel extends Model
{
    protected $table = 'users';
    protected $primary_key = 'id';
    protected $fillable = ['username', 'password'];
    protected $timestamps = false;
}
