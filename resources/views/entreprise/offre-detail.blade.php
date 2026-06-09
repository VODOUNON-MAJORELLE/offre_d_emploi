<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Détail offre — {{ $offre->titre_offre ?? 'Offre' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.07);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--green-light:#d1fae5;
  --pink:#ec4899;--pink-light:#fce7f3;
  --orange:#f59e0b;--orange-light:#fef3c7;
  --red:#ef4444;--red-light:#fee2e2;
  --purple:#a855f7;--purple-light:#f3e8ff;
  --r:12px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh;padding:0}
.wrap{max-width:900px;margin:0 auto;padding:28px 24px 48px}

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
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:#6b7280}
.notif-dot{position:absolute;top:2px;right:2px;width:7px;height:7px;border-radius:50%;background:#3b82f6;border:1.5px solid #fff}
.user-av{width:32px;height:32px;border-radius:50%;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:#9ca3af;transition:color .12s}
.logout-btn:hover{color:#1a1a2e}

@media (max-width: 720px) {
  nav.entreprise-nav { padding: 0 16px; margin-bottom: 24px; }
}

.back-link{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--t2);margin-bottom:18px;cursor:pointer;text-decoration:none;transition:color .12s}
.back-link:hover{color:var(--t1)}

/* Offre header card */
.offre-card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:22px 24px;margin-bottom:14px}
.offre-top{display:flex;align-items:flex-start;gap:16px;margin-bottom:20px}
.offre-avatar{width:52px;height:52px;border-radius:10px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;flex-shrink:0}
.offre-title{font-size:20px;font-weight:700;margin-bottom:5px}
.offre-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.meta-item{display:flex;align-items:center;gap:4px;font-size:12px;color:var(--t2)}
.badge-cdi{background:#d1fae5;color:#065f46;font-size:11px;font-weight:600;padding:3px 9px;border-radius:99px}
.modifier-btn{margin-left:auto;display:inline-flex;align-items:center;gap:6px;padding:9px 16px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:13px;font-weight:500;font-family:inherit;color:var(--t1);cursor:pointer;transition:background .12s;white-space:nowrap}
.modifier-btn:hover{background:#f5f6fa}

.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:0;border-top:0.5px solid var(--border);padding-top:18px;text-align:center}
.stat-item{padding:0 12px;border-right:0.5px solid var(--border)}
.stat-item:last-child{border:none}
.stat-val{font-size:24px;font-weight:700;margin-bottom:4px}
.stat-val.blue{color:var(--accent)}
.stat-val.purple{color:var(--purple)}
.stat-val.teal{color:#06b6d4}
.stat-val.green{color:var(--green)}
.stat-label{font-size:12px;color:var(--t2)}

/* Table card */
.table-card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:20px 24px}
.table-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;gap:12px;flex-wrap:wrap}
.table-title{font-size:16px;font-weight:700;display:flex;align-items:center;gap:8px}
.table-title i{font-size:18px;color:var(--accent)}
.filter-row{display:flex;align-items:center;gap:10px}
.filter-btn{display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:12px;color:var(--t2);cursor:pointer;font-family:inherit;transition:background .12s}
.filter-btn:hover{background:#f5f6fa}
.search-input{border:0.5px solid var(--border);border-radius:var(--rs);padding:7px 12px;font-size:12px;font-family:inherit;color:var(--t1);outline:none;width:160px;transition:border-color .15s}
.search-input:focus{border-color:var(--accent)}

/* Table */
table{width:100%;border-collapse:collapse}
thead th{font-size:10px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--t3);padding:0 10px 10px;text-align:left;border-bottom:0.5px solid var(--border)}
tbody tr{border-bottom:0.5px solid var(--border);transition:background .1s}
tbody tr:last-child{border:none}
tbody tr:hover{background:#fafbff}
td{padding:13px 10px;vertical-align:middle}

.rank-badge{width:24px;height:24px;border-radius:50%;background:var(--accent);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center}
.rank-badge.grey{background:#e5e7eb;color:var(--t2)}

.cand-cell{display:flex;align-items:center;gap:10px}
.cand-av{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
.cand-name{font-size:13px;font-weight:500}
.cand-sub{font-size:11px;color:var(--t3);margin-top:1px}

.exp-text{font-size:13px;color:var(--t1)}

/* Status badges */
.status{font-size:11px;font-weight:500;padding:4px 10px;border-radius:99px;white-space:nowrap}
.s-encours{background:var(--green-light);color:#065f46}
.s-entretien{background:#e0f2fe;color:#0369a1}
.s-refuse{background:var(--red-light);color:#991b1b}
.s-preselect{background:var(--purple-light);color:#6b21a8}
.s-nouveau{background:#f3f4f6;color:var(--t2)}

/* Score bar */
.score-cell{display:flex;align-items:center;gap:8px}
.score-bar-wrap{width:80px;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden}
.score-bar-fill{height:100%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:99px}
.score-num{font-size:12px;font-weight:700;color:var(--accent);display:flex;align-items:center;gap:2px;white-space:nowrap}

/* Action buttons */
.actions-cell{display:flex;align-items:center;gap:6px}
.btn-voir{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:var(--accent);color:#fff;border:none;border-radius:6px;font-size:12px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s;white-space:nowrap;text-decoration:none}
.btn-voir:hover{opacity:.85}
.action-icon{width:28px;height:28px;border-radius:6px;border:none;background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;transition:background .12s}
.action-icon.green{color:var(--green)}
.action-icon.green:hover{background:var(--green-light)}
.action-icon.red{color:var(--red)}
.action-icon.red:hover{background:var(--red-light}
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
    <button class="notif-btn"><i class="ti ti-bell"></i><div class="notif-dot"></div></button>
    @php
      $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
      $initials = substr($entreprise->nom_entreprise ?? 'TV', 0, 2);
    @endphp
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

  <a href="{{ route('entreprise.dashboard') }}" class="back-link"><i class="ti ti-arrow-left"></i> Retour au dashboard</a>

  {{-- Success Message --}}
  @if(session('success'))
  <div style="background: #d1fae5; border: 0.5px solid #10b981; border-radius: var(--r); padding: 12px 16px; margin-bottom: 14px;">
    <div style="display: flex; align-items: center; gap: 8px;">
      <span style="font-size: 18px;">✅</span>
      <div style="font-size: 13px; color: #065f46;">{{ session('success') }}</div>
    </div>
  </div>
  @endif

  <!-- Offre header -->
  <div class="offre-card">
    <div class="offre-top">
      @php
        $initials = substr($offre->titre_offre, 0, 1);
        $colors = ['#5b4be8', '#ec4899', '#10b981', '#f59e0b', '#06b6d4'];
        $color = $colors[array_rand($colors)];
      @endphp
      <div class="offre-avatar" style="background:{{ $color }}">{{ $initials }}</div>
      <div style="flex:1">
        <div class="offre-title">{{ $offre->titre_offre }}</div>
        <div class="offre-meta">
          <span class="meta-item"><i class="ti ti-map-pin"></i> {{ $offre->ville_poste ?? 'Non spécifié' }}</span>
          <span class="badge-cdi">{{ $offre->type_contrat ?? 'CDI' }}</span>
          <span class="meta-item"><i class="ti ti-clock"></i> Publiée il y a {{ $offre->date_publication->diffForHumans() }}</span>
          @if($offre->statut_offre === 'suspendue')
            <span class="badge-cdi" style="background:#fef3c7;color:#92400e">Suspendue</span>
          @elseif($offre->statut_offre === 'clôturée')
            <span class="badge-cdi" style="background:#fee2e2;color:#991b1b">Clôturée</span>
          @endif
        </div>
      </div>
      <div style="display:flex;gap:8px">
        <a href="{{ route('entreprise.offres.edit', ['id_offre' => $offre->id_offre]) }}" class="modifier-btn"><i class="ti ti-edit"></i> Modifier</a>
        @if($offre->statut_offre === 'active')
          <form action="{{ route('entreprise.offres.suspend', ['id_offre' => $offre->id_offre]) }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="modifier-btn" style="color:#f59e0b" onclick="return confirm('Voulez-vous vraiment suspendre cette offre ?')"><i class="ti ti-player-pause"></i> Suspendre</button>
          </form>
          <form action="{{ route('entreprise.offres.close', ['id_offre' => $offre->id_offre]) }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="modifier-btn" style="color:#ef4444" onclick="return confirm('Voulez-vous vraiment clôturer cette offre ?')"><i class="ti ti-x"></i> Clôturer</button>
          </form>
        @elseif($offre->statut_offre === 'suspendue' || $offre->statut_offre === 'clôturée')
          <form action="{{ route('entreprise.offres.reactivate', ['id_offre' => $offre->id_offre]) }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="modifier-btn" style="color:#10b981" onclick="return confirm('Voulez-vous vraiment réactiver cette offre ?')"><i class="ti ti-player-play"></i> Réactiver</button>
          </form>
        @endif
      </div>
    </div>
    @php
      $nbCandidatures = \App\Models\Candidature::where('id_offre', $offre->id_offre)->count();
      $scoreMoyen = \App\Models\Candidature::where('id_offre', $offre->id_offre)->avg('score_final') ?? 0;
      
      // Calculer les jours restants correctement
      if ($offre->date_limite) {
        $diff = ceil($offre->date_limite->diffInDays(now()));
        if ($diff >= 0) {
          $joursRestants = $diff;
          $joursLabel = $diff == 1 ? 'Jour restant' : 'Jours restants';
        } else {
          $joursRestants = abs($diff);
          $joursLabel = abs($diff) == 1 ? 'Jour écoulé' : 'Jours écoulés';
        }
      } else {
        $joursRestants = null;
        $joursLabel = 'Jours restants';
      }
      
      // Calculer le taux de complétion basé sur les candidatures avec score > 0
      $candidaturesAvecScore = \App\Models\Candidature::where('id_offre', $offre->id_offre)
          ->where('score_final', '>', 0)
          ->count();
      $tauxCompletion = $nbCandidatures > 0 ? round(($candidaturesAvecScore / $nbCandidatures) * 100) : 0;
    @endphp
    <div class="stats-row">
      <div class="stat-item">
        <div class="stat-val blue">{{ $nbCandidatures }}</div>
        <div class="stat-label">Candidatures</div>
      </div>
      <div class="stat-item">
        <div class="stat-val purple">{{ round($scoreMoyen) }}%</div>
        <div class="stat-label">Score moyen</div>
      </div>
      <div class="stat-item">
        <div class="stat-val teal">{{ $tauxCompletion }}%</div>
        <div class="stat-label">Taux de complétion</div>
      </div>
      <div class="stat-item">
        <div class="stat-val green">{{ $joursRestants ?? 'N/A' }}</div>
        <div class="stat-label">{{ $joursLabel }}</div>
      </div>
    </div>
  </div>

  <!-- Table candidats -->
  <div class="table-card">
    <div class="table-header">
      <div class="table-title"><i class="ti ti-users"></i> Candidats ({{ $nbCandidatures }})</div>
      <div class="filter-row">
        <button class="filter-btn"><i class="ti ti-filter"></i> Filtrer</button>
        <input class="search-input" type="text" placeholder="Rechercher...">
      </div>
    </div>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Candidat</th>
          <th>Expérience</th>
          <th>Statut</th>
          <th>Score</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @php
          $candidatures = \App\Models\Candidature::with(['candidat', 'progressions'])
              ->where('id_offre', $offre->id_offre)
              ->orderByDesc('score_final')
              ->get();
        @endphp
        @if($candidatures->count() > 0)
          @foreach($candidatures as $index => $candidature)
            @php
              $candidat = $candidature->candidat;
              $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
              $anneesExp = $candidat->annees_experience ?? 0;
              $score = round($candidature->score_final ?? 0);
              
              // Determine status based on progression
              $currentStep = $candidature->progressions->where('statut_etape', 'en_cours')->first();
              if ($currentStep) {
                  $etape = $currentStep->etapeOffre->nom_etape ?? 'En cours';
                  $statusClass = 's-encours';
              } else {
                  $completedSteps = $candidature->progressions->where('statut_etape', 'complétée')->count();
                  if ($completedSteps > 0) {
                      $etape = 'Pré-sélectionné';
                      $statusClass = 's-preselect';
                  } else {
                      $etape = 'Nouveau';
                      $statusClass = 's-nouveau';
                  }
              }
              
              $rankClass = $index === 0 ? '' : 'grey';
            @endphp
            <tr>
              <td><div class="rank-badge {{ $rankClass }}">{{ $index + 1 }}</div></td>
              <td>
                <div class="cand-cell">
                  <div class="cand-av" style="background:#374151">{{ $initials }}</div>
                  <div><div class="cand-name">{{ $candidat->prenom }} {{ $candidat->nom }}</div><div class="cand-sub">{{ $candidat->niveau_etudes ?? 'Non spécifié' }}</div></div>
                </div>
              </td>
              <td><span class="exp-text">{{ $anneesExp }} ans</span></td>
              <td><span class="status {{ $statusClass }}">{{ $etape }}</span></td>
              <td>
                <div class="score-cell">
                  <div class="score-bar-wrap"><div class="score-bar-fill" style="width:{{ $score }}%"></div></div>
                  <span class="score-num"><i class="ti ti-trending-up" style="font-size:11px"></i>{{ $score }}%</span>
                </div>
              </td>
              <td>
                <div class="actions-cell">
                  <a href="{{ route('entreprise.candidatures.show', ['id_candidature' => $candidature->id_candidature]) }}" class="btn-voir">Voir <i class="ti ti-chevron-right"></i></a>
                  <button class="action-icon green"><i class="ti ti-circle-check"></i></button>
                  <button class="action-icon red"><i class="ti ti-circle-x"></i></button>
                </div>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="6" style="text-align: center; padding: 40px; color: var(--t3); font-size: 13px;">
              Aucune candidature pour cette offre
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
