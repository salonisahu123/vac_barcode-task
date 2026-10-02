<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password | V A Corporation</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
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

        <form method="POST" action="{{ route('password.check') }}">
            @csrf

            <h2>Forgot Password</h2>

            <!-- EMAIL -->
            <div class="input-group">
                <input type="email" name="email" placeholder=" " value="{{ old('email') }}">
                <label>Email Address</label>

                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">Continue</button>

            <div class="options bck-to-login">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>

        </form>

    </div>

</div>

</body>
</html>