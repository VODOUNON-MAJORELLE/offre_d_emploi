<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer une offre — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--red:#ef4444;--red-light:#fee2e2;
  --r:14px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh;display:flex;flex-direction:column}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.nav-left{display:flex;align-items:center;gap:28px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px}
.logo-av{width:30px;height:30px;border-radius:8px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:20px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s}
.nav-link:hover{color:var(--t1)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--t2)}
.notif-dot{position:absolute;top:2px;right:2px;width:7px;height:7px;border-radius:50%;background:#3b82f6;border:1.5px solid #fff}
.user-av{width:32px;height:32px;border-radius:50%;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* PAGE */
.page{flex:1;padding:28px 24px 60px;max-width:720px;margin:0 auto;width:100%}
.back-link{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--t2);margin-bottom:18px;cursor:pointer;text-decoration:none;transition:color .12s}
.back-link:hover{color:var(--t1)}
.page-title{font-size:22px;font-weight:800;margin-bottom:22px}

/* STEPPER */
.stepper{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:6px;display:flex;gap:4px;margin-bottom:18px}
.step{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:10px 8px;border-radius:10px;font-size:13px;cursor:pointer;transition:background .15s,color .15s;color:var(--t3);font-weight:500;white-space:nowrap}
.step i{font-size:15px}
.step.active{background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff}
.step.done{color:var(--accent)}

/* CARD */
.form-card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:24px 28px;margin-bottom:16px}
.form-card-title{font-size:17px;font-weight:700;margin-bottom:4px}
.form-card-sub{font-size:12px;color:var(--t2);margin-bottom:20px}

/* FORM FIELDS */
.field{margin-bottom:16px}
.field:last-child{margin-bottom:0}
.field-label{font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--t2);margin-bottom:6px}
.field-label span{color:var(--accent)}
.f-input{width:100%;border:0.5px solid var(--border);border-radius:var(--rs);padding:11px 14px;font-size:13px;font-family:inherit;color:var(--t1);background:var(--card);outline:none;transition:border-color .15s}
.f-input:focus{border-color:var(--accent)}
.f-input::placeholder{color:var(--t3)}
.f-select{width:100%;border:0.5px solid var(--border);border-radius:var(--rs);padding:11px 14px;font-size:13px;font-family:inherit;color:var(--t1);background:var(--card);outline:none;cursor:pointer;appearance:none;transition:border-color .15s}
.f-select:focus{border-color:var(--accent)}
textarea.f-input{resize:vertical;min-height:110px;line-height:1.6}
.three-col{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px}

/* Salary input group */
.salary-input-group{display:flex;gap:8px;align-items:center}

/* Skills add */
.skill-row{display:flex;gap:8px;align-items:center;margin-bottom:10px}
.skill-add-btn{width:38px;height:38px;border-radius:var(--rs);background:var(--accent);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;flex-shrink:0;transition:opacity .15s}
.skill-add-btn:hover{opacity:.85}
.tags-wrap{display:flex;flex-wrap:wrap;gap:7px;margin-top:4px}
.tag{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;background:var(--accent-light);border:0.5px solid var(--accent2);border-radius:99px;font-size:12px;color:var(--t1)}
.tag-rm{cursor:pointer;color:var(--t3);font-size:11px;transition:color .12s}
.tag-rm:hover{color:var(--red)}

