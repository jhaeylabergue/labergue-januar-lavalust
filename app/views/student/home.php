<?php
/**
 * @var array  $student
 * @var string $page_title
 * @var string $active_page
 * @var bool   $has_access
 */
 defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Student Portal') ?></title>
    <?php lava_instance()->call->view('student/_styles'); ?>
</head>
<body>

<?php lava_instance()->call->view('student/_nav', ['active_page' => $active_page ?? 'home']); ?>

<div class="page-wrap">
    <h1 class="page-title">Student Information</h1>
    <p class="page-subtitle">Welcome to the JL Student Portal — Web Systems &amp; Technologies Lab 3</p>

    <?php if (empty($has_access)): ?>
    <div class="alert alert-info">
        Profile access is protected by <strong>StudentMiddleware</strong>.
        <a href="<?= site_url('student?grant=1') ?>" class="btn btn-primary" style="margin-left: 1rem;">Grant Profile Access</a>
    </div>
    <?php else: ?>
    <p style="margin-bottom: 1.5rem;">
        <span class="badge badge-success">Profile access granted</span>
    </p>
    <?php endif; ?>

    <div class="card">
        <h2>Student Details</h2>
        <div class="info-grid">
            <div class="info-item">
                <label>Student ID</label>
                <span><?= htmlspecialchars($student['student_id']) ?></span>
            </div>
            <div class="info-item">
                <label>Name</label>
                <span><?= htmlspecialchars($student['name']) ?></span>
            </div>
            <div class="info-item">
                <label>Course</label>
                <span><?= htmlspecialchars($student['course']) ?></span>
            </div>
            <div class="info-item">
                <label>Year Level</label>
                <span><?= htmlspecialchars($student['year']) ?></span>
            </div>
            <div class="info-item">
                <label>Section</label>
                <span><?= htmlspecialchars($student['section']) ?></span>
            </div>
            <div class="info-item">
                <label>Email</label>
                <span><?= htmlspecialchars($student['email']) ?></span>
            </div>
        </div>
    </div>

    <p>
        <a href="<?= site_url('student/profile') ?>" class="btn btn-primary">View Full Profile →</a>
    </p>
</div>

</body>
</html>
