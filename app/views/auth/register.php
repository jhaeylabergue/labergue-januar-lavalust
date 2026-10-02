<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * @var string|null $error
 * @var bool $setup_available
 * @var string $page_title
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Create Account') ?></title>
    <link rel="stylesheet" href="<?= base_url('login-glass.css') ?>">
</head>
<body>
    <div class="login-shell">
        <div class="login-card">
            <h1><?= htmlspecialchars($page_title ?? 'Admin Setup') ?></h1>

            <?php if (!empty($error)): ?>
                <div class="flash error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($setup_available)): ?>
                <p>Set up the single admin account using the email and one-time token configured by the site owner.</p>
                <form method="post" action="<?= site_url('register') ?>">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" maxlength="100" autocomplete="name" required>

                    <label for="email">Admin email</label>
                    <input type="email" id="email" name="email" maxlength="255" autocomplete="email" required>

                    <label for="setup_token">One-time setup token</label>
                    <input type="password" id="setup_token" name="setup_token" autocomplete="off" required>

                    <label for="password">Password (at least 8 characters)</label>
                    <input type="password" id="password" name="password" minlength="8" autocomplete="new-password" required>

                    <button class="btn" type="submit">Set Up Admin Account</button>
                </form>
            <?php else: ?>
                <p>Admin setup is closed or not configured. Sign in with the admin account.</p>
            <?php endif; ?>
            <p><a href="<?= site_url('login') ?>">Back to login</a></p>
        </div>
    </div>
</body>
</html>
