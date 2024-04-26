<?php
require_once ('../lib/PageTemplate.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Login";
    $TPL->ContentBody = __FILE__;
    include "../layout.php";
    exit;
}

?>
<form action="processForgotPassword.php" method="post">
    <input type="email" name="email" placeholder="Enter your email here" required>
    <button type="submit">Submit</button>
</form>