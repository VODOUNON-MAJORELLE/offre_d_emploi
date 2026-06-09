<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes candidatures — Talentlink</title>
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
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px}
.nav-link:hover{color:var(--t1)}
.nav-link.active{color:var(--accent);font-weight:600;border-bottom:2px solid var(--accent)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--t2);text-decoration:none}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
.user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* PAGE */
.page{max-width:680px;margin:0 auto;padding:32px 20px 60px}
.page-title{font-size:22px;font-weight:800;margin-bottom:4px}
.page-sub{font-size:13px;color:var(--t2);margin-bottom:24px}

/* CANDIDATURE CARD */
.cand-card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:20px 22px;margin-bottom:14px;transition:box-shadow .15s}
.cand-card:hover{box-shadow:0 4px 20px rgba(91,75,232,.08)}

.cand-header{display:flex;align-items:flex-start;gap:14px;margin-bottom:16px}
.cand-av{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0}
.cand-info{flex:1}
.cand-title{font-size:15px;font-weight:700;margin-bottom:2px}
.cand-company{font-size:12px;color:var(--t2)}
.cand-meta{display:flex;flex-direction:column;align-items:flex-end;gap:5px}

/* Status badges */
.badge{font-size:11px;font-weight:500;padding:4px 10px;border-radius:99px;white-space:nowrap}
.b-encours{background:var(--accent-light);color:var(--accent)}
.b-preselect{background:var(--orange-light);color:#92400e}
.b-refuse{background:#fee2e2;color:#991b1b}
.b-accepte{background:var(--green-light);color:#065f46}
.cand-date{font-size:11px;color:var(--t3)}

/* Progression */
.prog-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
.prog-label{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--t3)}
.prog-pct{font-size:12px;font-weight:700;color:var(--accent);display:flex;align-items:center;gap:3px}
.prog-bar{height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden;margin-bottom:18px}
.prog-fill{height:100%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:99px;transition:width .6s ease}

/* Étapes timeline */
.timeline{margin-bottom:18px}
.tl-item{display:flex;align-items:flex-start;gap:12px;margin-bottom:12px;position:relative}
.tl-item:last-child{margin-bottom:0}
/* vertical line */
.tl-item:not(:last-child)::after{content:'';position:absolute;left:16px;top:34px;width:1.5px;height:calc(100% - 10px);background:var(--border)}
.tl-icon{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;z-index:1}
.tl-icon.done{background:var(--accent-light);color:var(--accent)}
.tl-icon.active{background:var(--accent);color:#fff;box-shadow:0 0 0 4px rgba(91,75,232,.15)}
.tl-icon.pending{background:#f3f4f6;color:var(--t3)}
.tl-body{padding-top:4px;flex:1}
.tl-name{font-size:13px;font-weight:500;display:flex;align-items:center;gap:7px}
.tl-name.done{color:var(--t1)}
.tl-name.active{color:var(--accent);font-weight:600}
.tl-name.pending{color:var(--t3)}
.etape-badge{font-size:10px;font-weight:500;color:var(--accent);background:var(--accent-light);padding:2px 7px;border-radius:99px}
.tl-date{font-size:11px;color:var(--t3);margin-top:2px}

/* Card footer */
.cand-footer{display:flex;align-items:center;justify-content:space-between;padding-top:16px;border-top:0.5px solid var(--border)}
.compat-info{display:flex;flex-direction:column;gap:1px}
.compat-label{font-size:10px;color:var(--t3);text-transform:uppercase;letter-spacing:.07em;font-weight:600}
.compat-val{font-size:15px;font-weight:800;color:var(--accent)}
.footer-actions{display:flex;align-items:center;gap:10px}
.msg-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 14px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:13px;font-weight:500;font-family:inherit;color:var(--t1);cursor:pointer;transition:background .12s;text-decoration:none}
.msg-btn:hover{background:#f5f6fa}
.voir-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;border:none;border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s;text-decoration:none}
.voir-btn:hover{opacity:.88}

/* CTA card */
.cta-card{background:linear-gradient(135deg,rgba(124,111,240,.12),rgba(91,75,232,.08));border:0.5px solid rgba(91,75,232,.2);border-radius:var(--r);padding:28px 20px;text-align:center;margin-top:6px}
.cta-icon{width:44px;height:44px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;margin:0 auto 14px}
.cta-title{font-size:15px;font-weight:700;margin-bottom:6px}
.cta-sub{font-size:12px;color:var(--t2);margin-bottom:18px;line-height:1.6}
.cta-btn{display:inline-flex;align-items:center;gap:7px;padding:11px 24px;background:var(--accent);color:#fff;border:none;border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s;text-decoration:none}
.cta-btn:hover{opacity:.88}
</style>
</head>
<body>

<nav>
  <div class="nav-left">
    <div class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </div>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('candidat.feed') }}">Feed</a>
      <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
      <a class="nav-link active">Candidatures</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $candidat = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
      $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
      $unreadNotifCount = \App\Models\Notification::where('id_candidat', $candidat->id_candidat)->where('statut_lecture', 'non lu')->count();
    @endphp
    <a href="{{ route('notifications.index') }}" class="notif-btn">
      <i class="ti ti-bell"></i>
      @if($unreadNotifCount > 0)
        <span class="notif-badge">{{ $unreadNotifCount }}</span>
      @endif
    </a>
    @if($candidat->photo_profil)
      <div class="user-av" style="background-image: url('{{ asset('storage/' . $candidat->photo_profil) }}'); background-size: cover; background-position: center;"></div>
    @else
      <div class="user-av">{{ $initials }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<div class="page">
  <div class="page-title">Mes candidatures</div>
  <div class="page-sub">Suivez l'avancement de toutes vos candidatures en temps réel.</div>

  @forelse($candidatures as $candidature)
    @php
      $offre = $candidature->offre;
      $entreprise = $offre->entreprise;
      $initials = substr($entreprise->nom_entreprise, 0, 2);
      $color = '#6c63ff';
      
      // Determine status
      if ($candidature->motif_refus) {
          $statusClass = 'b-refuse';
          $statusText = 'Refusé';
      } else {
          $currentStep = $candidature->progressions->where('statut_etape', 'en_cours')->first();
          if ($currentStep) {
              $statusClass = 'b-encours';
              $statusText = 'En cours';
          } else {
              $completedSteps = $candidature->progressions->where('statut_etape', 'complétée')->count();
              if ($completedSteps > 0) {
                  $statusClass = 'b-preselect';
                  $statusText = 'Pré-sélectionné';
              } else {
                  $statusClass = 'b-encours';
                  $statusText = 'En cours';
              }
          }
      }
      
      // Calculate progress percentage
      $totalSteps = $candidature->progressions->count();
      $completedSteps = $candidature->progressions->where('statut_etape', 'complétée')->count();
      $currentStepIndex = $candidature->progressions->search(function($item) {
          return $item->statut_etape === 'en_cours';
      });
      if ($totalSteps > 0) {
          if ($currentStepIndex !== false) {
              $progressPct = round(($currentStepIndex / $totalSteps) * 100);
          } else {
              $progressPct = round(($completedSteps / $totalSteps) * 100);
          }
      } else {
          $progressPct = 0;
      }
    @endphp
    
    <div class="cand-card">
      <div class="cand-header">
        <div class="cand-av" style="background:{{ $color }}">{{ $initials }}</div>
        <div class="cand-info">
          <div class="cand-title">{{ $offre->titre_offre }}</div>
          <div class="cand-company">{{ $entreprise->nom_entreprise }} · {{ $offre->ville ?? 'Non spécifié' }}</div>
        </div>
        <div class="cand-meta">
          <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
          <span class="cand-date">Candidaté le {{ $candidature->date_soumission->format('d/m/Y') }}</span>
        </div>
      </div>


      <div class="cand-footer">
        <div class="compat-info">
          <span class="compat-label">Compatibilité</span>
          <span class="compat-val">{{ round($candidature->score_final ?? 0) }}%</span>
        </div>
        <div class="footer-actions">
          <a href="{{ route('messagerie.show', ['id_partner' => $entreprise->id_entreprise]) }}" class="msg-btn"><i class="ti ti-message-circle"></i> Messagerie</a>
          <a href="{{ route('candidat.candidatures.show', ['id_candidature' => $candidature->id_candidature]) }}" class="voir-btn">Voir l'avancement <i class="ti ti-chevron-right"></i></a>
        </div>
      </div>
    </div>
  @empty
    <div class="cta-card">
      <div class="cta-icon"><i class="ti ti-plus"></i></div>
      <div class="cta-title">Postulez à plus d'offres</div>
      <div class="cta-sub">Augmentez vos chances en postulant à plusieurs offres correspondant à votre profil.</div>
      <a href="/" class="cta-btn">Explorer les offres</a>
    </div>
  @endforelse
</div>

</body>
</html>