/* Questionnaire */
.q-empty{border:1.5px dashed var(--border);border-radius:var(--rs);padding:40px 20px;text-align:center;color:var(--t3)}
.q-empty i{font-size:32px;margin-bottom:10px;display:block;color:var(--accent2);opacity:.5}
.q-empty p{font-size:13px}
.add-q-btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:var(--accent);color:#fff;border:none;border-radius:var(--rs);font-size:13px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s;float:right}
.add-q-btn:hover{opacity:.88}
.q-item-card{background:#fafafa;border:0.5px solid var(--border);border-radius:var(--rs);padding:12px 14px;margin-bottom:8px;display:flex;align-items:flex-start;gap:10px}
.q-num{width:22px;height:22px;border-radius:50%;background:var(--accent);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px}
.q-text{flex:1;font-size:13px;font-weight:500}
.q-type-badge{font-size:10px;color:var(--t3);margin-top:3px}
.q-edit{background:none;border:none;cursor:pointer;color:var(--t3);font-size:16px;transition:color .12s;padding:2px;margin-right:4px}
.q-edit:hover{color:var(--accent)}
.q-del{background:none;border:none;cursor:pointer;color:var(--t3);font-size:16px;transition:color .12s;padding:2px}
.q-del:hover{color:var(--red)}

/* Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.3);display:flex;align-items:center;justify-content:center;z-index:200;opacity:0;pointer-events:none;transition:opacity .2s}
.modal-overlay.open{opacity:1;pointer-events:all}
.modal{background:var(--card);border-radius:var(--r);padding:24px;width:480px;max-width:95vw;transform:translateY(10px);transition:transform .2s}
.modal-overlay.open .modal{transform:translateY(0)}
.modal-title{font-size:15px;font-weight:700;margin-bottom:16px}
.modal-actions{display:flex;gap:10px;margin-top:18px;justify-content:flex-end}
.btn-cancel{padding:9px 18px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:13px;font-family:inherit;cursor:pointer;transition:background .12s}
.btn-cancel:hover{background:#f5f6fa}
.btn-add-q{padding:9px 18px;border:none;border-radius:var(--rs);background:var(--accent);color:#fff;font-size:13px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s}
.btn-add-q:hover{opacity:.88}

/* Étapes processus */
.etape-row{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.etape-num{width:28px;height:28px;border-radius:50%;background:var(--accent);color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.etape-input{flex:1;border:0.5px solid var(--border);border-radius:var(--rs);padding:10px 14px;font-size:13px;font-family:inherit;color:var(--t1);background:var(--card);outline:none;transition:border-color .15s}
.etape-input:focus{border-color:var(--accent)}
.etape-del{background:none;border:none;cursor:pointer;color:var(--t3);font-size:16px;transition:color .12s;padding:2px}
.etape-del:hover{color:var(--red)}
.etape-add-row{display:flex;gap:8px;margin-top:8px}

/* Aperçu */
.apercu-banner{background:var(--accent-light);border:0.5px solid var(--accent2);border-radius:var(--rs);padding:10px 14px;display:flex;align-items:center;gap:8px;font-size:12px;color:var(--accent);margin-bottom:18px}
.apercu-title{font-size:20px;font-weight:800;margin-bottom:3px}
.apercu-sub{font-size:13px;color:var(--t2);margin-bottom:16px}
.apercu-desc{font-size:13px;color:var(--t3);line-height:1.6;margin-bottom:18px;font-style:italic}
.apercu-stats{display:flex;gap:24px}
.apercu-stat-label{font-size:10px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--t3);margin-bottom:3px}
.apercu-stat-val{font-size:15px;font-weight:700}

/* Confirmation */
.confirm-page{flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;padding:40px 24px}
.confirm-icon{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:36px;color:#fff;margin:0 auto 24px;box-shadow:0 12px 40px rgba(91,75,232,.3)}
.confirm-title{font-size:26px;font-weight:800;margin-bottom:10px}
.confirm-sub{font-size:14px;color:var(--t2);line-height:1.7;margin-bottom:30px}
.confirm-sub strong{color:var(--t1)}

/* Nav buttons */
.nav-btns{display:flex;gap:12px}
.btn-back{flex:1;padding:15px;border:0.5px solid var(--border);border-radius:var(--r);background:var(--card);font-size:14px;font-weight:500;font-family:inherit;color:var(--t1);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .12s}
.btn-back:hover{background:#f5f6fa}
.btn-next{flex:1;padding:15px;border:none;border-radius:var(--r);background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;font-size:14px;font-weight:500;font-family:inherit;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:opacity .15s}
.btn-next:hover{opacity:.88}
.btn-full{width:100%;padding:15px;border:none;border-radius:var(--r);background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;font-size:14px;font-weight:500;font-family:inherit;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:opacity .15s;margin-bottom:10px}
.btn-full:hover{opacity:.88}
.btn-full-out{width:100%;padding:15px;border:0.5px solid var(--border);border-radius:var(--r);background:var(--card);font-size:14px;font-weight:500;font-family:inherit;color:var(--t1);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .12s}
.btn-full-out:hover{background:#f5f6fa}

.hidden{display:none!important}
</style>
</head>
<body>

<!-- NAV -->
<nav>
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
      $initials = substr($entreprise->nom_entreprise, 0, 2);
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

<!-- FORM -->
<form action="{{ route('entreprise.offres.store') }}" method="POST" id="offre-form" onsubmit="return prepareSubmit();">
  @csrf
  <input type="hidden" name="competences_requises" id="competences-input">
  <input type="hidden" name="questions_json" id="questions-input">
  <input type="hidden" name="etapes_json" id="etapes-input">

<!-- ===== PAGES ===== -->

<!-- STEP 1 — Informations -->
<div id="s1" class="page">
  <a href="{{ route('entreprise.dashboard') }}" class="back-link"><i class="ti ti-arrow-left"></i> Retour au dashboard</a>
  <div class="page-title">Créer une nouvelle offre</div>

  <div class="stepper">
    <div class="step active" onclick="goTo(1)"><i class="ti ti-briefcase"></i> 1. Informations</div>
    <div class="step" onclick="goTo(2)"><i class="ti ti-clipboard-list"></i> 2. Questionnaire</div>
    <div class="step" onclick="goTo(3)"><i class="ti ti-git-branch"></i> 3. Processus</div>
    <div class="step" onclick="goTo(4)"><i class="ti ti-eye"></i> 4. Aperçu</div>
  </div>

  <div class="form-card">
    <div class="form-card-title">Détails du poste</div>

    <div class="field" style="margin-top:16px">
      <div class="field-label">Titre du poste <span>*</span></div>
      <input id="f-titre" name="titre_offre" class="f-input" type="text" placeholder="Ex: Développeur Full Stack React/Node.js" required>
    </div>
    <div class="field">
      <div class="field-label">Localisation <span>*</span></div>
      <input id="f-loc" name="ville_poste" class="f-input" type="text" placeholder="Ex: Cotonou, Calavi" required>
    </div>
    <div class="field">
      <div class="field-label">Fourchette salariale</div>
      <div class="salary-input-group">
        <input id="f-salaire-min" name="salaire_min" class="f-input" type="number" placeholder="Min" style="flex:1">
        <input id="f-salaire-max" name="salaire_max" class="f-input" type="number" placeholder="Max" style="flex:1">
        <select id="f-devise" name="devise" class="f-select" style="flex:0 0 100px">
          <option value="FCFA" selected>FCFA</option>
          <option value="EUR">EUR</option>
          <option value="USD">USD</option>
          <option value="CAD">CAD</option>
          <option value="GBP">GBP</option>
        </select>
      </div>
    </div>
    <div class="field">
      
      <div class="field-label">Date limite de candidature</div>
      <input id="f-date" name="date_limite" class="f-input" type="date">
    </div>
    <div class="three-col">
      <div class="field">
        <div class="field-label">Contrat</div>
        <select id="f-contrat" name="type_contrat" class="f-select">
          <option value="">—</option>
          <option value="CDI">CDI</option>
          <option value="CDD">CDD</option>
          <option value="Stage">Stage</option>
          <option value="Alternance">Alternance</option>
          <option value="Freelance">Freelance</option>
        </select>
      </div>
      <div class="field">
        <div class="field-label">Niveau d'études</div>
        <select id="f-niveau" name="niveau_etudes_requis" class="f-select">
          <option value="">—</option>
          <option value="Bac">Bac</option>
          <option value="Licence">Licence</option>
          <option value="Master">Master</option>
          <option value="Doctorat">Doctorat</option>
        </select>
      </div>
    </div>
    <div class="field">
      <div class="field-label">Expérience</div>
      <select id="f-exp" name="experience_requise" class="f-select">
        <option value="">—</option>
        <option value="0-2">Junior (0-2 ans)</option>
        <option value="3-5">Confirmé (3-5 ans)</option>
        <option value="5+">Senior (5+ ans)</option>
      </select>
    </div>
    <div class="field">
      <div class="field-label">Description du poste</div>
      <textarea id="f-desc" name="description_offre" class="f-input" placeholder="Décrivez le poste, les missions, l'environnement de travail..."></textarea>
    </div>
    <div class="field">
      <div class="field-label">Compétences requises</div>
      <div class="skill-row">
        <input id="skill-inp" class="f-input" type="text" placeholder="Ajouter une compétence..." onkeydown="if(event.key==='Enter')addSkill()" style="flex:1">
        <button type="button" class="skill-add-btn" onclick="addSkill()"><i class="ti ti-plus"></i></button>
      </div>
      <div class="tags-wrap" id="tags-wrap"></div>
    </div>
  </div>

  <button type="button" class="btn-next" style="width:100%" onclick="goTo(2)">Continuer <i class="ti ti-arrow-right"></i></button>
</div>

<!-- STEP 2 — Questionnaire -->
<div id="s2" class="page hidden">
  <a href="#" class="back-link" onclick="goTo(1);return false"><i class="ti ti-arrow-left"></i> Retour</a>
  <div class="page-title">Créer une nouvelle offre</div>

  <div class="stepper">
    <div class="step done" onclick="goTo(1)"><i class="ti ti-briefcase"></i> 1. Informations</div>
    <div class="step active" onclick="goTo(2)"><i class="ti ti-clipboard-list"></i> 2. Questionnaire</div>
    <div class="step" onclick="goTo(3)"><i class="ti ti-git-branch"></i> 3. Processus</div>
    <div class="step" onclick="goTo(4)"><i class="ti ti-eye"></i> 4. Aperçu</div>
  </div>

  <div class="form-card">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:6px">
      <div>
        <div class="form-card-title">Questionnaire de candidature</div>
        <div class="form-card-sub" style="margin-bottom:0">Ajoutez des questions pour mieux évaluer les candidats.</div>
      </div>
      <button type="button" class="add-q-btn" onclick="openModal()"><i class="ti ti-plus"></i> Ajouter</button>
    </div>
    <div style="clear:both;margin-top:14px" id="q-list-wrap">
      <div id="q-empty" class="q-empty">
        <i class="ti ti-clipboard-list"></i>
        <p>Aucune question — cliquez sur "Ajouter" pour créer votre questionnaire.</p>
      </div>
      <div id="q-list"></div>
    </div>
  </div>

  <div class="nav-btns">
    <button type="button" class="btn-back" onclick="goTo(1)"><i class="ti ti-arrow-left"></i> Retour</button>
    <button type="button" class="btn-next" onclick="goTo(3)">Continuer <i class="ti ti-arrow-right"></i></button>
  </div>
</div>

<!-- STEP 3 — Processus -->
<div id="s3" class="page hidden">
  <a href="#" class="back-link" onclick="goTo(1);return false"><i class="ti ti-arrow-left"></i> Retour</a>
  <div class="page-title">Créer une nouvelle offre</div>

  <div class="stepper">
    <div class="step done" onclick="goTo(1)"><i class="ti ti-briefcase"></i> 1. Informations</div>
    <div class="step done" onclick="goTo(2)"><i class="ti ti-clipboard-list"></i> 2. Questionnaire</div>
    <div class="step active" onclick="goTo(3)"><i class="ti ti-git-branch"></i> 3. Processus</div>
    <div class="step" onclick="goTo(4)"><i class="ti ti-eye"></i> 4. Aperçu</div>
  </div>

  <div class="form-card">
    <div class="form-card-title">Étapes du processus de recrutement</div>
    <div class="form-card-sub">Personnalisez les étapes que verront les candidats dans leur suivi.</div>
    <div id="etapes-list"></div>
  </div>

  <div class="nav-btns">
    <button type="button" class="btn-back" onclick="goTo(2)"><i class="ti ti-arrow-left"></i> Retour</button>
    <button type="button" class="btn-next" onclick="goTo(4)">Aperçu <i class="ti ti-arrow-right"></i></button>
  </div>
</div>

<!-- STEP 4 — Aperçu -->
<div id="s4" class="page hidden">
  <a href="#" class="back-link" onclick="goTo(1);return false"><i class="ti ti-arrow-left"></i> Retour</a>
  <div class="page-title">Créer une nouvelle offre</div>

  <div class="stepper">
    <div class="step done" onclick="goTo(1)"><i class="ti ti-briefcase"></i> 1. Informations</div>
    <div class="step done" onclick="goTo(2)"><i class="ti ti-clipboard-list"></i> 2. Questionnaire</div>
    <div class="step done" onclick="goTo(3)"><i class="ti ti-git-branch"></i> 3. Processus</div>
    <div class="step active" onclick="goTo(4)"><i class="ti ti-eye"></i> 4. Aperçu</div>
  </div>

  <div class="form-card">
    <div class="apercu-banner"><i class="ti ti-info-circle"></i> Voici l'aperçu de votre offre avant publication.</div>
    <div class="apercu-title" id="ap-titre">Titre du poste</div>
    @php
      $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
    @endphp
    <div class="apercu-sub" id="ap-sub">{{ $entreprise->nom_entreprise }} · Localisation</div>
    <div class="apercu-desc" id="ap-desc">Description du poste...</div>
    <div class="apercu-stats">
      <div>
        <div class="apercu-stat-label">Questionnaire</div>
        <div class="apercu-stat-val" id="ap-q">0 questions</div>
      </div>
      <div>
        <div class="apercu-stat-label">Processus</div>
        <div class="apercu-stat-val" id="ap-e">5 étapes</div>
      </div>
    </div>
  </div>

  <div class="nav-btns">
    <button type="button" class="btn-back" onclick="goTo(3)"><i class="ti ti-arrow-left"></i> Modifier</button>
    <button type="submit" class="btn-next" id="submit-btn" style="display:flex !important;">Publier l'offre <i class="ti ti-check"></i></button>
  </div>
</div>

</form>

<!-- CONFIRMATION -->
<div id="s5" class="hidden" style="flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;padding:2rem;min-height:calc(100vh - 54px);background:linear-gradient(160deg, #e8eeff 0%, #eef1ff 30%, #f2f4fb 60%, #e6edf8 100%)">
  <div class="success-block" style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:0;animation:fadeUp 0.5s cubic-bezier(.22,1,.36,1) both">
    <style>
      @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
      }
      @keyframes popIn {
        from { transform: scale(0.4); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
      }
      .check-circle {
        width: 80px; height: 80px; border-radius: 50%;
        background: linear-gradient(135deg, #5040e8, #7c5cf6);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 2rem;
        box-shadow: 0 12px 40px rgba(80,64,232,0.28);
        animation: popIn 0.45s 0.15s cubic-bezier(.34,1.56,.64,1) both;
      }
      .check-circle i { font-size: 38px; color: #fff; font-weight: 700; }
      .success-title {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 32px;
        color: #1a1550;
        margin-bottom: 1rem;
      }
      .success-sub {
        font-size: 15px;
        color: #8888aa;
        line-height: 1.65;
        max-width: 400px;
        margin-bottom: 2.4rem;
      }
      .success-sub strong { color: #1a1550; font-weight: 700; }
      .btn-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 440px;
        max-width: 100%;
      }
      .btn-primary {
        width: 100%; padding: 16px;
        background: linear-gradient(135deg, #5040e8, #7c5cf6);
        color: #fff; border: none; border-radius: 14px;
        font-size: 15px; font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; text-decoration: none;
        display: flex; align-items: center; justify-content: center;
        transition: opacity 0.15s, transform 0.1s;
        box-shadow: 0 6px 24px rgba(80,64,232,0.22);
      }
      .btn-primary:hover { opacity: 0.9; }
      .btn-primary:active { transform: scale(0.985); }
      .btn-secondary {
        width: 100%; padding: 16px;
        background: #fff; color: #1a1550;
        border: 1px solid #e4e4f0; border-radius: 14px;
        font-size: 15px; font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; text-decoration: none;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s, border-color 0.15s;
      }
      .btn-secondary:hover { background: #f8f8fc; border-color: #c0c0d8; }
    </style>

    <div class="check-circle">
      <i class="ti ti-check"></i>
    </div>

    <h1 class="success-title">Offre publiée !</h1>

    <p class="success-sub">
      Votre offre <strong>{{ session('titre_offre') ?? 'Nouveau poste' }}</strong> est maintenant en ligne.<br>
      Elle sera visible par les candidats correspondant à votre profil recherché.
    </p>

    <div class="btn-group">
      <a href="{{ route('entreprise.offres.detail', ['id_offre' => session('newOffreId') ?? 1]) }}" class="btn-primary">Voir les candidatures</a>
      <a href="{{ route('entreprise.dashboard') }}" class="btn-secondary">Retour au dashboard</a>
    </div>
  </div>
</div>

<!-- MODAL ajouter question -->
<div class="modal-overlay" id="modal-overlay" onclick="closeModalOutside(event)">
  <div class="modal">
    <div class="modal-title">Ajouter une question</div>
    <div class="field">
      <div class="field-label">Question <span style="color:var(--accent)">*</span></div>
      <input id="m-question" class="f-input" type="text" placeholder="Ex: Quel est votre niveau en React ?">
    </div>
    <div class="field">
      <div class="field-label">Type de réponse</div>
      <select id="m-type" class="f-select" onchange="toggleOptionsField()">
        <option value="text">Texte libre</option>
        <option value="qcm">QCM</option>
      </select>
    </div>
    <div class="field">
      <div class="field-label">Barème de points</div>
      <input id="m-points" class="f-input" type="number" placeholder="Ex: 10" min="0" value="10">
    </div>
    <div class="field hidden" id="keywords-field">
      <div class="field-label">Bonne réponse</div>
      <input id="m-keywords" class="f-input" type="text" placeholder="Ex: React, JavaScript, Frontend">
    </div>
    <div class="field hidden" id="options-field">
      <div class="field-label">Choix de réponse <span style="color:var(--accent)">*</span></div>
      <div id="options-list"></div>
      <div class="skill-row" style="margin-top:8px">
        <input id="option-inp" class="f-input" type="text" placeholder="Ajouter un choix..." onkeydown="if(event.key==='Enter')addOption()" style="flex:1">
        <button type="button" class="skill-add-btn" onclick="addOption()"><i class="ti ti-plus"></i></button>
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal()">Annuler</button>
      <button class="btn-add-q" onclick="addQuestion()">Ajouter</button>
    </div>
  </div>
</div>

<script>
// ---- STATE ----
let currentStep = 1;
const skills = [];
const questions = [];
const etapes = ['Candidature reçue','En cours d\'examen','Entretien','Test technique','Réponse finale'];
const currentOptions = [];

// ---- INIT ----
renderEtapes();
toggleOptionsField();

function goTo(n) {
  if (n === 4) refreshApercu();
  document.querySelectorAll('[id^="s"]').forEach(el => el.classList.add('hidden'));
  const el = document.getElementById('s' + n);
  if (el) { el.classList.remove('hidden'); }
  currentStep = n;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ---- SKILLS ----
function addSkill() {
  const inp = document.getElementById('skill-inp');
  const val = inp.value.trim();
  if (!val) return;
  skills.push(val);
  renderSkills();
  inp.value = '';
}
function renderSkills() {
  const wrap = document.getElementById('tags-wrap');
  wrap.innerHTML = skills.map((s, i) =>
    `<div class="tag">${s} <span class="tag-rm" onclick="removeSkill(${i})">×</span></div>` 
  ).join('');
}
function removeSkill(i) { skills.splice(i, 1); renderSkills(); }

// ---- QUESTIONS ----
function toggleOptionsField() {
  const type = document.getElementById('m-type').value;
  const optionsField = document.getElementById('options-field');
  const keywordsField = document.getElementById('keywords-field');
  if (type === 'text') {
    optionsField.classList.add('hidden');
    keywordsField.classList.remove('hidden');
  } else {
    optionsField.classList.remove('hidden');
    keywordsField.classList.add('hidden');
  }
}

function openModal() {
  document.getElementById('m-question').value = '';
  document.getElementById('m-type').value = 'text';
  document.getElementById('m-points').value = '10';
  document.getElementById('m-keywords').value = '';
  currentOptions.length = 0;
  renderOptions();
  toggleOptionsField();
  document.getElementById('modal-overlay').classList.add('open');
  setTimeout(() => document.getElementById('m-question').focus(), 100);
}

function closeModal() { 
  document.getElementById('modal-overlay').classList.remove('open');
  currentOptions.length = 0;
  renderOptions();
}

function closeModalOutside(e) { if (e.target === document.getElementById('modal-overlay')) closeModal(); }

function addOption() {
  const inp = document.getElementById('option-inp');
  const val = inp.value.trim();
  if (!val) return;
  currentOptions.push({ text: val, isCorrect: false });
  renderOptions();
  inp.value = '';
}

function renderOptions() {
  const list = document.getElementById('options-list');
  list.innerHTML = currentOptions.map((opt, i) =>
    `<div class="tag" style="margin-bottom:4px;display:flex;align-items:center;gap:8px">
      <input type="radio" name="correct-option" onchange="setCorrectOption(${i})" ${opt.isCorrect ? 'checked' : ''}>
      <span>${opt.text}</span>
      <span class="tag-rm" onclick="removeOption(${i})">×</span>
    </div>`
  ).join('');
}

function setCorrectOption(index) {
  currentOptions.forEach((opt, i) => {
    opt.isCorrect = (i === index);
  });
  renderOptions();
}

function removeOption(i) {
  currentOptions.splice(i, 1);
  renderOptions();
}

function addQuestion() {
  const q = document.getElementById('m-question').value.trim();
  const t = document.getElementById('m-type').value;
  const points = parseInt(document.getElementById('m-points').value) || 10;
  const keywords = document.getElementById('m-keywords').value.trim();
  if (!q) return;
  
  if (t !== 'text' && currentOptions.length === 0) {
    alert('Veuillez ajouter au moins un choix de réponse.');
    return;
  }
  
  if (t === 'qcm') {
    const hasCorrect = currentOptions.some(opt => opt.isCorrect);
    if (!hasCorrect) {
      alert('Veuillez sélectionner la bonne réponse pour le QCM.');
      return;
    }
  }
  
  questions.push({ q, t, points, options: t !== 'text' ? [...currentOptions] : [], keywords: t === 'text' ? keywords : '' });
  renderQuestions();
  closeModal();
}

function renderQuestions() {
  const empty = document.getElementById('q-empty');
  const list = document.getElementById('q-list');
  if (questions.length === 0) { empty.classList.remove('hidden'); list.innerHTML = ''; return; }
  empty.classList.add('hidden');
  const typeLabels = { text: 'Texte libre', qcm: 'QCM' };
  list.innerHTML = questions.map((item, i) =>
    `<div class="q-item-card">
      <div class="q-num">${i+1}</div>
      <div style="flex:1">
        <div class="q-text">${item.q}</div>
        <div class="q-type-badge">${typeLabels[item.t]}${item.options && item.options.length > 0 ? ' · ' + item.options.length + ' choix' : ''} · ${item.points} pts</div>
      </div>
      <button type="button" class="q-edit" onclick="editQ(${i})"><i class="ti ti-pencil"></i></button>
      <button type="button" class="q-del" onclick="removeQ(${i})"><i class="ti ti-trash"></i></button>
    </div>`
  ).join('');
}
function removeQ(i) { questions.splice(i, 1); renderQuestions(); }
function editQ(i) {
  const item = questions[i];
  document.getElementById('m-question').value = item.q;
  document.getElementById('m-type').value = item.t;
  document.getElementById('m-points').value = item.points;
  document.getElementById('m-keywords').value = item.keywords || '';
  currentOptions.length = 0;
  if (item.options) {
    item.options.forEach(opt => {
      // Handle both old format (string) and new format (object with text and isCorrect)
      if (typeof opt === 'string') {
        currentOptions.push({ text: opt, isCorrect: false });
      } else {
        currentOptions.push(opt);
      }
    });
  }
  renderOptions();
  toggleOptionsField();
  questions.splice(i, 1);
  renderQuestions();
  openModal();
}

// ---- ÉTAPES ----
function renderEtapes() {
  const list = document.getElementById('etapes-list');
  list.innerHTML = etapes.map((e, i) =>
    `<div class="etape-row">
      <div class="etape-num">${i+1}</div>
      <input class="etape-input" type="text" value="${e}" oninput="etapes[${i}]=this.value">
      <button type="button" class="etape-del" onclick="removeEtape(${i})"><i class="ti ti-x" style="color:var(--red)"></i></button>
    </div>`
  ).join('');
}
function removeEtape(i) { etapes.splice(i, 1); renderEtapes(); }

// ---- APERÇU ----
function refreshApercu() {
  const titre = document.getElementById('f-titre').value || 'Titre du poste';
  const loc = document.getElementById('f-loc').value || 'Localisation';
  const desc = document.getElementById('f-desc').value || 'Description du poste...';
  document.getElementById('ap-titre').textContent = titre;
  document.getElementById('ap-sub').textContent = '{{ $entreprise->nom_entreprise }} · ' + loc;
  document.getElementById('ap-desc').textContent = desc;
  document.getElementById('ap-q').textContent = questions.length + ' question' + (questions.length !== 1 ? 's' : '');
  document.getElementById('ap-e').textContent = etapes.length + ' étape' + (etapes.length !== 1 ? 's' : '');
}

// ---- SUBMIT ----
function prepareSubmit() {
  console.log('prepareSubmit called');
  console.log('skills:', skills);
  console.log('questions:', questions);
  console.log('etapes:', etapes);
  
  try {
    document.getElementById('competences-input').value = skills.join(', ');
    document.getElementById('questions-input').value = JSON.stringify(questions);
    document.getElementById('etapes-input').value = JSON.stringify(etapes);
    
    console.log('competences-input:', document.getElementById('competences-input').value);
    console.log('questions-input:', document.getElementById('questions-input').value);
    console.log('etapes-input:', document.getElementById('etapes-input').value);
    
    return true;
  } catch (error) {
    console.error('Error in prepareSubmit:', error);
    return false;
  }
}

// Check if offer was just created
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOMContentLoaded - checking for newOffreId');
  
  @if(session('newOffreId'))
    console.log('newOffreId found in session: {{ session('newOffreId') }}');
    console.log('titre_offre found in session: {{ session('titre_offre') ?? 'N/A' }}');
    document.getElementById('s1').classList.add('hidden');
    document.getElementById('s5').classList.remove('hidden');
    console.log('Showing confirmation page');
  @else
    console.log('No newOffreId in session, showing normal form');
  @endif
});
</script>
</body>
</html>
