<!DOCTYPE html>
<html lang="en">

<head>
  <title>Error | V A Cprporation </title>

  <style>
    body {
      font-family: sans-serif;
      background: white;
      color: #808080;
      text-align: center;
    }

    .animation-ctn {
      text-align: center;
      margin-top: 5em;
    }

    @-webkit-keyframes checkmark {
      0% {
        stroke-dashoffset: 100px
      }

      100% {
        stroke-dashoffset: 200px
      }
    }

    @-ms-keyframes checkmark {
      0% {
        stroke-dashoffset: 100px
      }

      100% {
        stroke-dashoffset: 200px
      }
    }

    @keyframes checkmark {
      0% {
        stroke-dashoffset: 100px
      }

      100% {
        stroke-dashoffset: 0px
      }
    }

    @-webkit-keyframes checkmark-circle {
      0% {
        stroke-dashoffset: 480px
      }

      100% {
        stroke-dashoffset: 960px;
      }
    }

    @-ms-keyframes checkmark-circle {
      0% {
        stroke-dashoffset: 240px
      }

      100% {
        stroke-dashoffset: 480px
      }
    }

    @keyframes checkmark-circle {
      0% {
        stroke-dashoffset: 480px
      }

      100% {
        stroke-dashoffset: 960px
      }
    }

    @keyframes colored-circle {
      0% {
        opacity: 0
      }

      100% {
        opacity: 100
      }
    }

    /* other styles */
    /* .svg svg {
    display: none
}
 */
    .inlinesvg .svg svg {
      display: inline
    }

    /* .svg img {    display: none} */
    .icon--order-success svg polyline {
      -webkit-animation: checkmark 0.25s ease-in-out 0.7s backwards;
      animation: checkmark 0.25s ease-in-out 0.7s backwards
    }

    .icon--order-success svg circle {
      -webkit-animation: checkmark-circle 0.6s ease-in-out backwards;
      animation: checkmark-circle 0.6s ease-in-out backwards;
    }

    .icon--order-success svg circle#colored {
      -webkit-animation: colored-circle 0.6s ease-in-out 0.7s backwards;
      animation: colored-circle 0.6s ease-in-out 0.7s backwards;
    }

    h1 {
      margin-top: 25px;
      font-size: 18px;
      font-family: sans-serif;
    }

    p {
      margin-top: 15px;
      font-size: 14px;
      font-family: sans-serif;
    }
    
    .login-button {
  background-color: #007bff; /* Blue background */
  color: #fff; /* White text */
  padding: 10px 20px; /* Adjust padding for size */
  font-size: 14px; /* Adjust font size */
  font-weight: 400;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  transition: all 0.3s ease;
  text-transform: uppercase;
}

.login-button:hover {
  background-color: #0056b3; /* Darker blue on hover */
  box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px); /* Slight lift on hover */
}

.login-button:active {
  transform: translateY(0); /* Reset lift on click */
  box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2);
}

  </style>
</head>

<body>
  <div class="animation-ctn">
    <div class="icon icon--order-success svg">
      <svg xmlns="http://www.w3.org/2000/svg" width="154px" height="154px">
        <g fill="none" stroke="#F44812" stroke-width="2">
          <circle cx="77" cy="77" r="72" style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
          <circle id="colored" fill="#F44812" cx="77" cy="77" r="72" style="stroke-dasharray:480px, 480px; stroke-dashoffset: 960px;"></circle>
          <polyline class="st0" stroke="#fff" stroke-width="10" points="43.5,77.8  112.2,77.8 " style="stroke-dasharray:100px, 100px; stroke-dashoffset: 200px;" />
        </g>
      </svg>
    </div>
  </div>

  <div>
    <h1>Page Expired </h1>
    <p>Please return to the app where you initiated this login request and try again.</p>
    <a href="{{'/'}}"><button class="login-button">Return To Login</button></a>
  </div>
</body>

</html>