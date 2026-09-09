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
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #eef2f7; color: #1f2937; }
        .login-shell { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: min(440px, calc(100vw - 40px)); background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.12); }
        h1 { margin: 0 0 24px; font-size: 30px; }
        label { display: block; font-weight: 700; margin-top: 14px; }
        input { width: 100%; padding: 11px; border-radius: 8px; border: 1px solid #cbd5e1; box-sizing: border-box; margin-top: 6px; }
        .btn { width: 100%; padding: 12px; border: none; background: #2563eb; color: #fff; border-radius: 8px; font-weight: 700; cursor: pointer; margin-top: 16px; }
        .flash { padding: 12px; margin-bottom: 16px; border-radius: 8px; font-weight: 600; }
        .flash.error { background: #fee2e2; color: #991b1b; }
        .flash.success { background: #dcfce7; color: #166534; }
    </style>
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
