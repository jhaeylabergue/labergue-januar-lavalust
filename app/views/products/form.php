<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * @var array $product
 * @var string $page_title
 * @var string $username
 * @var string $form_action
 * @var string $form_heading
 * @var string $submit_label
 * @var string|null $error
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Product Form') ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fb; color: #1f2937; }
        .top { background: #14213d; color: #fff; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .top a { color: #fff; text-decoration: none; }
        .wrap { max-width: 760px; margin: 24px auto; background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 3px 12px rgba(0,0,0,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; }
        h1 { margin: 0 0 20px; font-size: 30px; }
        .flash { padding: 12px; margin-bottom: 16px; border-radius: 6px; font-weight: 600; }
        .flash.error { background: #fee2e2; color: #991b1b; }
        label { display: block; font-weight: 700; margin-top: 14px; }
        input, textarea { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; box-sizing: border-box; margin-top: 6px; }
        textarea { min-height: 120px; resize: vertical; }
        .btn { display: inline-block; padding: 10px 14px; border-radius: 6px; color: #fff; background: #2563eb; text-decoration: none; font-weight: bold; border: none; cursor: pointer; }
        .btn-secondary { background: #475569; }
        .form-actions { margin-top: 18px; display: flex; gap: 8px; }
    </style>
</head>
<body>
    <div class="top">
        <div> Product Management</div>
        <div>
            <span><?= htmlspecialchars($username) ?></span> |
            <a href="<?= site_url('logout') ?>">Logout</a>
        </div>
    </div>

    <div class="wrap">
        <div class="header">
            <div>
                <h1><?= htmlspecialchars($form_heading ?? 'Product Form') ?></h1>
            </div>
            <a class="btn btn-secondary" href="<?= site_url('products') ?>">Back to products</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="flash error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= htmlspecialchars($form_action) ?>">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars((string) ($product['product_name'] ?? '')) ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= htmlspecialchars((string) ($product['description'] ?? '')) ?></textarea>

            <label for="price">Price</label>
            <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars((string) ($product['price'] ?? '')) ?>" required>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars((string) ($product['quantity'] ?? '')) ?>" required>

            <div class="form-actions">
                <button class="btn" type="submit"><?= htmlspecialchars($submit_label ?? 'Save Product') ?></button>
                <a class="btn btn-secondary" href="<?= site_url('products') ?>">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
