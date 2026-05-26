<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        body{
            margin:0;
            padding:0;
            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            font-family:'Poppins', sans-serif;

            background:
                linear-gradient(rgba(245,241,235,.92), rgba(245,241,235,.92)),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1200&auto=format&fit=crop');

            background-size:cover;
            background-position:center;
        }

        .card-reset{

            width:420px;

            background:rgba(255,255,255,.88);

            backdrop-filter:blur(14px);

            border-radius:28px;

            padding:45px;

            box-shadow:
                0 15px 40px rgba(0,0,0,.08);

            border:1px solid rgba(255,255,255,.4);

            position:relative;

            z-index:2;
        }

        .icon-box{

            width:90px;
            height:90px;

            margin:auto;
            margin-bottom:20px;

            border-radius:24px;

            background:linear-gradient(
                135deg,
                #C08B5C,
                #8B5E3C
            );

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:38px;

            color:white;

            box-shadow:
                0 10px 25px rgba(139,94,60,.3);
        }

        h1{

            text-align:center;

            color:#5C3B28;

            font-size:42px;

            margin-bottom:10px;

            font-weight:800;
        }

        .subtitle{

            text-align:center;

            color:#7A6A5D;

            margin-bottom:35px;

            line-height:1.6;
        }

        label{

            display:block;

            margin-bottom:10px;

            font-weight:700;

            color:#5C3B28;
        }

        input{

            width:100%;

            padding:15px;

            border-radius:16px;

            border:1px solid #E5D7CC;

            outline:none;

            font-size:15px;

            background:#fff;

            transition:.3s;

            box-sizing:border-box;
        }

        input:focus{

            border-color:#A47148;

            box-shadow:
                0 0 0 4px rgba(164,113,72,.15);
        }

        .btn-reset{

            width:100%;

            margin-top:25px;

            padding:15px;

            border:none;

            border-radius:16px;

            background:linear-gradient(
                135deg,
                #A47148,
                #8B5E3C
            );

            color:white;

            font-size:16px;

            font-weight:700;

            cursor:pointer;

            transition:.3s;
        }

        .btn-reset:hover{

            transform:translateY(-2px);

            box-shadow:
                0 10px 20px rgba(139,94,60,.25);
        }

        .back-login{

            display:block;

            text-align:center;

            margin-top:25px;

            color:#8B5E3C;

            text-decoration:none;

            font-weight:600;
        }

        .back-login:hover{
            text-decoration:underline;
        }

        /* POPUP */

        .popup-overlay{

            position:fixed;

            inset:0;

            background:rgba(0,0,0,.35);

            display:none;

            justify-content:center;

            align-items:center;

            z-index:999;
        }

        .popup-box{

            width:350px;

            background:white;

            padding:35px;

            border-radius:24px;

            text-align:center;

            animation:popup .3s ease;

            box-shadow:
                0 15px 35px rgba(0,0,0,.18);
        }

        .popup-icon{

            width:80px;
            height:80px;

            margin:auto;
            margin-bottom:20px;

            border-radius:50%;

            display:flex;
            align-items:center;
            justify-content:center;

            background:#DCFCE7;

            color:#16A34A;

            font-size:40px;

            font-weight:bold;
        }

        .popup-box h2{

            margin-bottom:10px;

            color:#5C3B28;

            font-size:28px;
        }

        .popup-box p{

            color:#666;

            line-height:1.6;

            margin-bottom:25px;
        }

        .popup-box button{

            border:none;

            background:linear-gradient(
                135deg,
                #A47148,
                #8B5E3C
            );

            color:white;

            padding:12px 28px;

            border-radius:14px;

            font-weight:700;

            cursor:pointer;
        }

        @keyframes popup{

            from{
                transform:scale(.8);
                opacity:0;
            }

            to{
                transform:scale(1);
                opacity:1;
            }
        }

    </style>
</head>

<body>

    <div class="card-reset">

        <div class="icon-box">
            🔒
        </div>

        <h1>Lupa Password</h1>

        <p class="subtitle">
            Jangan khawatir, masukkan email akun Anda
            dan kami akan membantu reset password.
        </p>

        <form method="POST" action="{{ route('password.email') }}">

            @csrf

            <div>

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email..."
                    required
                >

            </div>

            <button
                type="button"
                class="btn-reset"
                onclick="showPopup()"
            >
                Kirim Link Reset
            </button>

        </form>

        <a href="/login" class="back-login">
            ← Kembali ke Login
        </a>

    </div>

    {{-- POPUP --}}
    <div class="popup-overlay" id="popupSuccess">

        <div class="popup-box">

            <div class="popup-icon">
                ✔
            </div>

            <h2>Berhasil!</h2>

            <p>
                Link reset password berhasil dikirim.
            </p>

            <button onclick="closePopup()">
                Oke
            </button>

        </div>

    </div>

    <script>

        function showPopup(){

            document.getElementById('popupSuccess').style.display='flex';

        }

        function closePopup(){

            document.getElementById('popupSuccess').style.display='none';

            document.querySelector('form').submit();

        }

    </script>

</body>
</html>