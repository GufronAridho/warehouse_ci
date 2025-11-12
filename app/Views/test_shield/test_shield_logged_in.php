<!DOCTYPE html>
<html>

<head>
    <title>Shield Test - Logged In</title>
</head>

<body>
    <h1>Shield Test - Success!</h1>
    <p>Shield authentication is working. You are logged in as:</p>
    <ul>
        <li><strong>Username:</strong> <?= esc($user->username) ?></li>
        <li><strong>Email:</strong> <?= esc($user->email) ?></li>
        <li><strong>Active:</strong> <?= $user->active ? 'Yes' : 'No' ?></li>
        <?php if (isset($isAdmin) && $isAdmin): ?>
            <li><strong>Role:</strong> Admin (in 'admin' group)</li>
        <?php endif; ?>
    </ul>
    <p>
        <?php if ($isAdmin): ?>
    <p><a href="<?= site_url('/test-shield/manage') ?>">Manage Users (Admin)</a></p>
<?php else: ?>
    <p>You are a regular user – no admin access.</p>
<?php endif; ?>
<form action="<?= site_url('/test-shield/logout') ?>" method="post" style="display: inline;">
    <?= csrf_field() ?>
    <button type="submit">Logout</button>
</form>
</p>
<p><a href="<?= site_url('/') ?>">Back to Home</a></p>
</body>

</html>