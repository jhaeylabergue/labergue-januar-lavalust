<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<nav class="student-nav">
    <div class="nav-brand">JL Student Portal</div>
    <div class="nav-links">
        <a href="<?= site_url('student') ?>" class="<?= ($active_page ?? '') === 'home' ? 'active' : '' ?>">Home</a>
        <span class="nav-sep">|</span>
        <a href="<?= site_url('student/profile') ?>" class="<?= ($active_page ?? '') === 'profile' ? 'active' : '' ?>">Student Profile</a>
        <span class="nav-sep">|</span>
        <a href="<?= site_url('users') ?>" class="<?= ($active_page ?? '') === 'users' ? 'active' : '' ?>">Users</a>
    </div>
</nav>
