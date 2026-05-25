<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>@yield('title', 'Lentera Pustaka')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        :root{
            --bg:#F5F1EB;
            --white:#ffffff;
            --dark:#2A211C;
            --primary:#7C4F38;
            --primary-dark:#5E3928;
            --soft:#7A6A61;
            --accent:#D9A066;
            --accent-soft:#F1D4B3;
            --border:#E8DED5;

            --card: rgba(255,255,255,.82);

            --gradient-btn: linear-gradient(135deg,#7C4F38 0%,#B17457 100%);
            --shadow: 0 10px 35px rgba(0,0,0,.04);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:var(--bg);
            font-family:'Inter',sans-serif;
            color:var(--dark);
        }

        /* SIDEBAR */

        .sidebar{
            width:290px;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            background:rgba(255,255,255,.78);
            backdrop-filter: blur(14px);
            border-right:1px solid var(--border);
            padding:28px 22px;
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
            width:60px;
            height:60px;
            border-radius:20px;
            background:var(--gradient-btn);
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-size:24px;
        }

        .logo-text{
            font-family:'Cormorant Garamond', serif;
            font-size:24px;
            font-weight:700;
            line-height:1.05;
            color:var(--dark);
        }

        /* PROFILE */

        .profile-card{
            display:flex;
            align-items:center;
            gap:12px;
            padding:14px;
            border-radius:26px;
            background:rgba(241,212,179,.45);
            border:1px solid rgba(217,160,102,.25);
            margin-bottom:35px;
            text-decoration:none;
        }

        .profile-icon{
            width:52px;
            height:52px;
            border-radius:18px;
            background:white;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--primary);
            font-size:22px;
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
            border-radius:22px;
            padding:0 18px;
            display:flex;
            align-items:center;
            gap:14px;
            color:#6B5A52;
            font-weight:650;
            font-size:15.5px;
            transition:.25s;
        }

        .menu a i{
            font-size:20px;
        }

        .menu a:hover{
            background:rgba(241,212,179,.35);
            color:var(--dark);
        }

        .menu a.active{
            background:var(--gradient-btn);
            color:white;
        }

        /* LOGOUT */

        .logout{
            margin-top:auto;
        }

        .logout button{
            width:100%;
            height:58px;
            border:none;
            border-radius:22px;
            background:white;
            border:1px solid var(--border);
            color:#6B5A52;
            font-weight:650;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:12px;
        }

        /* MAIN */

        .main{
            margin-left:290px;
            padding:34px;
        }

        .content-card{
            background:rgba(255,255,255,.86);
            border-radius:34px;
            min-height:calc(100vh - 70px);
            padding:34px;
            box-shadow:var(--shadow);
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
        <a href="{{ route('profile.edit') }}"
           class="profile-card">

            <div class="profile-icon">
                <i class="bi bi-person"></i>
            </div>

            <div class="user-name">
                {{ Auth::user()->name ?? 'User' }}
            </div>

        </a>

        {{-- MENU --}}
        <div class="menu">

            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <i class="bi bi-grid"></i>
                Dashboard
            </a>

            {{-- MENU ADMIN --}}
            @if(Auth::user()->email == 'admin@perpus.com')

                <a
                    href="/bukus"
                    class="{{ request()->is('bukus*') ? 'active' : '' }}"
                >
                    <i class="bi bi-book-half"></i>
                    Kelola Buku
                </a>

                <a
                    href="/kategori"
                    class="{{ request()->is('kategori*') ? 'active' : '' }}"
                >
                    <i class="bi bi-tags"></i>
                    Kategori
                </a>

                <a
                    href="/kelola-peminjaman"
                    class="{{ request()->is('kelola-peminjaman') ? 'active' : '' }}"
                >
                    <i class="bi bi-journal-check"></i>
                    Kelola Peminjaman
                </a>

                <a
                    href="/kelola-denda"
                    class="{{ request()->is('kelola-denda') ? 'active' : '' }}"
                >
                    <i class="bi bi-cash-coin"></i>
                    Kelola Denda
                </a>

            @endif

            {{-- MENU ANGGOTA --}}
            @if(Auth::user()->email != 'admin@perpus.com')

                <a
                    href="/daftar-buku"
                    class="{{ request()->is('daftar-buku') ? 'active' : '' }}"
                >
                    <i class="bi bi-book"></i>
                    Daftar Buku
                </a>

                <a
                    href="/peminjaman"
                    class="{{ request()->is('peminjaman') ? 'active' : '' }}"
                >
                    <i class="bi bi-journal-text"></i>
                    Peminjaman Saya
                </a>

                <a
                    href="/denda"
                    class="{{ request()->is('denda') ? 'active' : '' }}"
                >
                    <i class="bi bi-wallet2"></i>
                    Denda
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