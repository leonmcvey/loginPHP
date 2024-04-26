<?php
require_once ('lib/PageTemplate.php');

# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Login";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
$message = isset($_GET['error']) ? $_GET['error'] : '';
?>

<div class="row">
    <div class="col-md-12">
        <div class="newsletter">
            <p>User<strong>&nbsp;LOGIN</strong></p>
            <?php if (!empty($message)): ?>
                <div class="error-message"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="registration/login.php" method="post">
                <input class="input" type="email" placeholder="Enter Your Email" name="email">
                <br />
                <br />
                <input class="input" type="password" placeholder="Enter Your Password" name="password">
                <br />
                <br />
                <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i> Login</button>
            </form>
            <a href="../pages/forgotPassword.php">Lost password?</a>
        </div>
    </div>
</div>