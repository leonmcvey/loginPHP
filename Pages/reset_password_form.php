<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>

<body>
    <h2>Password Reset</h2>
    <form method="POST"
        action="reset_password.php?token=<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">
        <input type="hidden" name="token"
            value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br>
        <?php if (isset($error_messages['password'])): ?>
            <span style="color: red;"><?php echo $error_messages['password']; ?></span><br>
        <?php endif; ?>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <?php if (isset($error_messages['confirm_password'])): ?>
            <span style="color: red;"><?php echo $error_messages['confirm_password']; ?></span><br>
        <?php endif; ?>
        <button type="submit">Reset Password</button>
        <?php if (isset($error_messages['general'])): ?>
            <p style="color: red;"><?php echo $error_messages['general']; ?></p>
        <?php endif; ?>
    </form>
</body>

</html>