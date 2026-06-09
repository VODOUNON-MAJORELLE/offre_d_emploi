<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Candidature envoyée — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;
  --green:#10b981;--green-light:#d1fae5;
  --red:#ef4444;--red-light:#fee2e2;
  --r:14px;--rs:10px;
}
html,body{height:100%;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1)}
body{display:flex;flex-direction:column;min-height:100vh}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s}
.nav-link:hover{color:var(--t1)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--t2)}
.notif-dot{position:absolute;top:2px;right:2px;width:7px;height:7px;border-radius:50%;background:#3b82f6;border:1.5px solid #fff}
.user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* CENTER */
.center{flex:1;display:flex;align-items:center;justify-content:center;padding:40px 20px}
.box{text-align:center;max-width:460px;width:100%}

/* Check icon */
.check-circle{
  width:90px;height:90px;border-radius:50%;
  background:var(--green-light);
  display:flex;align-items:center;justify-content:center;
  margin:0 auto 28px;
  animation:popIn .5s cubic-bezier(.175,.885,.32,1.275) both;
}
@keyframes popIn{
  0%{transform:scale(0);opacity:0}
  100%{transform:scale(1);opacity:1}
}
.check-circle i{font-size:40px;color:var(--green)}

.conf-title{font-size:26px;font-weight:800;color:var(--t1);margin-bottom:14px;animation:fadeUp .4s .2s both}
.conf-sub{font-size:14px;color:var(--t2);line-height:1.7;margin-bottom:10px;animation:fadeUp .4s .3s both}
.conf-sub strong{color:var(--t1);font-weight:700}
.conf-hint{font-size:13px;color:var(--t3);margin-bottom:24px;animation:fadeUp .4s .4s both}
@keyframes fadeUp{
  0%{transform:translateY(12px);opacity:0}
  100%{transform:translateY(0);opacity:1}
}

/* Score card */
.score-card{
  background:var(--card);
  border:0.5px solid var(--border);
  border-radius:var(--r);
  padding:20px;
  margin-bottom:24px;
  animation:fadeUp .4s .45s both;
}
.score-title{font-size:15px;font-weight:600;color:var(--t1);margin-bottom:16px;text-align:center}
.score-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;font-size:13px}
.score-row:last-child{margin-bottom:0}
.score-label{color:var(--t2)}
.score-value{font-weight:600;color:var(--t1)}
.score-divider{height:1px;background:var(--border);margin:16px 0}
.score-final{display:flex;align-items:center;justify-content:space-between;font-size:15px;font-weight:700}
.score-final-val{color:var(--accent);font-size:20px}
.score-bar-wrap{flex:1;margin:0 16px;height:8px;background:var(--border);border-radius:99px;overflow:hidden}
.score-bar-fill{height:100%;background:linear-gradient(90deg,#7c6ff0,#5b4be8);border-radius:99px}

.btn-primary{
  width:100%;padding:15px;border:none;border-radius:var(--rs);
  background:linear-gradient(135deg,#7c6ff0,#5b4be8);
  color:#fff;font-size:15px;font-weight:600;font-family:inherit;
  cursor:pointer;margin-bottom:10px;
  box-shadow:0 4px 16px rgba(91,75,232,.28);
  transition:opacity .15s;
  animation:fadeUp .4s .5s both;
}
.btn-primary:hover{opacity:.9}
.btn-outline{
  width:100%;padding:15px;border:0.5px solid var(--border);border-radius:var(--rs);
  background:var(--card);color:var(--t1);font-size:15px;font-weight:500;font-family:inherit;
  cursor:pointer;transition:background .12s;
  animation:fadeUp .4s .55s both;
}
.btn-outline:hover{background:#f5f6fa}
.btn-danger{
  width:100%;padding:15px;border:none;border-radius:var(--rs);
  background:linear-gradient(135deg,#ef4444,#dc2626);
  color:#fff;font-size:15px;font-weight:600;font-family:inherit;
  cursor:pointer;margin-bottom:10px;
  box-shadow:0 4px 16px rgba(239,68,68,.28);
  transition:opacity .15s;
  animation:fadeUp .4s .6s both;
}
.btn-danger:hover{opacity:.9}
</style>
</head>
<body>

<nav>
  <div class="nav-left">
    <div class="nav-logo"><div class="logo-av">JR</div><span>Talentlink</span></div>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('candidat.feed') }}">Feed</a>
      <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $initials = strtoupper(substr(auth()->guard('candidat')->user()->nom ?? '', 0, 1) . substr(auth()->guard('candidat')->user()->prenom ?? '', 0, 1));
    @endphp
    <div class="user-av">{{ $initials }}</div>
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<div class="center">
  <div class="box">
    <div class="check-circle"><i class="ti ti-circle-check"></i></div>
    <div class="conf-title">Candidature envoyée !</div>
    <div class="conf-sub">
      Vous avez déjà postulé pour <strong>{{ $offre->titre_offre }}</strong> chez <strong>{{ $offre->entreprise->nom_entreprise }}</strong>.
    </div>
    
    <div class="score-card">
      <div class="score-title">Score de compatibilité</div>
      
      <div class="score-row">
        <span class="score-label">Compatibilité profil</span>
        <span class="score-value">{{ $matchResult['score_compatibilite'] ?? 0 }}%</span>
      </div>
      
      @if($existingCandidature->score_questionnaire !== null)
      <div class="score-row">
        <span class="score-label">Questionnaire</span>
        <span class="score-value">{{ $existingCandidature->score_questionnaire }}%</span>
      </div>
      @endif
      
      <div class="score-divider"></div>
      
      <div class="score-final">
        <span class="score-label">Score final</span>
        <div class="score-bar-wrap">
          <div class="score-bar-fill" style="width: {{ $existingCandidature->score_final ?? $matchResult['score_compatibilite'] }}%"></div>
        </div>
        <span class="score-final-val">{{ $existingCandidature->score_final ?? $matchResult['score_compatibilite'] }}%</span>
      </div>
    </div>
    
    <div class="conf-hint">Vous pouvez suivre l'avancement de votre candidature depuis votre espace.</div>
    <button class="btn-primary" onclick="window.location='{{ route('candidat.offres.postuler', ['id_offre' => $offre->id_offre, 'edit' => 1]) }}'">Modifier la candidature</button>
    <form id="delete-candidature-form" action="{{ route('candidat.candidatures.delete', $existingCandidature->id_candidature) }}" method="POST" style="display:none;">
      @csrf
      @method('DELETE')
    </form>
    <button class="btn-danger" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?')) document.getElementById('delete-candidature-form').submit();">Supprimer la candidature</button>
    <button class="btn-outline" onclick="window.location='{{ route('candidat.feed') }}'">Retour au feed</button>
  </div>
</div>

</body>
</html>
