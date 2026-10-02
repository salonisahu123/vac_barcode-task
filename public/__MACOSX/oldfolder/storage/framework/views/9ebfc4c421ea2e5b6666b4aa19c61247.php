<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password | V A Corporation</title>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
</head>

<body>

<div class="login-card">

    <!-- LEFT -->
    <div class="left">
        <h1>V A Corporation</h1>
        <p>Create New Password</p>
        <span>Set a strong password for your account</span>
    </div>

<!-- RIGHT -->
<div class="right">

    <form method="POST" action="<?php echo e(route('password.update')); ?>">
        <?php echo csrf_field(); ?>

        <h2>Reset Password</h2>

        <input type="hidden" name="email" value="<?php echo e($email); ?>">

        <!-- EMAIL ERROR -->
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="error"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- PASSWORD -->
        <div class="input-group password-box">
            <input type="password" name="password" placeholder=" ">
            <label>New Password</label>

            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="input-group password-box">
            <input type="password" name="password_confirmation" placeholder=" ">
            <label>Confirm Password</label>

            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- BUTTON -->
        <button type="submit" class="login-btn">Update Password</button>

        <div class="options bck-to-login">
            <a href="<?php echo e(route('login')); ?>">Back to Login</a>
        </div>

    </form>

</div>

</div>

</body>
</html><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>