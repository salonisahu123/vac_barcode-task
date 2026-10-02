<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | V A Corporation</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
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

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <h2>Sign In</h2>

            <!-- EMAIL -->
            <div class="input-group">
                <input type="email" name="email" placeholder=" " value="{{ old('email') }}">
                <label>Email Address</label>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="input-group password-box">
                <input type="password" id="password" name="password" placeholder=" ">
                <label>Password</label>
                <span class="toggle-pass" onclick="togglePassword()">👁</span>

                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <!-- OPTIONS -->
            <div class="options">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>

               </div>

            <!-- BUTTON -->
            <button type="submit" class="login-btn">Login</button>

        </form>

    </div>

</div>

<script src="{{ asset('js/login.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: true,
    confirmButtonText: 'OK',
    confirmButtonColor: '#f97316'
});
</script>
@endif

<script>
function togglePassword(){
    let pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>