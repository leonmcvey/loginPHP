<?php
require_once ('lib/PageTemplate.php');
# trick to execute 1st time, but not 2nd so you don't have an inf loop
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Regsier";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
?>
<p>
<div class="row">
    <div class="col-md-12">
        <div class="newsletter">
            <p>User<strong>&nbsp;REGISTER</strong></p>
            <form action="/registration/register.php" method="post">
                <!-- Email field -->
                <input class="input" type="email" name="email" placeholder="Enter Your Email">
                <?php if (isset($error_messages['email'])): ?>
                    <span class="error"><?php echo $error_messages['email']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- Password field -->
                <input class="input" type="password" name="password" placeholder="Enter Your Password">
                <?php if (isset($error_messages['password'])): ?>
                    <span class="error"><?php echo $error_messages['password']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- Confirm Password field -->
                <input class="input" type="password" name="confirm_password" placeholder="Repeat Password">
                <?php if (isset($error_messages['confirm_password'])): ?>
                    <span class="error"><?php echo $error_messages['confirm_password']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- Name field -->
                <input class="input" type="text" name="name" placeholder="Name">
                <?php if (isset($error_messages['name'])): ?>
                    <span class="error"><?php echo $error_messages['name']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- Street Address field -->
                <input class="input" type="text" name="street_address" placeholder="Street address">
                <?php if (isset($error_messages['street_address'])): ?>
                    <span class="error"><?php echo $error_messages['street_address']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- Postal Code field -->
                <input class="input" type="text" name="postal_code" placeholder="Postal code">
                <?php if (isset($error_messages['postal_code'])): ?>
                    <span class="error"><?php echo $error_messages['postal_code']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- City field -->
                <input class="input" type="text" name="city" placeholder="City">
                <?php if (isset($error_messages['city'])): ?>
                    <span class="error"><?php echo $error_messages['city']; ?></span><br>
                <?php endif; ?>
                <br>

                <!-- Submit button -->
                <button class="newsletter-btn" type="submit"><i class="fa fa-envelope"></i> Register</button>
            </form>
        </div>
    </div>
</div>


</p>