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
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8f9fb; color: #1f2937; }
        .top { background: #14213d; color: #fff; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .top a { color: #fff; text-decoration: none; }
        .wrap { max-width: 1060px; margin: 24px auto; background: #fff; padding: 24px; border-radius: 10px; box-shadow: 0 3px 12px rgba(0,0,0,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 20px; }
        .header h1 { margin: 0; font-size: 30px; }
        .btn { display: inline-block; padding: 10px 14px; border-radius: 6px; color: #fff; background: #2563eb; text-decoration: none; font-weight: bold; }
        .btn-danger { background: #b91c1c; }
        .btn-secondary { background: #475569; }
        .flash { padding: 12px; margin: 12px 0; border-radius: 6px; font-weight: 600; }
        .flash.error { background: #fee2e2; color: #991b1b; }
        .flash.success { background: #dcfce7; color: #166534; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #e5eefb; }
        .actions { display: flex; gap: 8px; }
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
                    <tr>
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
