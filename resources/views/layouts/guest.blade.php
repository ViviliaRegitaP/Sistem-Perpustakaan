{{-- resources/views/layouts/guest.blade.php --}}

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lentera Pustaka</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        :root {
            --bg: #F5F1EB;
            --white: #FFFFFF;

            --primary: #7C4F38;
            --primary-dark: #5E3928;

            --accent: #D9A066;
            --accent-soft: #F1D4B3;

            --text: #2A211C;
            --soft: #7A6A61;

            --border: #E8DED5;

            --card: rgba(255,255,255,.82);

            --gradient-1: linear-gradient(
                135deg,
                #7C4F38 0%,
                #B17457 100%
            );

            --gradient-2: linear-gradient(
                135deg,
                #D9A066 0%,
                #F3C98B 100%
            );
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            background:
                radial-gradient(circle at top left,
                rgba(217,160,102,.12),
                transparent 35%),

                radial-gradient(circle at bottom right,
                rgba(124,79,56,.10),
                transparent 35%),

                var(--bg);

            font-family: 'Inter', sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(124,79,56,.08);
            top: -220px;
            left: -180px;
            filter: blur(100px);

            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: rgba(217,160,102,.10);
            bottom: -200px;
            right: -160px;
            filter: blur(100px);

            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1180px;
            position: relative;
            z-index: 2;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 480px;
            gap: 80px;
            align-items: center;
        }

        .left-side {
            padding-right: 40px;
            position: relative;
            z-index: 1;
        }

        .mini-line {
            width: 70px;
            height: 3px;
            border-radius: 50px;
            background: var(--gradient-2);
            margin-bottom: 40px;
        }

        .brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 82px;
            line-height: .95;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 28px;
            letter-spacing: -1px;
        }

        .brand span {
            background: var(--gradient-1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .desc {
            max-width: 480px;
            color: var(--soft);
            font-size: 16px;
            line-height: 2;
            margin-bottom: 36px;
        }

        .stats-grid {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .stat-item {
            background: rgba(255, 255, 255, .75);
            border: 1px solid rgba(255,255,255,.8);
            backdrop-filter: blur(14px);

            border-radius: 18px;
            padding: 16px 18px;

            display: flex;
            align-items: center;
            gap: 16px;

            transition: .35s ease;
        }

        .stat-item:hover {
            transform: translateY(-4px);
            box-shadow:
                0 14px 28px rgba(0,0,0,.06);
        }

        .stat-icon {
            width: 48px;
            height: 48px;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #F5E2D0,
                    #F1D4B3
                );

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;
        }

        .stat-icon i {
            font-size: 20px;
            color: var(--primary);
        }

        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: var(--soft);
            margin-top: 4px;
        }

        .login-card {
            background: var(--card);

            border: 1px solid rgba(255,255,255,.9);

            backdrop-filter: blur(24px);

            border-radius: 34px;

            padding: 55px;

            box-shadow:
                0 20px 60px rgba(0,0,0,.06);

            position: relative;
            z-index: 10;
        }

        .login-content{
            position: relative;
            z-index: 20;
        }

        .login-content a{
            position: relative;
            z-index: 30;
        }

        .login-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 54px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: var(--soft);
            font-size: 15px;
            margin-bottom: 38px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 10px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 24px;
        }

        .input-group-custom i {
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            color: #9B9B9B;
            font-size: 15px;
            z-index: 5;
        }

        .form-control {
            height: 60px;

            border-radius: 18px;

            border: 1px solid var(--border);

            background: rgba(255,255,255,.8);

            padding-left: 52px;

            font-size: 15px;

            transition: .3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: white;

            box-shadow:
                0 0 0 4px rgba(124,79,56,.10),
                0 8px 20px rgba(124,79,56,.08);
        }

        .remember-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .form-check-label {
            color: var(--soft);
            font-size: 14px;
        }

        .form-check-input:checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .forgot-link {
            text-decoration: none;
            color: var(--primary);
            font-size: 14px;
            font-weight: 600;
        }

        .btn-login {
            width: 100%;
            height: 60px;

            border: none;
            border-radius: 18px;

            background: var(--gradient-1);

            color: white;

            font-size: 15px;
            font-weight: 600;

            transition: .35s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.01);

            box-shadow:
                0 14px 30px rgba(124,79,56,.25);
        }

        .register {
            text-align: center;
            margin-top: 28px;
            color: var(--soft);
            font-size: 14px;
        }

        .register a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 700;
        }

        .copyright {
            text-align: center;
            margin-top: 28px;
            color: #9C9088;
            font-size: 13px;
        }

        @media (max-width: 991px) {

            body {
                padding: 28px;
                overflow-y: auto;
            }

            .login-container {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .left-side {
                padding-right: 0;
            }

            .brand {
                font-size: 62px;
            }

            .login-card {
                padding: 40px 30px;
            }

        }

        @media (max-width: 576px) {

            .brand {
                font-size: 50px;
            }

            .login-title {
                font-size: 42px;
            }

            .login-card {
                border-radius: 28px;
            }

        }

    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="login-container">

            <div class="left-side">

                <div class="mini-line"></div>

                <h1 class="brand">
                    Lentera<br>
                    <span>Pustaka</span>
                </h1>

                <p class="desc">
                    Sistem perpustakaan yang dirancang untuk
                    pengelolaan koleksi buku dengan lebih efisien
                </p>

                <div class="stats-grid">

                    <div class="stat-item">

                        <div class="stat-icon">
                            <i class="bi bi-book"></i>
                        </div>

                        <div>
                            <div class="stat-num">
                                {{ $totalBuku ?? '1.200 +' }}
                            </div>

                            <div class="stat-label">
                                Koleksi buku tersedia
                            </div>
                        </div>

                    </div>

                    <div class="stat-item">

                        <div class="stat-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <div class="stat-num">
                                {{ $totalAnggota ?? '230' }}
                            </div>

                            <div class="stat-label">
                                Anggota aktif terdaftar
                            </div>
                        </div>

                    </div>

                    <div class="stat-item">

                        <div class="stat-icon">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>

                        <div>
                            <div class="stat-num">
                                {{ $totalPeminjaman ?? '165' }}
                            </div>

                            <div class="stat-label">
                                Peminjaman bulan ini
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="login-card">

                <div class="login-content">
                    @yield('content')
                </div>

                <div class="copyright">
                    © {{ date('Y') }} Lentera Pustaka
                </div>

            </div>

        </div>

    </div>

</body>

</html>