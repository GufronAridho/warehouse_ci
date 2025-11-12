<!DOCTYPE html>
<html>

<head>
    <title>Shield Test - Not Logged In</title>
</head>

<body>
    <h1>Shield Test</h1>
    <p>You are not logged in. Shield is working (no auth detected).</p>
    <p><a href="<?= site_url('/login') ?>">Go to Login</a> (assuming Shield's default login route)</p>
    <p>After logging in, visit <a href="<?= site_url('/test-shield') ?>">Test Shield</a> again.</p>
</body>

</html>