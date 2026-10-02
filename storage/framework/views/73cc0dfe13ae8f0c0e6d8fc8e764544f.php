<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | V A Corporation</title>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
</head>

<body>

<div class="login-card">

    <!-- LEFT -->
    <div class="left">
        <h1>V A Corporation</h1>
        <p>Welcome Back</p>
        <span>Secure login to your dashboard</span>
    </div>

    <!-- RIGHT -->
    <div class="right">

        <form action="<?php echo e(route('login.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <h2>Sign In</h2>

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

            <!-- PASSWORD -->
            <div class="input-group password-box">
                <input type="password" id="password" name="password" placeholder=" ">
                <label>Password</label>
                <span class="toggle-pass" onclick="togglePassword()">👁</span>

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

            <!-- OPTIONS -->
            <div class="options">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>

                <a href="<?php echo e(route('password.request')); ?>">Forgot Password?</a>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">Login</button>

        </form>

    </div>

</div>

<script src="<?php echo e(asset('js/login.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(session('success')): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "<?php echo e(session('success')); ?>",
    timer: 2000,
    showConfirmButton: true,
    confirmButtonText: 'OK',
    confirmButtonColor: '#f97316'
});
</script>
<?php endif; ?>

<script>
function togglePassword(){
    let pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/auth/login.blade.php ENDPATH**/ ?>