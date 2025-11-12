<!DOCTYPE html>
<html>

<head>
    <title>Admin: Manage Users</title>
</head>

<body>
    <h1>Admin User Management</h1>
    <p><a href="<?= site_url('/test-shield') ?>">Back to Test</a> | Logged in as: <?= esc($currentUser->username) ?></p>

    <?php if (session()->getFlashdata('message')): ?>
        <p style="color: green;"><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Active</th>
                <th>Group</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= esc($user->username) ?></td>
                    <td><?= esc($user->email) ?></td>
                    <td><?= $user->active ? 'Yes' : 'No' ?></td>
                    <td><?= $user->inGroup('admin') ? 'Admin' : 'User ' ?></td>
                    <td>
                        <a href="<?= site_url('/test-shield/edit/' . $user->id) ?>">Edit</a> |
                        <a href="<?= site_url('/test-shield/delete/' . $user->id) ?>"
                            onclick="return confirm('Delete <?= esc($user->username) ?>?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>