<?php
/**
 * @var array  $users
 * @var string $page_title
 * @var string $active_page
 */
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Users') ?></title>
    <?php lava_instance()->call->view('student/_styles'); ?>
</head>
<body>

<?php lava_instance()->call->view('student/_nav', ['active_page' => $active_page ?? 'users']); ?>

<div class="page-wrap" style="max-width: 1080px;">
    <h1 class="page-title">Users</h1>
    <p class="page-subtitle">Records loaded from the MySQL <code>users</code> table through UsersModel::all()</p>

    <div class="card">
        <h2>User Management Module</h2>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($user['id'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($user['firstname'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($user['lastname'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($user['email'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($user['username'] ?? '')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
