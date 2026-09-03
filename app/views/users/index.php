<?php
/**
 * @var array  $users
 * @var string $page_title
 */
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Users') ?></title>
    <?php lava_instance()->call->view('users/_styles'); ?>
</head>
<body>

<header class="users-header">
    <div>
        <span class="eyebrow">Administration</span>
        <strong class="brand">User Management</strong>
    </div>
</header>

<main class="page-wrap">
    <div class="page-heading">
        <div>
            <p class="kicker">Lab 4 / Database Records</p>
            <h1 class="page-title">Users</h1>
            <p class="page-subtitle">A view of every record in the <code>users</code> table.</p>
        </div>
        <span class="record-count"><?= count($users) ?> records</span>
    </div>

    <section class="table-panel">
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
    </section>
</main>

</body>
</html>
