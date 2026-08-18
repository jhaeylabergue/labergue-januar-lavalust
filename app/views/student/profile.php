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
    <title><?= htmlspecialchars($page_title ?? 'Student Profile') ?></title>
    <?php lava_instance()->call->view('student/_styles'); ?>
</head>
<body>

<?php lava_instance()->call->view('student/_nav', ['active_page' => $active_page ?? 'profile']); ?>

<div class="page-wrap">
    <div class="profile-header">
        <div class="avatar"><?= strtoupper(substr($student['name'], 0, 1)) ?></div>
        <div>
            <h1 class="page-title"><?= htmlspecialchars($student['name']) ?></h1>
            <p class="page-subtitle" style="margin-bottom: 0;">
                <?= htmlspecialchars($student['course']) ?> · <?= htmlspecialchars($student['year']) ?> · Section <?= htmlspecialchars($student['section']) ?>
            </p>
        </div>
    </div>

    <div class="card">
        <h2>Student Information</h2>
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
            <div class="info-item">
                <label>Phone</label>
                <span><?= htmlspecialchars($student['phone']) ?></span>
            </div>
            <div class="info-item">
                <label>Address</label>
                <span><?= htmlspecialchars($student['address']) ?></span>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>About Me</h2>
        <p class="bio-text"><?= htmlspecialchars($student['bio']) ?></p>
    </div>

    <div class="card">
        <h2>Skills</h2>
        <ul class="tag-list">
            <?php foreach ($student['skills'] as $skill): ?>
            <li><?= htmlspecialchars($skill) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="card">
        <h2>Hobbies</h2>
        <ul class="tag-list">
            <?php foreach ($student['hobbies'] as $hobby): ?>
            <li><?= htmlspecialchars($hobby) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <p>
        <span class="badge badge-success">Protected by StudentMiddleware</span>
    </p>
</div>

</body>
</html>
