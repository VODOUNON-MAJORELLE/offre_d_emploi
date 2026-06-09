<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Avancement de ma candidature — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--green-light:#d1fae5;
  --orange:#f59e0b;--orange-light:#fef3c7;
  --r:14px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px;text-decoration:none;color:var(--t1)}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}

/* PAGE */
.page{max-width:680px;margin:0 auto;padding:32px 20px 60px}
.page-title{font-size:22px;font-weight:800;margin-bottom:4px;display:flex;align-items:center;gap:12px}
.back-btn{display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:50%;background:var(--card);border:0.5px solid var(--border);color:var(--t2);text-decoration:none;transition:background 0.15s;}
.back-btn:hover{background:#f5f6fa;}
.page-sub{font-size:13px;color:var(--t2);margin-bottom:24px}

/* CANDIDATURE CARD */
.cand-card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:24px 28px;margin-bottom:14px;}

.cand-header{display:flex;align-items:center;gap:16px;margin-bottom:24px;border-bottom:0.5px solid var(--border);padding-bottom:16px;}
.cand-av{width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;flex-shrink:0;background:#6c63ff;}
.cand-info{flex:1}
.cand-title{font-size:18px;font-weight:700;margin-bottom:4px}
.cand-company{font-size:14px;color:var(--t2)}

/* Progression */
.prog-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px}
.prog-label{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--t3)}
.prog-pct{font-size:14px;font-weight:700;color:var(--accent);display:flex;align-items:center;gap:4px}
.prog-bar{height:6px;background:#e5e7eb;border-radius:99px;overflow:hidden;margin-bottom:24px}
.prog-fill{height:100%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:99px;transition:width .6s ease}

/* Étapes timeline */
.timeline{margin-bottom:18px}
.tl-item{display:flex;align-items:flex-start;gap:16px;margin-bottom:20px;position:relative}
.tl-item:last-child{margin-bottom:0}
/* vertical line */
.tl-item:not(:last-child)::after{content:'';position:absolute;left:19px;top:40px;width:2px;height:calc(100% - 10px);background:var(--border)}
.tl-icon{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;z-index:1}
.tl-icon.done{background:var(--accent-light);color:var(--accent)}
.tl-icon.active{background:var(--accent);color:#fff;box-shadow:0 0 0 4px rgba(91,75,232,.15)}
.tl-icon.pending{background:#f3f4f6;color:var(--t3)}
.tl-body{padding-top:6px;flex:1}
.tl-name{font-size:15px;font-weight:500;display:flex;align-items:center;gap:8px;margin-bottom:2px;}
.tl-name.done{color:var(--t1)}
.tl-name.active{color:var(--accent);font-weight:600}
.tl-name.pending{color:var(--t3)}
.etape-badge{font-size:11px;font-weight:500;color:var(--accent);background:var(--accent-light);padding:3px 8px;border-radius:99px}
.tl-date{font-size:12px;color:var(--t3);}
</style>
</head>
<body>

<nav>
  <div class="nav-left">
    <a href="/" class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </a>
  </div>
</nav>

<div class="page">
  <div class="page-title">
    <a href="{{ route('candidat.dashboard') }}" class="back-btn" title="Retour aux candidatures"><i class="ti ti-arrow-left"></i></a>
    Avancement de ma candidature
  </div>
  <div class="page-sub">Suivez chaque étape du processus de recrutement.</div>

  @php
    $offre = $candidature->offre;
    $entreprise = $offre->entreprise;
    $initials = substr($entreprise->nom_entreprise, 0, 2);
    
    // Get all steps of the offer
    $etapesOffre = $offre->etapes->sortBy('ordre_etape');
    $totalSteps = $etapesOffre->count();
    
    // Get progressions indexed by etape id
    $progressionsByEtape = $candidature->progressions->keyBy('id_etape_offre');
    
    // Calculate progress percentage
    $completedSteps = $candidature->progressions->where('statut_etape', 'complétée')->count();
    $currentStepProg = $candidature->progressions->where('statut_etape', 'en_cours')->first();
    
    if ($totalSteps > 0) {
        if ($currentStepProg) {
            // Find the index of this step in the total steps
            $currentEtapeIndex = $etapesOffre->search(function($e) use ($currentStepProg) {
                return $e->id_etape_offre === $currentStepProg->id_etape_offre;
            });
            $progressPct = round((($currentEtapeIndex !== false ? $currentEtapeIndex : 0) / $totalSteps) * 100);
        } else {
            $progressPct = round(($completedSteps / $totalSteps) * 100);
        }
    } else {
        $progressPct = 0;
    }
  @endphp

  <div class="cand-card">
    <div class="cand-header">
      <div class="cand-av">{{ $initials }}</div>
      <div class="cand-info">
        <div class="cand-title">{{ $offre->titre_offre }}</div>
        <div class="cand-company">{{ $entreprise->nom_entreprise }} · {{ $offre->ville ?? 'Non spécifié' }}</div>
      </div>
    </div>

    <div class="prog-header">
      <span class="prog-label">Progression globale</span>
      <span class="prog-pct"><i class="ti ti-trending-up"></i>{{ $progressPct }}%</span>
    </div>
    <div class="prog-bar"><div class="prog-fill" style="width:{{ $progressPct }}%"></div></div>

    @if($candidature->motif_refus)
    <div style="background: #fff5f5; border: 0.5px solid #fecaca; border-radius: var(--rs); padding: 14px 16px; margin-bottom: 18px;">
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <i class="ti ti-circle-x" style="font-size: 18px; color: #ef4444;"></i>
        <span style="font-size: 14px; font-weight: 600; color: #ef4444;">Candidature refusée</span>
      </div>
      <div style="font-size: 13px; color: #991b1b; margin-left: 26px;">
        Motif : {{ $candidature->motif_refus }}
      </div>
    </div>
    @endif

    <div class="timeline">
      @foreach($etapesOffre as $index => $etape)
        @php
          $progression = $progressionsByEtape->get($etape->id_etape_offre);
          $isDone = $progression && $progression->statut_etape === 'complétée';
          $isActive = $progression && $progression->statut_etape === 'en_cours';
          $isPending = !$isDone && !$isActive;
        @endphp
        <div class="tl-item">
          <div class="tl-icon {{ $isDone ? 'done' : ($isActive ? 'active' : 'pending') }}">
            @if($isDone)
              <i class="ti ti-circle-check-filled"></i>
            @elseif($isActive)
              <i class="ti ti-clock"></i>
            @else
              <i class="ti ti-circle"></i>
            @endif
          </div>
          <div class="tl-body">
            <div class="tl-name {{ $isDone ? 'done' : ($isActive ? 'active' : 'pending') }}">
              {{ $etape->nom_etape ?? 'Étape ' . ($index + 1) }}
              @if($isActive)
                <span class="etape-badge">← Étape actuelle</span>
              @endif
            </div>
            <div class="tl-date">
              @if($isDone)
                <span style="color: var(--green); font-weight: 500;">Complétée</span> · {{ $progression->updated_at->format('d/m/Y') }}
              @elseif($isActive)
                <span style="color: var(--accent); font-weight: 500;">En cours</span>
              @else
                <span style="color: var(--t3);">En attente</span> · À venir
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>

  </div>

</div>

</body>
</html>
