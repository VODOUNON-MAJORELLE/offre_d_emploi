<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $entreprise->nom_entreprise }} — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--r:14px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px;text-decoration:none;color:var(--t1)}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px}
.nav-link:hover{color:var(--t1)}
.nav-link.active{color:var(--accent);font-weight:600;border-bottom:2px solid var(--accent)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--t2)}
.notif-dot{position:absolute;top:2px;right:2px;width:7px;height:7px;border-radius:50%;background:#3b82f6;border:1.5px solid #fff}
.user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* PAGE */
.page{max-width:780px;margin:0 auto;padding:32px 20px 60px}

/* HERO */
.hero{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);overflow:hidden;margin-bottom:16px}
.hero-banner{height:120px;background:linear-gradient(135deg,#7c6ff0,#5b4be8,#4338ca);position:relative}
.hero-body{padding:0 28px 24px;position:relative}
.hero-logo{width:72px;height:72px;border-radius:16px;background:#fff;border:3px solid #fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:var(--accent);position:relative;top:-36px;margin-bottom:-24px;box-shadow:0 4px 12px rgba(0,0,0,.08)}
.hero-name{font-size:22px;font-weight:800;margin-bottom:4px}
.hero-tagline{font-size:14px;color:var(--t2);margin-bottom:12px}
.hero-meta{display:flex;flex-wrap:wrap;gap:16px}
.meta-item{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--t2)}
.meta-item i{font-size:16px;color:var(--t3)}

/* CARD */
.card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:22px 24px;margin-bottom:14px}
.card-title{font-size:16px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:8px}
.card-title i{color:var(--accent);font-size:18px}

/* ABOUT */
.about-text{font-size:14px;color:var(--t2);line-height:1.7}

/* TAGS */
.tags{display:flex;flex-wrap:wrap;gap:8px}
.tag{background:var(--accent-light);color:var(--accent);font-size:12px;font-weight:500;padding:5px 14px;border-radius:99px}

/* OFFRES */
.offre-item{display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:var(--rs);background:#fafafa;border:0.5px solid var(--border);margin-bottom:8px;text-decoration:none;color:inherit;transition:background .12s}
.offre-item:last-child{margin-bottom:0}
.offre-item:hover{background:#f0f1f5}
.offre-av{width:40px;height:40px;border-radius:10px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;flex-shrink:0}
.offre-info{flex:1}
.offre-name{font-size:14px;font-weight:600;margin-bottom:2px}
.offre-meta-line{font-size:12px;color:var(--t3)}
.offre-badge{font-size:11px;font-weight:500;padding:4px 12px;border-radius:99px;background:#dcfce7;color:#16a34a;white-space:nowrap}

/* STATS */
.stats-row{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.stat-box{background:#fafafa;border:0.5px solid var(--border);border-radius:var(--rs);padding:14px;text-align:center}
.stat-num{font-size:22px;font-weight:700;color:var(--accent)}
.stat-lbl{font-size:11px;color:var(--t3);margin-top:3px}

/* BACK BTN */
.back-btn{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--t2);text-decoration:none;margin-bottom:16px;transition:color .12s}
.back-btn:hover{color:var(--t1)}

@media(max-width:640px){
  .page{padding:16px}
  .stats-row{grid-template-columns:1fr 1fr}
  .hero-body{padding:0 16px 18px}
}
</style>
</head>
<body>

<nav>
  <div class="nav-left">
    <a href="/" class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </a>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('candidat.feed') }}">Feed</a>
      <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    <button class="notif-btn"><i class="ti ti-bell"></i><div class="notif-dot"></div></button>
    @php
      $candidat = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
      $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
    @endphp
    <div class="user-av">{{ $initials }}</div>
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<div class="page">

  <a href="{{ url()->previous() }}" class="back-btn"><i class="ti ti-arrow-left"></i> Retour</a>

  <!-- Hero -->
  <div class="hero">
    <div class="hero-banner"></div>
    <div class="hero-body">
      <div class="hero-logo">{{ strtoupper(substr($entreprise->nom_entreprise, 0, 2)) }}</div>
      <div class="hero-name">{{ $entreprise->nom_entreprise }}</div>
      <div class="hero-tagline">{{ $entreprise->secteur_activite ?? 'Entreprise' }}</div>
      <div class="hero-meta">
        @if($entreprise->ville)
          <div class="meta-item"><i class="ti ti-map-pin"></i>{{ $entreprise->ville }}</div>
        @endif
        @if($entreprise->site_web)
          <div class="meta-item"><i class="ti ti-world"></i>{{ $entreprise->site_web }}</div>
        @endif
        @if($entreprise->taille_entreprise)
          <div class="meta-item"><i class="ti ti-users"></i>{{ $entreprise->taille_entreprise }} employés</div>
        @endif
        <div class="meta-item"><i class="ti ti-briefcase"></i>{{ $offres->count() }} offre(s) active(s)</div>
      </div>
    </div>
  </div>

  <!-- À propos -->
  @if($entreprise->description)
  <div class="card">
    <div class="card-title"><i class="ti ti-info-circle"></i> À propos</div>
    <div class="about-text">{{ $entreprise->description }}</div>
  </div>
  @endif

  <!-- Valeurs / Avantages -->
  @if($entreprise->avantages)
  <div class="card">
    <div class="card-title"><i class="ti ti-star"></i> Avantages</div>
    <div class="tags">
      @foreach(explode(',', $entreprise->avantages) as $avantage)
        @if(trim($avantage))
          <span class="tag">{{ trim($avantage) }}</span>
        @endif
      @endforeach
    </div>
  </div>
  @endif

  <!-- Statistiques -->
  <div class="card">
    <div class="card-title"><i class="ti ti-chart-bar"></i> En chiffres</div>
    <div class="stats-row">
      <div class="stat-box">
        <div class="stat-num">{{ $offres->count() }}</div>
        <div class="stat-lbl">Offres actives</div>
      </div>
      <div class="stat-box">
        @php
          $nbCandidatures = \App\Models\Candidature::whereIn('id_offre', $offres->pluck('id_offre'))->count();
        @endphp
        <div class="stat-num">{{ $nbCandidatures }}</div>
        <div class="stat-lbl">Candidatures reçues</div>
      </div>
      <div class="stat-box">
        <div class="stat-num">{{ $entreprise->created_at ? $entreprise->created_at->format('Y') : '—' }}</div>
        <div class="stat-lbl">Membre depuis</div>
      </div>
    </div>
  </div>

  <!-- Offres actives -->
  @if($offres->count() > 0)
  <div class="card">
    <div class="card-title"><i class="ti ti-briefcase"></i> Offres actives</div>
    @foreach($offres as $offre)
      <a href="{{ route('candidat.offres.postuler', ['id_offre' => $offre->id_offre]) }}" class="offre-item">
        <div class="offre-av"><i class="ti ti-briefcase"></i></div>
        <div class="offre-info">
          <div class="offre-name">{{ $offre->titre_offre }}</div>
          <div class="offre-meta-line">{{ $offre->type_contrat ?? 'Non spécifié' }} · {{ $offre->ville ?? 'Non spécifié' }}</div>
        </div>
        <span class="offre-badge">Active</span>
      </a>
    @endforeach
  </div>
  @endif

  <!-- Contacter -->
  <div class="card" style="text-align:center;">
    <div class="card-title" style="justify-content:center"><i class="ti ti-message-circle"></i> Contacter cette entreprise</div>
    <a href="{{ route('messagerie.show', ['id_partner' => $entreprise->id_entreprise]) }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;border:none;border-radius:var(--rs);font-size:14px;font-weight:500;text-decoration:none;transition:opacity .15s">
      <i class="ti ti-send"></i> Ouvrir la messagerie
    </a>
  </div>

</div>

</body>
</html>
