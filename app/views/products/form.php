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
    <link rel="stylesheet" href="<?= base_url('products-form-glass.css') ?>">
</head>
<body>
    <div class="top">
        <div class="brand">Product Management</div>
        <div class="userbar">
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
