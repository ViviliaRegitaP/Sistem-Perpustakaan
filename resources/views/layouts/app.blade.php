<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Lentera Pustaka')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        :root{
            --bg:#F6F7F2;
            --white:#ffffff;
            --dark:#243020;
            --primary:#6F8F6B;
            --primary-soft:#97AC82;
            --soft:#EEF2E8;
            --border:#E5E9E1;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:var(--bg);
            font-family:Inter,sans-serif;
            color:var(--dark);
        }

        /* SIDEBAR */

        .sidebar{
            width:260px;
            height:100vh;

            position:fixed;
            top:0;
            left:0;

            background:white;

            border-right:1px solid var(--border);

            padding:28px 20px;

            display:flex;
            flex-direction:column;

            z-index:1000;
        }

        /* LOGO */

        .logo{
            display:flex;
            align-items:center;
            gap:14px;

            margin-bottom:45px;
        }

        .logo-icon{
            width:58px;
            height:58px;

            border-radius:18px;

            background:linear-gradient(
                135deg,
                #6F8F6B,
                #97AC82
            );

            display:flex;
            align-items:center;
            justify-content:center;

            color:white;
            font-size:24px;

            flex-shrink:0;
        }

        .logo-text{
            font-size:24px;
            font-weight:800;
            line-height:1.2;

            color:var(--dark);
        }

        /* PROFILE */

        .profile-card{

            display:flex;
            align-items:center;
            gap:12px;

            padding:14px;

            border-radius:22px;

            background:var(--soft);

            margin-bottom:35px;

        }

        .profile-icon{

            width:50px;
            height:50px;

            border-radius:16px;

            background:white;

            display:flex;
            align-items:center;
            justify-content:center;

            color:var(--primary);

            font-size:22px;

            flex-shrink:0;

        }

        .user-name{

            font-weight:700;
            font-size:18px;

            color:var(--dark);

        }

        /* MENU */

        .menu{
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .menu a{
            text-decoration:none;

            height:58px;

            border-radius:18px;

            padding:0 18px;

            display:flex;
            align-items:center;
            gap:14px;

            color:#667164;

            font-weight:600;
            font-size:16px;

            transition:.2s;
        }

        .menu a i{
            font-size:20px;
        }

        .menu a:hover{
            background:var(--soft);
            color:var(--dark);
        }

        .menu a.active{
            background:linear-gradient(
                135deg,
                #6F8F6B,
                #97AC82
            );

            color:white;

            box-shadow:
            0 10px 25px rgba(111,143,107,.25);
        }

        /* LOGOUT */

        .logout{
            margin-top:auto;
        }

        .logout button{
            width:100%;
            height:58px;

            border:none;

            border-radius:18px;

            background:#F1F4EE;

            color:#667164;

            font-weight:600;
            font-size:16px;

            display:flex;
            align-items:center;
            justify-content:center;
            gap:12px;

            transition:.2s;
            cursor:pointer;
        }

        .logout button:hover{
            background:#E7ECE3;
        }

        .logout i{
            font-size:20px;
        }

        /* MAIN */

        .main{
            margin-left:260px;
            padding:35px;
        }

        .content-card{
            background:white;

            border-radius:30px;

            min-height:calc(100vh - 70px);

            padding:35px;

            box-shadow:
            0 10px 35px rgba(0,0,0,.04);
        }

        /* RESPONSIVE */

        @media(max-width:991px){

            .sidebar{
                width:100%;
                height:auto;

                position:relative;
            }

            .main{
                margin-left:0;
                padding:20px;
            }

        }

    </style>

</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">

        {{-- LOGO --}}
        <div class="logo">

            <div class="logo-icon">
                <i class="bi bi-book-half"></i>
            </div>

            <div class="logo-text">
                Lentera<br>
                Pustaka
            </div>

        </div>

        {{-- PROFILE --}}
        @if(Auth::user()->email == 'admin@perpus.com')
            <a href="{{ route('dashboard') }}" class="profile-card" style="text-decoration:none;">
        @else
            <a href="{{ route('profile.edit') }}" class="profile-card" style="text-decoration:none;">
        @endif

            <div class="profile-icon">
                <i class="bi bi-person"></i>
            </div>

            <div>

                <div class="user-name">
                    {{ Auth::user()->name ?? 'User' }}
                </div>

            </div>

        </a>


        {{-- MENU --}}
        <div class="menu">

            {{-- DASHBOARD --}}
            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <i class="bi bi-grid"></i>
                Dashboard
            </a>

            {{-- ADMIN --}}
            @if(Auth::user()->email == 'admin@perpus.com')

                <a
                    href="/bukus"
                    class="{{ request()->is('bukus*') ? 'active' : '' }}"
                >
                    <i class="bi bi-book"></i>
                    Data Buku
                </a>

            {{-- ANGGOTA --}}
            @else

                <a
                    href="/daftar-buku"
                    class="{{ request()->is('daftar-buku') ? 'active' : '' }}"
                >
                    <i class="bi bi-book"></i>
                    Daftar Buku
                </a>

            @endif

        </div>

        {{-- LOGOUT --}}
        <div class="logout">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit">

                    <i class="bi bi-box-arrow-right"></i>

                    Logout

                </button>

            </form>

        </div>

    </div>

    {{-- MAIN --}}
    <div class="main">

        <div class="content-card">

            @yield('content')

        </div>

    </div>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>