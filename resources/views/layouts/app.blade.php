<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Talentlink - Plateforme de Recrutement')</title>
    <!-- Instrument Sans Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/sass/app.scss'])

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        body {
            font-family: 'Instrument Sans', 'Outfit', sans-serif;
            background-color: #f7f9fc;
            color: #1e1e2f;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .navbar-talentlink {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(78, 68, 231, 0.1);
        }

        .brand-logo {
            font-weight: 700;
            color: #4e44e7;
            font-size: 1.4rem;
        }

        .btn-primary {
            background-color: #4e44e7;
            border-color: #4e44e7;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #3b31c4;
            border-color: #3b31c4;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(78, 68, 231, 0.25);
        }

        .card-glass {
            background: #ffffff;
            border: 1px solid rgba(78, 68, 231, 0.08);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .card-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(78, 68, 231, 0.05);
        }

        footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid rgba(78, 68, 231, 0.08);
        }

        /* PREMIUM NAV STYLES */
        nav.candidat-nav, nav.entreprise-nav {
            background: #fff;
            border-bottom: 0.5px solid rgba(78, 68, 231, 0.1);
            padding: 0 28px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            margin-bottom: 0px;
        }
        .nav-left {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            color: #1a1a2e;
        }
        .logo-av {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #7c6ff0, #5b4be8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
        }
        .nav-links {
            display: flex;
            gap: 24px;
        }
        .nav-link {
            font-size: 13px;
            color: #6b7280;
            cursor: pointer;
            text-decoration: none;
            transition: color .12s;
            padding-bottom: 2px;
        }
        .nav-link:hover {
            color: #1a1a2e;
        }
        .nav-link.active {
            color: #5b4be8;
            font-weight: 600;
            border-bottom: 2px solid #5b4be8;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .notif-btn {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #6b7280;
        }
        .notif-dot {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3b82f6;
            border: 1.5px solid #fff;
        }
        .user-av {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #7c6ff0, #5b4be8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
        }
        .logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #9ca3af;
            transition: color .12s;
        }
        .logout-btn:hover {
            color: #1a1a2e;
        }
        @media (max-width: 720px) {
            nav.candidat-nav, nav.entreprise-nav { padding: 0 16px; }
        }
    </style>
</head>
<body>

    <!-- Dynamic Header / Navbar -->
    @if(Auth::guard('entreprise')->check())
        <nav class="entreprise-nav">
          <div class="nav-left">
            <div class="nav-logo">
              <div class="logo-av">JR</div>
              <span>Talentlink</span>
            </div>
            <div class="nav-links">
              <a class="nav-link {{ request()->routeIs('entreprise.dashboard') ? 'active' : '' }}" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
              <a class="nav-link {{ request()->routeIs('entreprise.profil') ? 'active' : '' }}" href="{{ route('entreprise.profil') }}">Profil</a>
              <a class="nav-link {{ request()->routeIs('messagerie.*') ? 'active' : '' }}" href="{{ route('messagerie.index') }}">Messagerie</a>
            </div>
          </div>
          <div class="nav-right">
            <button class="notif-btn"><i class="ti ti-bell"></i><div class="notif-dot"></div></button>
            @php
              $entreprise = Auth::guard('entreprise')->user();
              $initials = substr($entreprise->nom_entreprise ?? 'TV', 0, 2);
            @endphp
            <div class="user-av">{{ $initials }}</div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
            </form>
          </div>
        </nav>
    @elseif(Auth::guard('candidat')->check())
        <nav class="candidat-nav">
          <div class="nav-left">
            <a href="/" class="nav-logo">
              <div class="logo-av">JR</div>
              <span>Talentlink</span>
            </a>
            <div class="nav-links">
              <a class="nav-link" href="/">Feed</a>
              <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
              <a class="nav-link {{ request()->routeIs('candidat.dashboard') ? 'active' : '' }}" href="{{ route('candidat.dashboard') }}">Candidatures</a>
              <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
            </div>
          </div>
          <div class="nav-right">
            <button class="notif-btn"><i class="ti ti-bell"></i><div class="notif-dot"></div></button>
            @php
              $candidatInfo = Auth::guard('candidat')->user();
              $candidatInitials = substr($candidatInfo->prenom, 0, 1) . substr($candidatInfo->nom, 0, 1);
            @endphp
            <div class="user-av">{{ $candidatInitials }}</div>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
            </form>
          </div>
        </nav>
    @else
        <nav class="navbar navbar-expand-lg navbar-talentlink sticky-top py-3">
            <div class="container">
                <a class="navbar-brand brand-logo d-flex align-items-center" href="/">
                    <span class="badge bg-primary me-2" style="font-size: 0.9rem; padding: 0.5em 0.7em;">TL</span>
                    Talentlink
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-dark px-3" href="/messagerie">
                                <i class="bi bi-chat-dots me-1"></i> Messagerie
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show card-glass border-success p-3 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="fs-4 me-2">✅</span>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show card-glass border-danger p-3 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <span class="fs-4 me-2">❌</span>
                        <div>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-muted">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Talentlink. Tous droits réservés. Projet de fin d'études ESGIS.</p>
        </div>
    </footer>

</body>
</html>
