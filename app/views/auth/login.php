<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * @var string|null $error
 * @var string|null $success
 * @var string $page_title
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Login') ?></title>
    <link rel="stylesheet" href="<?= base_url('login-glass.css') ?>">
</head>
<body>
    <div class="login-shell">
        <div class="login-card">
            <h1><?= htmlspecialchars($page_title ?? 'Login') ?></h1>

            <?php if (!empty($error)): ?>
                <div class="flash error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="flash success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('login') ?>">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" autocomplete="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" autocomplete="current-password" required>

                <button class="btn" type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
