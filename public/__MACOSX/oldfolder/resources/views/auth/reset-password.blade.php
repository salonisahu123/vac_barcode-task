<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password | V A Corporation</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
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

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <h2>Reset Password</h2>

        <input type="hidden" name="email" value="{{ $email }}">

        <!-- EMAIL ERROR -->
        @error('email')
            <span class="error">{{ $message }}</span>
        @enderror

        <!-- PASSWORD -->
        <div class="input-group password-box">
            <input type="password" name="password" placeholder=" ">
            <label>New Password</label>

            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="input-group password-box">
            <input type="password" name="password_confirmation" placeholder=" ">
            <label>Confirm Password</label>

            @error('password_confirmation')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <!-- BUTTON -->
        <button type="submit" class="login-btn">Update Password</button>

        <div class="options bck-to-login">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>

    </form>

</div>

</div>

</body>
</html>