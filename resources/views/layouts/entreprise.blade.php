<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobConnect') - Espace Entreprise</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f8f9fa; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1A2340;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand span {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
        }
        .sidebar-brand small {
            display: block;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
        }
        .sidebar-nav { padding: 1rem 0; }
        .nav-section {
            padding: 0.5rem 1.5rem 0.25rem;
            font-size: 0.7rem;
            font-weight: 600;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar-nav .nav-link {
            padding: 0.65rem 1.5rem;
            color: rgba(255,255,255,0.65);
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left: 3px solid #6366f1;
        }
        .sidebar-nav .nav-link i { width: 18px; text-align: center; }
        .badge-notif {
            background: #ef4444;
            color: #fff;
            font-size: 0.65rem;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: auto;
        }

        /* Main content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .topbar-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1A2340;
        }
        .topbar-actions { display: flex; align-items: center; gap: 1rem; }
        .btn-notif {
            position: relative;
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.1rem;
            padding: 0.4rem;
        }
        .btn-notif .dot {
            position: absolute;
            top: 2px; right: 2px;
            width: 8px; height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }
        .entreprise-avatar {
            width: 36px; height: 36px;
            background: #6366f1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Page content */
        .page-content { padding: 1.5rem; }

        /* Cards */
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
            font-weight: 600;
            color: #1A2340;
        }

        /* Stat cards */
        .stat-card {
            border-radius: 12px;
            padding: 1.25rem;
            border: 1px solid #e5e7eb;
            background: #fff;
        }
        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1A2340;
        }
        .stat-card .stat-label {
            font-size: 0.82rem;
            color: #64748b;
        }

        /* Alerts */
        .alert { border-radius: 10px; border: none; }
        .alert-success { background: #f0fdf4; color: #15803d; }
        .alert-danger  { background: #fef2f2; color: #dc2626; }

        /* Buttons */
        .btn-primary {
            background: #6366f1;
            border-color: #6366f1;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }
        .btn-outline-primary {
            color: #6366f1;
            border-color: #6366f1;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-outline-primary:hover {
            background: #6366f1;
            border-color: #6366f1;
        }

        @yield('styles')
    </style>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <span>JobConnect</span>
        <small>Espace Entreprise</small>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section">Principal</div>
        <a href="{{ route('entreprise.dashboard') }}"
           class="nav-link {{ request()->routeIs('entreprise.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Tableau de bord
        </a>
        <a href="{{ route('entreprise.profil') }}"
           class="nav-link {{ request()->routeIs('entreprise.profil') ? 'active' : '' }}">
            <i class="fas fa-building"></i> Mon profil
        </a>

        <div class="nav-section mt-2">Recrutement</div>
        <a href="{{ route('entreprise.offres.index') }}"
           class="nav-link {{ request()->routeIs('entreprise.offres.*') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> Mes offres
        </a>
        <a href="{{ route('entreprise.candidatures.index') }}"
           class="nav-link {{ request()->routeIs('entreprise.candidatures.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Candidatures
        </a>

        <div class="nav-section mt-2">Communication</div>
        <a href="{{ route('entreprise.messages.index') }}"
           class="nav-link {{ request()->routeIs('entreprise.messages.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Messages
            <span class="badge-notif" id="msg-count" style="display:none"></span>
        </a>
        <a href="{{ route('entreprise.notifications.index') }}"
           class="nav-link {{ request()->routeIs('entreprise.notifications.*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Notifications
            <span class="badge-notif" id="notif-count" style="display:none"></span>
        </a>
    </div>

    <!-- Déconnexion -->
    <div style="position:absolute; bottom:0; width:100%; padding:1rem; border-top:1px solid rgba(255,255,255,0.1)">
        <form method="POST" action="{{ route('entreprise.logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent"
                style="color:rgba(255,255,255,0.5)">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </button>
        </form>
    </div>
</nav>

<!-- Main -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar">
        <span class="topbar-title">@yield('page_title', 'Dashboard')</span>
        <div class="topbar-actions">
            <button class="btn-notif">
                <i class="fas fa-bell"></i>
                <span class="dot"></span>
            </button>
            <div class="dropdown">
                <div class="entreprise-avatar dropdown-toggle" style="cursor:pointer"
                     data-bs-toggle="dropdown">
                    {{ strtoupper(substr(session('entreprise')->nom_entreprise ?? 'E', 0, 1)) }}
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('entreprise.profil') }}">
                        <i class="fas fa-user me-2"></i>Mon profil
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('entreprise.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    <div class="px-3 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page content -->
    <div class="page-content">
        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>