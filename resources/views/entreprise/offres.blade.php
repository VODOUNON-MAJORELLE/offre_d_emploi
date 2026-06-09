<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes Offres — {{ $entreprise->nom_entreprise ?? 'Entreprise' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.07);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--pink:#ec4899;--teal:#06b6d4;--orange:#f59e0b;
  --r:12px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh;padding:0}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;max-width:1060px;margin:0 auto 24px}
.page-title{font-size:22px;font-weight:700}
.page-sub{font-size:13px;color:var(--t2);margin-top:3px}
.btn-create{display:inline-flex;align-items:center;gap:7px;padding:11px 20px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;border:none;border-radius:var(--rs);font-size:14px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s;white-space:nowrap;text-decoration:none}
.btn-create:hover{opacity:.88}

.wrap{max-width:1060px;margin:0 auto;padding:32px 28px 48px}

/* NAV ENTREPRISE */
nav.entreprise-nav{background:#fff;border-bottom:0.5px solid #e0e0e0;padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100; margin-bottom: 24px;}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px;text-decoration:none;color:#1a1a2e}
.logo-av{width:30px;height:30px;border-radius:8px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:#6b7280;cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px}
.nav-link:hover{color:#1a1a2e}
.nav-link.active{color:#5b4be8;font-weight:600;border-bottom:2px solid #5b4be8}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:#6b7280;text-decoration:none}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
.user-av{width:32px;height:32px;border-radius:50%;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:#9ca3af;transition:color .12s}
.logout-btn:hover{color:#1a1a2e}

@media (max-width: 720px) {
  nav.entreprise-nav { padding: 0 16px; margin-bottom: 24px; }
}

/* Offres list */
.card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:20px}
.section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.section-title{font-size:15px;font-weight:700}

.offre-item{display:flex;align-items:center;gap:12px;padding:12px;border-radius:var(--rs);background:#fafafa;border:0.5px solid var(--border);margin-bottom:8px;text-decoration:none;color:inherit}
.offre-item:last-child{margin-bottom:0}
.offre-item:hover{background:#f5f6fa}
.offre-avatar{width:40px;height:40px;border-radius:7px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0}
.offre-info{flex:1}
.offre-name{font-size:14px;font-weight:500}
.offre-meta{font-size:12px;color:var(--t3);margin-top:2px}
.offre-actions{display:flex;gap:8px}
.icon-btn{background:none;border:none;cursor:pointer;color:var(--t3);font-size:16px;padding:2px;transition:color .15s}
.icon-btn:hover{color:var(--accent)}

.badge{display:inline-block;padding:3px 8px;border-radius:99px;font-size:11px;font-weight:500}
.badge-active{background:#d1fae5;color:#065f46}
.badge-suspend{background:#fef3c7;color:#92400e}
.badge-close{background:#fee2e2;color:#991b1b}
</style>
</head>
<body>

<nav class="entreprise-nav">
  <div class="nav-left">
    <div class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </div>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
      <a class="nav-link" href="{{ route('entreprise.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
      $unreadNotifCount = \App\Models\Notification::where('id_entreprise', $entreprise->id_entreprise)->where('statut_lecture', 'non lu')->count();
      $initials = substr($entreprise->nom_entreprise ?? 'TV', 0, 2);
    @endphp
    <a href="{{ route('notifications.index') }}" class="notif-btn">
      <i class="ti ti-bell"></i>
      @if($unreadNotifCount > 0)
        <span class="notif-badge">{{ $unreadNotifCount }}</span>
      @endif
    </a>
    @if($entreprise->logo_entreprise)
      <div class="user-av" style="background-image: url('{{ asset('storage/' . $entreprise->logo_entreprise) }}'); background-size: cover; background-position: center;"></div>
    @else
      <div class="user-av">{{ $initials }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<div class="wrap">
  <div class="page-header">
    <div>
      <a href="{{ route('entreprise.dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; color: var(--t2); font-size: 13px; text-decoration: none; margin-bottom: 8px;"><i class="ti ti-arrow-left"></i> Retour au dashboard</a>
      <div class="page-title">Mes Offres</div>
      <div class="page-sub">Gérez toutes vos offres d'emploi.</div>
    </div>
    <a href="{{ route('entreprise.offres.create') }}" class="btn-create"><i class="ti ti-plus"></i> Créer une offre</a>
  </div>

  <div class="card">
    <div class="section-header">
      <div class="section-title">Toutes les offres</div>
    </div>
    @php
      $offres = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)
        ->orderByDesc('date_publication')
        ->get();
    @endphp
    @if($offres->count() > 0)
      @foreach($offres as $offre)
        @php
          $nbCandidats = \App\Models\Candidature::where('id_offre', $offre->id_offre)->count();
          $initials = substr($offre->titre_offre, 0, 1);
          $colors = ['#5b4be8', '#ec4899', '#10b981', '#f59e0b', '#06b6d4'];
          $color = $colors[array_rand($colors)];
          
          $badgeClass = 'badge-active';
          $badgeText = 'Active';
          if ($offre->statut_offre === 'suspendue') {
            $badgeClass = 'badge-suspend';
            $badgeText = 'Suspendue';
          } elseif ($offre->statut_offre === 'clôturée') {
            $badgeClass = 'badge-close';
            $badgeText = 'Clôturée';
          }
        @endphp
        <div class="offre-item">
          <div class="offre-avatar" style="background:{{ $color }}">{{ $initials }}</div>
          <div class="offre-info">
            <div class="offre-name">{{ $offre->titre_offre }} <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span></div>
            <div class="offre-meta">{{ $nbCandidats }} candidats · {{ $offre->ville_poste ?? 'Non spécifié' }} · Il y a {{ $offre->date_publication->diffForHumans() }}</div>
          </div>
          <div class="offre-actions">
            <a href="{{ route('entreprise.offres.edit', ['id_offre' => $offre->id_offre]) }}" class="icon-btn" title="Modifier l'offre"><i class="ti ti-edit"></i></a>
            <a href="{{ route('entreprise.offres.detail', ['id_offre' => $offre->id_offre]) }}" class="icon-btn" title="Voir le détail"><i class="ti ti-eye"></i></a>
            <a href="{{ route('entreprise.offres.candidatures', ['id_offre' => $offre->id_offre]) }}" class="icon-btn" title="Voir les candidatures"><i class="ti ti-users"></i></a>
          </div>
        </div>
      @endforeach
    @else
      <div style="text-align: center; padding: 40px; color: var(--t3); font-size: 13px;">
        <div style="font-size: 48px; margin-bottom: 12px;">📭</div>
        <div>Aucune offre publiée pour le moment</div>
        <div style="margin-top: 8px;">Créez votre première offre pour commencer à recruter.</div>
      </div>
    @endif
  </div>
</div>
</body>
</html>
