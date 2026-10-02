<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Access</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Fira+Sans:wght@200;500&display=swap");

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        :root{
            --primary-color:#faca2e;
            --eye-pupil-color:#050505;
            --bg-color:#ffffff;
            --text-color:#000000;
            --fs-heading:36px;
            --fs-text:24px;
            --fs-button:18px;
            --fs-icon:28px;
            --pupil-size:28px;
            --eye-size:80px;
            --button-padding:14px 28px;
        }

        @media(max-width:567px){
            :root{
                --fs-heading:28px;
                --fs-text:20px;
                --fs-button:16px;
                --fs-icon:24px;
                --button-padding:12px 22px;
            }
        }

        body{
            display:flex;
            min-height:100vh;
            background:var(--bg-color);
            color:var(--text-color);
            font-family:"Fira Sans", sans-serif;
            transition:0.3s ease;
        }

        .container{
            display:flex;
            flex-direction:column;
            align-items:center;
            row-gap:28px;
            text-align:center;
            padding:20px;
        }

        .error-page{
            margin:auto;
        }

        .eyes{
            display:flex;
            justify-content:center;
            gap:10px;
        }

        .eye{
            width:var(--eye-size);
            height:var(--eye-size);
            background:var(--primary-color);
            border-radius:50%;
            display:grid;
            place-items:center;
            box-shadow:0 10px 20px rgba(0,0,0,0.08);
        }

        .eye__pupil{
            width:var(--pupil-size);
            height:var(--pupil-size);
            background:var(--eye-pupil-color);
            border-radius:50%;
            animation:movePupil 2s infinite ease-in-out;
        }

        @keyframes movePupil{
            0%,100%{transform:translate(0,0);}
            25%{transform:translate(-8px,-8px);}
            50%{transform:translate(8px,8px);}
            75%{transform:translate(-8px,8px);}
        }

        .error-page__heading{
            font-size:var(--fs-heading);
            font-weight:500;
            color:var(--primary-color);
        }

        .error-page__description{
            font-size:var(--fs-text);
            font-weight:200;
            line-height:1.6;
        }

        .btn-group{
            display:flex;
            gap:14px;
            flex-wrap:wrap;
            justify-content:center;
        }

        .error-page__button{
            text-decoration:none;
            color:inherit;
            border:1px solid var(--primary-color);
            font-size:var(--fs-button);
            font-weight:200;
            padding:var(--button-padding);
            border-radius:14px;
            box-shadow:0px 7px 0px -2px var(--primary-color);
            transition:0.3s ease;
        }

        .error-page__button:hover{
            box-shadow:none;
            background:var(--primary-color);
            color:#fff;
            transform:translateY(2px);
        }

        .color-switcher{
            position:fixed;
            top:25px;
            right:25px;
            background:transparent;
            border:0;
            font-size:var(--fs-icon);
            cursor:pointer;
            color:var(--primary-color);
        }

        @media(max-width:576px){
            .btn-group{
                flex-direction:column;
                width:100%;
            }

            .error-page__button{
                width:100%;
            }
        }
    </style>
</head>

<body>

<main class="error-page">
    <div class="container">

        <div class="eyes">
            <div class="eye">
                <div class="eye__pupil"></div>
            </div>

            <div class="eye">
                <div class="eye__pupil"></div>
            </div>
        </div>

        <h1 class="error-page__heading">Access Denied</h1>

        <p class="error-page__description">
            You don’t have permission to access this page.
            <br>
            Please contact administrator.
        </p>

        <div class="btn-group">
            <a href="{{ url()->previous() }}" class="error-page__button">Go Back</a>

            <a href="{{ url('/') }}" class="error-page__button">Dashboard</a>
        </div>

    </div>
</main>

<button class="color-switcher" onclick="toggleTheme()">🌙</button>

<script>
    let darkMode = false;

    function toggleTheme()
    {
        const root = document.documentElement;
        const btn = document.querySelector('.color-switcher');

        if(darkMode)
        {
            root.style.setProperty('--bg-color','#ffffff');
            root.style.setProperty('--text-color','#000000');
            btn.innerHTML = '🌙';
            darkMode = false;
        }
        else
        {
            root.style.setProperty('--bg-color','#050505');
            root.style.setProperty('--text-color','#ffffff');
            btn.innerHTML = '☀️';
            darkMode = true;
        }
    }
</script>

</body>
</html>