<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password | V A Corporation</title>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
</head>

<body>

<div class="login-card">

    <!-- LEFT -->
    <div class="left">
        <h1>V A Corporation</h1>
        <p>Reset Your Password</p>
        <span>Enter your email to continue</span>
    </div>

    <!-- RIGHT -->
    <div class="right">

        <form method="POST" action="<?php echo e(route('password.check')); ?>">
            <?php echo csrf_field(); ?>

            <h2>Forgot Password</h2>

            <!-- EMAIL -->
            <div class="input-group">
                <input type="email" name="email" placeholder=" " value="<?php echo e(old('email')); ?>">
                <label>Email Address</label>

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
            </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">Continue</button>

            <div class="options bck-to-login">
                <a href="<?php echo e(route('login')); ?>">Back to Login</a>
            </div>

        </form>

    </div>

</div>

</body>
</html><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>