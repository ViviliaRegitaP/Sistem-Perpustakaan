<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lentera Pustaka</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        :root{
            --dark:#243020;
            --primary:#6F8F6B;
            --secondary:#97AC82;
            --bg:#F4F6F1;
            --white:#ffffff;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Inter,sans-serif;
            background:var(--bg);
            min-height:100vh;
            overflow:hidden;
        }

        .login-wrapper{
            width:100%;
            min-height:100vh;
            display:flex;
        }

        /* LEFT SIDE */

        .login-left{

            width:43%;

            position:relative;

            background:
            linear-gradient(
                160deg,
                #243020,
                #6F8F6B
            );

            overflow:hidden;

            display:flex;
            flex-direction:column;
            justify-content:center;

            padding:60px;

            border-top-right-radius:100px;
            border-bottom-right-radius:100px;

            margin-right:-60px;

            z-index:2;
        }

        .login-left::before{
            content:'';

            position:absolute;

            width:320px;
            height:320px;

            border-radius:50%;

            background:
            rgba(255,255,255,.08);

            top:-120px;
            right:-100px;
        }

        .login-left::after{
            content:'';

            position:absolute;

            width:220px;
            height:220px;

            border-radius:50%;

            background:
            rgba(255,255,255,.08);

            bottom:-70px;
            left:-70px;
        }

        .brand-icon{

            width:78px;
            height:78px;

            border-radius:24px;

            background:
            rgba(255,255,255,.12);

            display:flex;
            align-items:center;
            justify-content:center;

            color:white;

            font-size:36px;

            margin-bottom:28px;

            backdrop-filter:blur(10px);
        }

        .brand-title{

            color:white;

            font-size:56px;
            font-weight:800;

            line-height:1.08;

            margin-bottom:22px;
        }

        .brand-desc{

            color:
            rgba(255,255,255,.88);

            font-size:18px;

            line-height:1.8;

            max-width:420px;
        }

        /* RIGHT SIDE */

        .login-right{

            width:57%;

            position:relative;

            z-index:1;

            background:var(--bg);

            display:flex;
            align-items:center;
            justify-content:center;

            padding:40px 50px;
        }

        .login-box{

            width:100%;
            max-width:500px;
        }

        .login-title{

            font-size:42px;
            font-weight:800;

            color:var(--dark);

            margin-bottom:8px;
        }

        .login-subtitle{

            font-size:16px;

            color:#61705D;

            margin-bottom:30px;
        }

        .form-label{

            font-size:16px;

            font-weight:700;

            color:var(--dark);

            margin-bottom:10px;
        }

        .input-group-custom{

            position:relative;

            margin-bottom:22px;
        }

        .input-group-custom i{

            position:absolute;

            left:22px;
            top:50%;

            transform:translateY(-50%);

            color:#7B8876;

            font-size:17px;
        }

        .form-control{

            height:58px;

            border-radius:18px;

            border:2px solid #B7C4AE;

            padding-left:62px;

            font-size:16px;

            background:white;
        }

        .form-control:focus{

            box-shadow:none;

            border-color:var(--primary);
        }

        .remember-wrap{

            display:flex;
            justify-content:space-between;
            align-items:center;

            margin-bottom:24px;
        }

        .form-check-label{

            font-size:15px;
        }

        .forgot-link{

            text-decoration:none;

            color:var(--primary);

            font-weight:700;

            font-size:15px;
        }

        .btn-login{

            width:100%;

            height:56px;

            border:none;

            border-radius:18px;

            background:
            linear-gradient(
                135deg,
                #243020,
                #6F8F6B
            );

            color:white;

            font-size:18px;
            font-weight:700;

            transition:.25s ease;

            box-shadow:
            0 10px 24px rgba(111,143,107,.20);
        }

        .btn-login:hover{

            transform:
            translateY(-2px);

            background:
            linear-gradient(
                135deg,
                #1D271A,
                #5F7F5B
            );
        }

        .register-text{

            text-align:center;

            margin-top:20px;

            font-size:16px;

            color:#677261;
        }

        .register-text a{

            color:var(--primary);

            text-decoration:none;

            font-weight:700;
        }

        .copyright{

            margin-top:18px;

            text-align:center;

            color:#7A8575;

            font-size:14px;
        }

        @media(max-width:991px){

            body{
                overflow:auto;
            }

            .login-wrapper{
                flex-direction:column;
            }

            .login-left,
            .login-right{
                width:100%;
            }

            .login-left{

                min-height:280px;

                padding:40px 30px;

                border-radius:
                0 0 50px 50px;

                margin-right:0;
            }

            .brand-title{
                font-size:42px;
            }

            .brand-desc{
                font-size:16px;
            }

            .login-right{
                padding:35px 24px;
            }

            .login-title{
                font-size:36px;
            }

        }

    </style>

</head>

<body>

<div class="login-wrapper">

    {{-- LEFT --}}
    <div class="login-left">

        <div class="brand-icon">
            <i class="bi bi-book-half"></i>
        </div>

        <h1 class="brand-title">
            Lentera<br>
            Pustaka
        </h1>

        <p class="brand-desc">
            Sistem perpustakaan modern untuk mengelola
            data buku dengan cepat, rapi, dan profesional.
        </p>

    </div>

    {{-- RIGHT --}}
    <div class="login-right">

        <div class="login-box">

            @yield('content')

            <div class="copyright">
                © {{ date('Y') }} Lentera Pustaka
            </div>

        </div>

    </div>

</div>

</body>
</html>