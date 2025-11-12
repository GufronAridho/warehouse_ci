<!DOCTYPE html>
<html>

<head>
    <title>Admin: Edit User</title>
</head>

<body>
    <h1>Edit User: <?= esc($user->username) ?></h1>
    <p><a href="<?= site_url('/test-shield/manage') ?>">Back to Manage Users</a></p>

    <?php if (isset($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?= site_url('/test-shield/edit/' . $user->id) ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label>Username: <input type="text" name="username" value="<?= esc(old('username', $user->username)) ?>" required></label>
        </p>
        <p>
            <label>Email: <input type="email" name="email" value="<?= esc(old('email', $user->email)) ?>" required></label>
        </p>
        <p>
            <label>Active:
                <input type="checkbox" name="active" value="1" <?= $user->active ? 'checked' : '' ?>>
            </label>
        </p>
        <p>
            <label>Group:
                <select name="group">
                    <option value="">None</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group ?>" <?= $user->inGroup($group) ? 'selected' : '' ?>>
                            <?= ucfirst($group) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        <button type="submit">Update User</button>
    </form>
</body>

</html>