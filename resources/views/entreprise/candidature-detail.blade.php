<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Candidature — {{ $candidature->candidat->prenom ?? 'Candidat' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.07);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--green-light:#d1fae5;
  --red:#ef4444;--red-light:#fee2e2;
  --orange:#f59e0b;
  --r:12px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh;padding:0}
.wrap{max-width:960px;margin:0 auto;padding:28px 24px 48px}

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

.layout{display:grid;grid-template-columns:280px 1fr;gap:14px;align-items:start}

/* ---- LEFT ---- */
.card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:20px;margin-bottom:14px}
.card:last-child{margin-bottom:0}

/* Profil card */
.profil-card{text-align:center}
.av{width:64px;height:64px;border-radius:50%;background:#374151;display:inline-flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:#fff;margin-bottom:12px}
.cand-name{font-size:17px;font-weight:700;margin-bottom:3px}
.cand-exp-label{font-size:12px;color:var(--t2);margin-bottom:14px}
.contact-list{list-style:none;text-align:left;margin-bottom:16px}
.contact-list li{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--t2);padding:4px 0}
.contact-list li i{font-size:14px;color:var(--t3)}
.score-block{background:var(--accent-light);border-radius:var(--rs);padding:14px;text-align:center;margin-bottom:14px}
.score-label{font-size:11px;color:var(--t2);margin-bottom:4px}
.score-big{font-size:36px;font-weight:800;color:var(--accent);line-height:1}
.score-ia{font-size:11px;color:var(--t3);margin-top:4px;display:flex;align-items:center;justify-content:center;gap:4px}
.dl-btn{width:100%;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:13px;font-weight:500;font-family:inherit;color:var(--t1);cursor:pointer;transition:background .12s}
.dl-btn:hover{background:#f5f6fa}

/* Actions card */
.actions-title{font-size:14px;font-weight:700;margin-bottom:12px}
.btn-primary{width:100%;display:flex;align-items:center;gap:8px;padding:12px 16px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;border:none;border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;cursor:pointer;margin-bottom:8px;transition:opacity .15s}
.btn-primary:hover{opacity:.88}
.btn-ghost{width:100%;display:flex;align-items:center;gap:8px;padding:11px 16px;background:var(--card);border:0.5px solid var(--border);border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;color:var(--accent);cursor:pointer;margin-bottom:8px;transition:background .12s}
.btn-ghost:hover{background:#f5f6fa}
.btn-green{width:100%;display:flex;align-items:center;gap:8px;padding:11px 16px;background:#f0fdf4;border:0.5px solid #bbf7d0;border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;color:var(--green);cursor:pointer;margin-bottom:8px;transition:background .12s}
.btn-green:hover{background:var(--green-light)}
.btn-red{width:100%;display:flex;align-items:center;gap:8px;padding:11px 16px;background:#fff5f5;border:0.5px solid #fecaca;border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;color:var(--red);cursor:pointer;transition:background .12s}
.btn-red:hover{background:var(--red-light)}

/* Étapes */
.etapes-title{font-size:14px;font-weight:700;margin-bottom:12px}
.etape-item{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:0.5px solid var(--border)}
.etape-item:last-child{border:none}
.etape-num{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0}
.etape-num.active{background:var(--accent);color:#fff}
.etape-num.inactive{background:#e5e7eb;color:var(--t3)}
.etape-label{font-size:13px;flex:1}
.etape-label.active{font-weight:500;color:var(--t1)}
.etape-label.inactive{color:var(--t3)}
.badge-actuelle{font-size:10px;font-weight:600;padding:2px 8px;border-radius:99px;background:var(--accent-light);color:var(--accent)}

/* ---- RIGHT ---- */
.section-title{font-size:16px;font-weight:700;display:flex;align-items:center;gap:8px;margin-bottom:16px}
.section-title i{font-size:17px;color:var(--accent)}

/* Analyse compatibilité */
.compat-row{margin-bottom:12px}
.compat-row:last-child{margin-bottom:0}
.compat-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:5px}
.compat-label{font-size:12px;color:var(--t1)}
.compat-right{display:flex;align-items:center;gap:10px}
.compat-poids{font-size:11px;color:var(--t3)}
.compat-pct{font-size:13px;font-weight:700;color:var(--accent)}
.bar-wrap{height:6px;background:#e5e7eb;border-radius:99px;overflow:hidden}
.bar-fill{height:100%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:99px}

/* Compétences */
.tags{display:flex;flex-wrap:wrap;gap:8px}
.tag{padding:5px 12px;border:0.5px solid var(--border);border-radius:99px;font-size:12px;color:var(--t1);background:#fafafa}

/* Formation */
.form-item{display:flex;align-items:center;gap:12px}
.form-icon{width:36px;height:36px;border-radius:8px;background:var(--accent-light);display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--accent);flex-shrink:0}
.form-name{font-size:13px;font-weight:600}
.form-sub{font-size:12px;color:var(--t3);margin-top:1px}

/* Lettre */
.lettre-text{font-size:13px;line-height:1.7;color:var(--t1);background:#fafbff;border-radius:var(--rs);padding:14px 16px;border:0.5px solid var(--border)}

/* Questionnaire */
.q-item{background:#fafafa;border:0.5px solid var(--border);border-radius:var(--rs);padding:12px 14px;margin-bottom:8px}
.q-item:last-child{margin-bottom:0}
.q-question{font-size:12px;color:var(--t2);margin-bottom:6px}
.q-answer{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:500}
.q-answer.check i{color:var(--green)}
.q-answer.neutral i{color:var(--t3)}

@media(max-width:720px){.layout{grid-template-columns:1fr}}
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
  <a href="{{ route('entreprise.offres.detail', ['id_offre' => $candidature->id_offre]) }}" class="back-link"><i class="ti ti-arrow-left"></i> Retour à l'offre</a>

  {{-- Success Message --}}
  @if(session('success'))
  <div style="background: #d1fae5; border: 0.5px solid #10b981; border-radius: var(--r); padding: 12px 16px; margin-bottom: 14px;">
    <div style="display: flex; align-items: center; gap: 8px;">
      <span style="font-size: 18px;">✅</span>
      <div style="font-size: 13px; color: #065f46;">{{ session('success') }}</div>
    </div>
  </div>
  @endif

  @php
    $candidat = $candidature->candidat;
    $offre = $candidature->offre;
    $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
    $anneesExp = $candidat->annees_experience ?? 0;
    $score = round($candidature->score_final ?? 0);
    $competences = array_filter(array_map('trim', explode(',', $candidat->competences ?? '')));
  @endphp

  <div class="layout">

    <!-- Colonne gauche -->
    <div>
      <!-- Profil -->
      <div class="card profil-card">
        @if($candidat->photo_profil)
          <div class="av" style="background-image: url('{{ asset('storage/' . $candidat->photo_profil) }}'); background-size: cover; background-position: center;"></div>
        @else
          <div class="av">{{ $initials }}</div>
        @endif
        <div class="cand-name">{{ $candidat->prenom }} {{ $candidat->nom }}</div>
        <div class="cand-exp-label">{{ $anneesExp }} ans d'expérience</div>
        <ul class="contact-list">
          <li><i class="ti ti-mail"></i> {{ $candidat->email }}</li>
          <li><i class="ti ti-phone"></i> {{ $candidat->telephone ?? 'Non renseigné' }}</li>
          <li><i class="ti ti-map-pin"></i> {{ $candidat->ville ?? 'Non renseigné' }}</li>
        </ul>
        <div class="score-block">
          <div class="score-label">Score de compatibilité</div>
          <div class="score-big">{{ $score }}%</div>
          <div class="score-ia"><i class="ti ti-trending-up" style="font-size:12px"></i> Score IA</div>
        </div>
        @if($candidature->cv)
          <a href="{{ route('cvs.download', ['id_cv' => $candidature->id_cv]) }}" class="dl-btn"><i class="ti ti-download"></i> Télécharger le CV</a>
        @else
          <button class="dl-btn" disabled><i class="ti ti-download"></i> Aucun CV</button>
        @endif
      </div>

      <!-- Actions -->
      <div class="card">
        <div class="actions-title">Actions</div>
        <form action="{{ route('entreprise.candidatures.progression', ['id_candidature' => $candidature->id_candidature]) }}" method="POST">
          @csrf
          <input type="hidden" name="id_progression" value="{{ $candidature->progressions->where('statut_etape', 'en_cours')->first()->id_progression ?? '' }}">
          <input type="hidden" name="statut_etape" value="complétée">
          <button type="submit" class="btn-primary"><i class="ti ti-chevron-right"></i> Étape suivante</button>
        </form>
        <a href="{{ route('messagerie.show', ['id_partner' => $candidat->id_candidat]) }}" class="btn-ghost"><i class="ti ti-message-circle"></i> Contacter</a>
        <form action="{{ route('entreprise.candidatures.reject', ['id_candidature' => $candidature->id_candidature]) }}" method="POST" style="margin-top: 8px;">
          @csrf
          <input type="text" name="motif_refus" placeholder="Motif du refus" required style="width: 100%; padding: 8px 12px; border: 0.5px solid var(--border); border-radius: var(--rs); margin-bottom: 8px; font-size: 13px;">
          <button type="submit" class="btn-red"><i class="ti ti-circle-x"></i> Refuser</button>
        </form>
      </div>

      <!-- Étapes -->
      <div class="card">
        <div class="etapes-title">Étape du recrutement</div>
        @php
          $progressions = $candidature->progressions->sortBy('ordre_etape');
        @endphp
        @foreach($progressions as $index => $progression)
          @php
            $isActive = $progression->statut_etape === 'en_cours';
            $isCompleted = $progression->statut_etape === 'complétée';
            $isPending = $progression->statut_etape === 'en_attente';
          @endphp
          <div class="etape-item">
            <div class="etape-num {{ $isActive ? 'active' : ($isCompleted ? 'active' : 'inactive') }}">{{ $index + 1 }}</div>
            <div class="etape-label {{ $isActive ? 'active' : ($isCompleted ? 'active' : 'inactive') }}">{{ $progression->etapeOffre->nom_etape ?? 'Étape ' . ($index + 1) }}</div>
            <div style="display: flex; gap: 4px; flex-wrap: wrap; margin-top: 4px;">
              <form action="{{ route('entreprise.progressions.update', ['id_progression' => $progression->id_progression]) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="statut_etape" value="en_attente">
                <button type="submit" class="btn-ghost" style="padding: 3px 6px; font-size: 10px; {{ $isPending ? 'background: var(--accent-light); color: var(--accent); border-color: var(--accent-border);' : '' }}">En attente</button>
              </form>
              <form action="{{ route('entreprise.progressions.update', ['id_progression' => $progression->id_progression]) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="statut_etape" value="en_cours">
                <button type="submit" class="btn-ghost" style="padding: 3px 6px; font-size: 10px; {{ $isActive ? 'background: var(--accent-light); color: var(--accent); border-color: var(--accent-border);' : '' }}">En cours</button>
              </form>
              <form action="{{ route('entreprise.progressions.update', ['id_progression' => $progression->id_progression]) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="statut_etape" value="complétée">
                <button type="submit" class="btn-ghost" style="padding: 3px 6px; font-size: 10px; {{ $isCompleted ? 'background: var(--accent-light); color: var(--accent); border-color: var(--accent-border);' : '' }}">Complétée</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Colonne droite -->
    <div>
      <!-- Analyse compatibilité -->
      <div class="card">
        <div class="section-title"><i class="ti ti-star"></i> Analyse de compatibilité</div>
        <div class="compat-row">
          <div class="compat-header">
            <span class="compat-label">Compétences techniques</span>
            <div class="compat-right"><span class="compat-poids">Poids: 40%</span><span class="compat-pct">96%</span></div>
          </div>
          <div class="bar-wrap"><div class="bar-fill" style="width:96%"></div></div>
        </div>
        <div class="compat-row" style="margin-top:10px">
          <div class="compat-header">
            <span class="compat-label">Expérience requise</span>
            <div class="compat-right"><span class="compat-poids">Poids: 25%</span><span class="compat-pct">88%</span></div>
          </div>
          <div class="bar-wrap"><div class="bar-fill" style="width:88%"></div></div>
        </div>
        <div class="compat-row" style="margin-top:10px">
          <div class="compat-header">
            <span class="compat-label">Réponses au questionnaire</span>
            <div class="compat-right"><span class="compat-poids">Poids: 20%</span><span class="compat-pct">92%</span></div>
          </div>
          <div class="bar-wrap"><div class="bar-fill" style="width:92%"></div></div>
        </div>
        <div class="compat-row" style="margin-top:10px">
          <div class="compat-header">
            <span class="compat-label">Formation</span>
            <div class="compat-right"><span class="compat-poids">Poids: 10%</span><span class="compat-pct">85%</span></div>
          </div>
          <div class="bar-wrap"><div class="bar-fill" style="width:85%"></div></div>
        </div>
        <div class="compat-row" style="margin-top:10px">
          <div class="compat-header">
            <span class="compat-label">Localisation</span>
            <div class="compat-right"><span class="compat-poids">Poids: 5%</span><span class="compat-pct">100%</span></div>
          </div>
          <div class="bar-wrap"><div class="bar-fill" style="width:100%"></div></div>
        </div>
      </div>

      <!-- Compétences -->
      <div class="card">
        <div class="section-title"><i class="ti ti-bolt"></i> Compétences</div>
        <div class="tags">
          @foreach($competences as $competence)
            <span class="tag">{{ $competence }}</span>
          @endforeach
          @if(empty($competences))
            <span style="color: var(--t3); font-size: 13px;">Aucune compétence renseignée</span>
          @endif
        </div>
      </div>

      <!-- Formation -->
      <div class="card">
        <div class="section-title"><i class="ti ti-school"></i> Formation</div>
        <div class="form-item">
          <div class="form-icon"><i class="ti ti-school"></i></div>
          <div>
            <div class="form-name">{{ $candidat->niveau_etudes ?? 'Non spécifié' }}</div>
            <div class="form-sub">{{ $anneesExp }} ans d'expérience</div>
          </div>
        </div>
      </div>

      <!-- Lettre de motivation -->
      @if($candidature->lettre_motivation)
      <div class="card">
        <div class="section-title" style="margin-bottom:12px">Lettre de motivation</div>
        <div class="lettre-text">
          {{ $candidature->lettre_motivation }}
        </div>
      </div>
      @endif

      <!-- Questionnaire -->
      @php
        $questionnaire = $offre->questionnaire;
        $reponses = $candidature->reponses;
      @endphp
      @if($questionnaire)
      <div class="card">
        <div class="section-title" style="margin-bottom:12px">Réponses au questionnaire</div>
        @if($reponses->count() > 0)
          @foreach($reponses as $reponse)
            @php
              $question = $reponse->question;
            @endphp
            <div class="q-item">
              <div class="q-question">{{ $question->enonce_question }}</div>
              <div class="q-answer check"><i class="ti ti-circle-check-filled"></i> {{ $reponse->contenu_reponse ?? 'Réponse non renseignée' }}</div>
            </div>
          @endforeach
        @else
          <div style="color: var(--t3); font-size: 13px;">Aucune réponse renseignée</div>
        @endif
      </div>
      @endif
    </div>

  </div>
</div>
</body>
</html>
