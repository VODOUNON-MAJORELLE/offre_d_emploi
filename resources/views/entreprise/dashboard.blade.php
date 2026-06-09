<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — {{ $entreprise->nom_entreprise ?? 'Entreprise' }}</title>
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

/* KPI cards */
.kpi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:16px}
.kpi{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:18px 18px 14px;position:relative;overflow:hidden}
.kpi-label{font-size:10px;font-weight:600;letter-spacing:.08em;color:var(--t2);text-transform:uppercase;margin-bottom:10px;display:flex;justify-content:space-between;align-items:center}
.kpi-icon{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:15px}
.kpi-value{font-size:30px;font-weight:700;line-height:1;margin-bottom:5px}
.kpi-delta{font-size:12px;color:var(--t3)}
.kpi-bar{position:absolute;bottom:0;left:0;right:0;height:3px}
.kpi:nth-child(1) .kpi-icon{background:#eeedf9;color:var(--accent)}
.kpi:nth-child(1) .kpi-bar{background:linear-gradient(90deg,var(--accent2),var(--accent))}
.kpi:nth-child(2) .kpi-icon{background:#ecfdf5;color:var(--green)}
.kpi:nth-child(2) .kpi-bar{background:var(--green)}
.kpi:nth-child(3) .kpi-icon{background:#fdf4ff;color:#a855f7}
.kpi:nth-child(3) .kpi-bar{background:#a855f7}

/* Charts row */
.charts-row{display:grid;grid-template-columns:1fr;gap:14px;margin-bottom:16px}
.card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:20px}
.card-title{font-size:15px;font-weight:700;margin-bottom:4px}

/* SVG line chart */
.chart-area{width:100%;overflow:hidden}

/* Bottom row */
.bottom-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.section-title{font-size:15px;font-weight:700}
.voir-tout{font-size:12px;color:var(--accent);cursor:pointer;display:flex;align-items:center;gap:2px;text-decoration:none}

/* Offres list */
.offre-item{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:var(--rs);background:#fafafa;border:0.5px solid var(--border);margin-bottom:8px;text-decoration:none;color:inherit}
.offre-item:last-child{margin-bottom:0}
.offre-item:hover{background:#f5f6fa}
.offre-avatar{width:36px;height:36px;border-radius:7px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0}
.offre-info{flex:1}
.offre-name{font-size:13px;font-weight:500}
.offre-meta{font-size:11px;color:var(--t3);margin-top:2px}
.offre-actions{display:flex;gap:8px}
.icon-btn{background:none;border:none;cursor:pointer;color:var(--t3);font-size:16px;padding:2px;transition:color .15s}
.icon-btn:hover{color:var(--accent)}

/* Top candidats */
.cand-item{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:0.5px solid var(--border);text-decoration:none;color:inherit}
.cand-item:last-child{border:none;padding-bottom:0}
.cand-avatar{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;position:relative}
.cand-badge{position:absolute;top:-4px;right:-4px;width:14px;height:14px;border-radius:50%;background:var(--accent);border:1.5px solid #fff;display:flex;align-items:center;justify-content:center;font-size:7px;color:#fff;font-weight:700}
.cand-info{flex:1}
.cand-name{font-size:13px;font-weight:500}
.cand-exp{font-size:11px;color:var(--t3);margin-top:1px}
.score-val{font-size:14px;font-weight:700;color:var(--accent);display:flex;align-items:center;gap:3px}

@media(max-width:768px){.kpi-grid{grid-template-columns:1fr}.charts-row,.bottom-row{grid-template-columns:1fr}}
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
      <a class="nav-link active" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
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
      <div class="page-title">Dashboard</div>
      <div class="page-sub">Bienvenue, {{ $entreprise->nom_entreprise ?? 'Entreprise' }} — vue d'ensemble de votre recrutement.</div>
    </div>
    <a href="{{ route('entreprise.offres.create') }}" class="btn-create"><i class="ti ti-plus"></i> Créer une offre</a>
  </div>

  {{-- Success Message --}}
  @if(session('success'))
  <div style="background: #d1fae5; border: 0.5px solid #10b981; border-radius: var(--r); padding: 12px 16px; margin-bottom: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
      <span style="font-size: 18px;">✅</span>
      <div style="font-size: 13px; color: #065f46;">{{ session('success') }}</div>
    </div>
  </div>
  @endif

  <!-- KPI -->
  @php
            $offresActives = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)
            ->where('statut_offre', 'active')
            ->count();
    $totalCandidatures = \App\Models\Candidature::whereIn('id_offre', 
        \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->pluck('id_offre')
    )->count();
    $entretiensPlanifies = \App\Models\ProgressionCandidature::whereIn('id_candidature',
        \App\Models\Candidature::whereIn('id_offre',
            \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->pluck('id_offre')
        )->pluck('id_candidature')
    )->where('statut_etape', 'en_cours')->count();
  @endphp
  <div class="kpi-grid">
    <div class="kpi">
      <div class="kpi-label">Offres actives <div class="kpi-icon"><i class="ti ti-briefcase"></i></div></div>
      <div class="kpi-value">{{ $offresActives }}</div>
      <div class="kpi-delta">Total</div>
      <div class="kpi-bar"></div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Candidatures reçues <div class="kpi-icon"><i class="ti ti-users"></i></div></div>
      <div class="kpi-value">{{ $totalCandidatures }}</div>
      <div class="kpi-delta">Total</div>
      <div class="kpi-bar"></div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Entretiens planifiés <div class="kpi-icon"><i class="ti ti-calendar"></i></div></div>
      <div class="kpi-value">{{ $entretiensPlanifies }}</div>
      <div class="kpi-delta">En cours</div>
      <div class="kpi-bar"></div>
    </div>
  </div>

  <!-- Charts -->
  <div class="charts-row">
    <div class="card">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px">
        <div class="card-title">Candidatures par mois</div>
      </div>
      @php
        // Récupérer les candidatures par mois pour les 6 derniers mois
        $candidaturesByMonth = \App\Models\Candidature::whereIn('id_offre',
            \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->pluck('id_offre')
        )
        ->selectRaw('DATE_FORMAT(date_soumission, "%Y-%m") as month, COUNT(*) as count')
        ->where('date_soumission', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Créer un tableau avec tous les mois des 6 derniers mois
        $months = [];
        $data = [];
        $monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $months[] = $monthNames[$date->format('n') - 1];
            $count = $candidaturesByMonth->where('month', $monthKey)->first()->count ?? 0;
            $data[] = $count;
        }

        $maxValue = max($data) > 0 ? max($data) : 1;
      @endphp
      <div class="chart-area">
        <svg viewBox="0 0 560 200" xmlns="http://www.w3.org/2000/svg" width="100%">
          <defs>
            <linearGradient id="grad1" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#5b4be8" stop-opacity="0.18"/>
              <stop offset="100%" stop-color="#5b4be8" stop-opacity="0"/>
            </linearGradient>
          </defs>
          <!-- Y axis labels -->
          <text x="4" y="18" font-size="10" fill="#9ca3af">{{ $maxValue }}</text>
          <text x="4" y="58" font-size="10" fill="#9ca3af">{{ round($maxValue * 0.75) }}</text>
          <text x="4" y="98" font-size="10" fill="#9ca3af">{{ round($maxValue * 0.5) }}</text>
          <text x="4" y="138" font-size="10" fill="#9ca3af">{{ round($maxValue * 0.25) }}</text>
          <text x="4" y="178" font-size="10" fill="#9ca3af">0</text>
          <!-- Grid lines -->
          <line x1="32" y1="15" x2="555" y2="15" stroke="#f0f2f7" stroke-width="1"/>
          <line x1="32" y1="55" x2="555" y2="55" stroke="#f0f2f7" stroke-width="1"/>
          <line x1="32" y1="95" x2="555" y2="95" stroke="#f0f2f7" stroke-width="1"/>
          <line x1="32" y1="135" x2="555" y2="135" stroke="#f0f2f7" stroke-width="1"/>
          <line x1="32" y1="175" x2="555" y2="175" stroke="#f0f2f7" stroke-width="1"/>
          @php
            $points = [];
            $areaPoints = [];
            $xStep = 516 / 5; // 555 - 36 - 3 = 516, divided by 5 intervals
            foreach ($data as $index => $value) {
              $x = 36 + ($index * $xStep);
              $y = 175 - (($value / $maxValue) * 160);
              $points[] = "$x $y";
              $areaPoints[] = "$x $y";
            }
            $pointsStr = implode(' L ', $points);
            $areaPointsStr = implode(' L ', $areaPoints);
          @endphp
          <!-- Area fill -->
          <path d="M {{ $areaPointsStr }} L 552 175 L 36 175 Z" fill="url(#grad1)"/>
          <!-- Line -->
          <path d="M {{ $pointsStr }}" fill="none" stroke="#5b4be8" stroke-width="2.5" stroke-linejoin="round"/>
          <!-- X labels -->
          @foreach($months as $index => $month)
            <text x="{{ 36 + ($index * $xStep) }}" y="192" font-size="10" fill="#9ca3af" text-anchor="middle">{{ $month }}</text>
          @endforeach
        </svg>
      </div>
    </div>

  </div>

  <!-- Bottom -->
  <div class="bottom-row">
    <div class="card">
      <div class="section-header">
        <div class="section-title">Offres actives</div>
        <a href="{{ route('entreprise.offres.index') }}" class="voir-tout">Voir tout <i class="ti ti-chevron-right"></i></a>
      </div>
      @php
                $offres = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)
            ->where('statut_offre', 'active')
            ->orderByDesc('date_publication')
            ->limit(3)
            ->get();
      @endphp
      @if($offres->count() > 0)
        @foreach($offres as $offre)
          @php
            $nbCandidats = \App\Models\Candidature::where('id_offre', $offre->id_offre)->count();
            $initials = substr($offre->titre_offre, 0, 1);
            $colors = ['#5b4be8', '#ec4899', '#10b981', '#f59e0b', '#06b6d4'];
            $color = $colors[array_rand($colors)];
          @endphp
          <div class="offre-item">
            <div class="offre-avatar" style="background:{{ $color }}">{{ $initials }}</div>
            <div class="offre-info">
              <div class="offre-name">{{ $offre->titre_offre }}</div>
              <div class="offre-meta">{{ $nbCandidats }} candidats · Il y a {{ $offre->date_publication->diffForHumans() }}</div>
            </div>
            <div class="offre-actions">
              <a href="{{ route('entreprise.offres.edit', ['id_offre' => $offre->id_offre]) }}" class="icon-btn" title="Modifier l'offre"><i class="ti ti-edit"></i></a>
              <a href="{{ route('entreprise.offres.detail', ['id_offre' => $offre->id_offre]) }}" class="icon-btn" title="Voir le détail"><i class="ti ti-eye"></i></a>
            </div>
          </div>
        @endforeach
      @else
        <div style="text-align: center; padding: 20px; color: var(--t3); font-size: 13px;">
          Aucune offre active pour le moment
        </div>
      @endif
    </div>

    <div class="card">
      <div class="section-header">
        <div class="section-title">Top Candidats</div>
      </div>
      @php
        $topCandidats = \App\Models\Candidature::with(['candidat', 'offre'])
            ->whereIn('id_offre', \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->pluck('id_offre'))
            ->orderByDesc('score_final')
            ->limit(4)
            ->get();
      @endphp
      @if($topCandidats->count() > 0)
        @foreach($topCandidats as $index => $candidature)
          @php
            $candidat = $candidature->candidat;
            $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
            $anneesExp = $candidat->annees_experience ?? 0;
          @endphp
          <a href="{{ route('entreprise.offres.detail', ['id_offre' => $candidature->id_offre]) }}" class="cand-item">
            <div class="cand-avatar" style="background:#374151">{{ $initials }}
              @if($index === 0)
                <div class="cand-badge">{{ $index + 1 }}</div>
              @endif
            </div>
            <div class="cand-info"><div class="cand-name">{{ $candidat->prenom }} {{ $candidat->nom }}</div><div class="cand-exp">{{ $anneesExp }} ans</div></div>
            <div class="score-val"><i class="ti ti-trending-up" style="font-size:13px"></i>{{ round($candidature->score_final ?? 0) }}%</div>
          </a>
        @endforeach
      @else
        <div style="text-align: center; padding: 20px; color: var(--t3); font-size: 13px;">
          Aucun candidat pour le moment
        </div>
      @endif
    </div>
  </div>
</div>
</body>
</html>
