<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * @var array $products
 * @var string $page_title
 * @var string $username
 * @var string|null $success
 * @var string|null $error
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Products') ?></title>
    <link rel="stylesheet" href="<?= base_url('public/products-glass.css') ?>">
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
                <h1><?= htmlspecialchars($page_title ?? 'Products') ?></h1>
                <p>Welcome, <?= htmlspecialchars($username) ?>.</p>
            </div>
            <a class="btn" href="<?= site_url('products/create') ?>">Add Product</a>
        </div>

        <?php if (!empty($success)): ?>
            <div class="flash success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="flash error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr class="empty-row">
                        <td colspan="7">No products found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) ($product['id'] ?? '')) ?></td>
                            <td><?= htmlspecialchars((string) ($product['product_name'] ?? '')) ?></td>
                            <td><?= htmlspecialchars((string) ($product['description'] ?? '')) ?></td>
                            <td><?= htmlspecialchars((string) ($product['price'] ?? '')) ?></td>
                            <td><?= htmlspecialchars((string) ($product['quantity'] ?? '')) ?></td>
                            <td><?= htmlspecialchars((string) ($product['created_at'] ?? '')) ?></td>
                            <td class="actions">
                                <a class="btn btn-secondary" href="<?= site_url('products/edit/' . (int) ($product['id'] ?? 0)) ?>">Edit</a>
                                <a class="btn btn-danger" href="<?= site_url('products/delete/' . (int) ($product['id'] ?? 0)) ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
