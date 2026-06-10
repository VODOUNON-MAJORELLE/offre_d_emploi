<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon Profil — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg-page: #f0f2f7;
    --bg-card: #ffffff;
    --bg-secondary: #f5f6fa;
    --text-primary: #1a1a2e;
    --text-secondary: #6b7280;
    --text-tertiary: #9ca3af;
    --border: rgba(0,0,0,0.08);
    --accent: #5b4be8;
    --accent-light: #eeedf9;
    --accent-border: #7c6ff0;
    --green: #16a34a;
    --green-light: #dcfce7;
    --radius-md: 8px;
    --radius-lg: 14px;
  }

  body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--bg-page);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 0;
  }
  .page-wrap {
    padding: 32px 24px 48px;
  }

  /* Header */
  .page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 980px;
    margin: 0 auto 24px;
  }
  .page-title { font-size: 22px; font-weight: 700; }
  .save-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #7c6ff0, #5b4be8);
    color: #fff;
    border: none; border-radius: var(--radius-md);
    font-size: 14px; font-weight: 500; font-family: inherit;
    cursor: pointer; transition: all 0.2s;
  }
  .save-btn:hover { opacity: 0.88; }
  .save-btn.edit-mode {
    background: linear-gradient(135deg, #7c6ff0, #5b4be8);
  }
  .save-btn.view-mode {
    background: #374151;
  }
  .field-input:disabled, textarea.about:disabled {
    background: var(--bg-secondary);
    color: var(--text-secondary);
    cursor: default;
    border-color: transparent;
  }

  /* Layout */
  .layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 16px;
    max-width: 980px;
    margin: 0 auto;
    align-items: start;
  }

  /* Card */
  .card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    border: 0.5px solid var(--border);
    padding: 20px;
    margin-bottom: 14px;
  }
  .card:last-child { margin-bottom: 0; }

  /* Left sidebar */
  .avatar-wrap { text-align: center; margin-bottom: 16px; }
  .avatar {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: var(--accent);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 20px; font-weight: 700; color: #fff;
    cursor: pointer; transition: opacity 0.15s;
    margin-bottom: 8px;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
  }
  .avatar.avatar-with-photo {
    background-color: transparent !important;
    color: transparent !important;
  }
  .avatar:hover { opacity: 0.85; }
  .avatar-hint { font-size: 11px; color: var(--text-tertiary); }

  .field-input {
    width: 100%;
    border: 0.5px solid var(--border);
    border-radius: var(--radius-md);
    padding: 9px 12px;
    font-size: 13px; font-family: inherit;
    color: var(--text-primary);
    background: var(--bg-card);
    outline: none; transition: border-color 0.15s;
    margin-bottom: 8px;
  }
  .field-input:focus { border-color: var(--accent); }

  .info-grid { margin-top: 10px; }
  .info-row {
    display: flex; justify-content: space-between;
    font-size: 12px; padding: 5px 0;
    border-bottom: 0.5px solid var(--border);
  }
  .info-row:last-child { border-bottom: none; }
  .info-label { color: var(--text-secondary); }
  .info-value { color: var(--text-primary); font-weight: 500; text-align: right; }

  /* Profil complété */
  .completion-header {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 10px;
  }
  .completion-title { font-size: 14px; font-weight: 600; }
  .completion-pct { font-size: 14px; font-weight: 700; color: var(--accent); }
  .completion-bar {
    height: 6px; background: var(--border);
    border-radius: 99px; overflow: hidden; margin-bottom: 14px;
  }
  .completion-fill {
    height: 100%; width: 86%;
    background: linear-gradient(90deg, #7c6ff0, #5b4be8);
    border-radius: 99px;
  }
  .checklist { list-style: none; }
  .checklist li {
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; padding: 3px 0;
  }
  .checklist li .icon-check { color: var(--green); font-size: 15px; }
  .checklist li .icon-circle { color: var(--text-tertiary); font-size: 15px; }
  .checklist li.done span { text-decoration: line-through; color: var(--text-tertiary); }
  .checklist li:not(.done) span { color: var(--text-primary); }

  /* Mon CV */
  .cv-row {
    display: flex; align-items: center;
    justify-content: space-between;
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    padding: 10px 12px;
  }
  .cv-info { display: flex; align-items: center; gap: 10px; }
  .cv-icon { font-size: 20px; color: var(--text-secondary); }
  .cv-name { font-size: 13px; font-weight: 500; }
  .cv-date { font-size: 11px; color: var(--text-tertiary); margin-top: 1px; }
  .cv-modify { font-size: 13px; font-weight: 600; color: var(--accent); cursor: pointer; }
  .cv-modify:hover { opacity: 0.75; }

  /* Right column */
  .card-section-title {
    display: flex; align-items: center; gap: 8px;
    font-size: 17px; font-weight: 700;
    margin-bottom: 14px;
  }
  .card-section-title i { font-size: 18px; color: var(--accent); }

  .card-section-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
  }
  .add-link {
    font-size: 13px; font-weight: 500; color: var(--accent);
    cursor: pointer; display: flex; align-items: center; gap: 3px;
  }
  .add-link:hover { opacity: 0.75; }

  /* À propos */
  textarea.about {
    width: 100%; min-height: 90px;
    border: 0.5px solid var(--border);
    border-radius: var(--radius-md);
    padding: 10px 12px;
    font-size: 13px; font-family: inherit;
    color: var(--text-primary);
    background: var(--bg-card);
    resize: vertical; outline: none;
    transition: border-color 0.15s;
  }
  textarea.about:focus { border-color: var(--accent); }

  /* Compétences */
  .tags-wrap { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }
  .tag {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px;
    background: var(--accent-light);
    border: 0.5px solid var(--accent-border);
    border-radius: 99px;
    font-size: 13px; color: var(--text-primary);
  }
  .tag-remove {
    cursor: pointer; color: var(--text-secondary);
    font-size: 12px; line-height: 1;
    transition: color 0.12s;
  }
  .tag-remove:hover { color: #e11d48; }
  .skill-add-row { display: flex; gap: 8px; align-items: center; }
  .skill-input {
    flex: 1;
    border: 0.5px solid var(--border);
    border-radius: var(--radius-md);
    padding: 9px 14px;
    font-size: 13px; font-family: inherit;
    color: var(--text-primary);
    background: var(--bg-card);
    outline: none; transition: border-color 0.15s;
  }
  .skill-input:focus { border-color: var(--accent); }
  .skill-add-btn {
    width: 36px; height: 36px;
    border-radius: var(--radius-md);
    background: var(--accent);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 18px; flex-shrink: 0;
    transition: opacity 0.15s;
  }
  .skill-add-btn:hover { opacity: 0.85; }

  /* Experience / Formation */
  .entry { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; }
  .entry:last-child { margin-bottom: 0; }
  .entry-icon {
    width: 36px; height: 36px; border-radius: 8px;
    background: var(--accent-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: var(--accent); flex-shrink: 0;
    margin-top: 1px;
  }
  .entry-title { font-size: 14px; font-weight: 600; }
  .entry-sub { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
  .entry-desc { font-size: 12px; color: var(--text-tertiary); margin-top: 4px; }
  .entry-delete {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: var(--text-tertiary); font-size: 15px;
    padding: 4px; border-radius: 6px; transition: color .12s, background .12s;
    flex-shrink: 0;
  }
  .entry-delete:hover { color: #e11d48; background: #fef2f2; }
  .empty-state { text-align:center; padding:20px 0; color:var(--text-tertiary); font-size:13px; }

  /* Modal */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.45); z-index: 1000;
    align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: var(--bg-card); border-radius: var(--radius-lg);
    padding: 28px 24px; width: 100%; max-width: 480px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    animation: modalIn .2s ease;
  }
  @keyframes modalIn { from{transform:translateY(16px);opacity:0} to{transform:translateY(0);opacity:1} }
  .modal-title { font-size: 17px; font-weight: 700; margin-bottom: 18px; }
  .modal-field { margin-bottom: 12px; }
  .modal-field label { display:block; font-size: 12px; font-weight:600; color:var(--text-secondary); margin-bottom: 5px; }
  .modal-field input, .modal-field textarea {
    width:100%; border: 0.5px solid var(--border); border-radius: var(--radius-md);
    padding: 9px 12px; font-size:13px; font-family:inherit;
    color: var(--text-primary); background: var(--bg-card);
    outline:none; transition: border-color .15s;
  }
  .modal-field input:focus, .modal-field textarea:focus { border-color: var(--accent); }
  .modal-row { display:flex; gap:10px; }
  .modal-row .modal-field { flex:1; }
  .modal-actions { display:flex; gap:8px; margin-top:18px; justify-content:flex-end; }
  .modal-cancel {
    padding: 9px 18px; border-radius: var(--radius-md); border: 0.5px solid var(--border);
    background: var(--bg-secondary); font-size:13px; font-family:inherit;
    cursor:pointer; color: var(--text-secondary);
  }
  .modal-save {
    padding: 9px 22px; border-radius: var(--radius-md); border: none;
    background: linear-gradient(135deg,#7c6ff0,#5b4be8); color:#fff;
    font-size:13px; font-weight:600; font-family:inherit; cursor:pointer;
    transition: opacity .15s;
  }
  .modal-save:hover { opacity:.88; }

  /* Candidatures récentes */
  .cand-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
  }
  .cand-title { font-size: 17px; font-weight: 700; }
  .voir-tout { font-size: 13px; color: var(--accent); cursor: pointer; display: flex; align-items: center; gap: 2px; }
  .voir-tout:hover { opacity: 0.75; }

  .cand-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 0;
    border-bottom: 0.5px solid var(--border);
  }
  .cand-item:last-child { border-bottom: none; padding-bottom: 0; }
  .cand-avatar {
    width: 38px; height: 38px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 600; color: #fff; flex-shrink: 0;
  }
  .cand-info { flex: 1; }
  .cand-name { font-size: 13px; font-weight: 500; }
  .cand-company { font-size: 12px; color: var(--text-secondary); margin-top: 1px; }
  .badge {
    font-size: 11px; font-weight: 500;
    padding: 4px 10px; border-radius: 99px;
    white-space: nowrap;
  }
  .badge-blue { background: #dbeafe; color: #1d4ed8; }
  .badge-orange { background: #fef3c7; color: #b45309; }

  /* NAV */
  nav{background:var(--bg-card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100; margin-bottom: 32px;}
  .nav-left{display:flex;align-items:center;gap:32px}
  .nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px;text-decoration:none;color:var(--text-primary)}
  .logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
  .nav-links{display:flex;gap:24px}
  .nav-link{font-size:13px;color:var(--text-secondary);cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px}
  .nav-link:hover{color:var(--text-primary)}
  .nav-link.active{color:var(--accent);font-weight:600;border-bottom:2px solid var(--accent)}
  .nav-right{display:flex;align-items:center;gap:12px}
  .notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--text-secondary);text-decoration:none}
  .notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
  .user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
  .logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--text-tertiary);transition:color .12s}
  .logout-btn:hover{color:var(--text-primary)}

  @media (max-width: 720px) {
    .layout { grid-template-columns: 1fr; }
    body { padding: 0 0 16px; }
    nav { padding: 0 16px; margin-bottom: 24px; }
  }
</style>
</head>
<body>

@php
  $isCandidat = \Illuminate\Support\Facades\Auth::guard('candidat')->check();
  $isEntreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->check();
  $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
@endphp

@if($isCandidat)
<nav>
  <div class="nav-left">
    <a href="/" class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </a>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('candidat.feed') }}">Feed</a>
      <a class="nav-link active" href="{{ route('candidat.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $unreadNotifCount = \App\Models\Notification::where('id_candidat', $candidat->id_candidat)->where('statut_lecture', 'non lu')->count();
      $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
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
@elseif($isEntreprise)
<nav>
  <div class="nav-left">
    <a href="/" class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </a>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
      <a class="nav-link" href="{{ route('entreprise.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $unreadNotifCount = \App\Models\Notification::where('id_entreprise', $entreprise->id_entreprise)->where('statut_lecture', 'non lu')->count();
      $initials = substr($entreprise->nom_entreprise, 0, 2);
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
@endif

<div class="page-wrap">
{{-- Success Message --}}
@if(session('success'))
<div style="background: #d1fae5; border: 0.5px solid #10b981; border-radius: var(--radius-lg); padding: 12px 16px; margin-bottom: 16px; max-width: 980px; margin-left: auto; margin-right: auto;">
  <div style="display: flex; align-items: center; gap: 8px;">
    <span style="font-size: 18px;">✅</span>
    <div style="font-size: 13px; color: #065f46;">{{ session('success') }}</div>
  </div>
</div>
@endif

{{-- Error Message --}}
@if($errors->any())
<div style="background: #fef2f2; border: 0.5px solid #fecaca; border-radius: var(--radius-lg); padding: 12px 16px; margin-bottom: 16px; max-width: 980px; margin-left: auto; margin-right: auto;">
  <div style="display: flex; align-items: start; gap: 8px;">
    <span style="font-size: 18px;">⚠️</span>
    <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #991b1b;">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endif

<form action="{{ route('candidat.profil.update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="page-header">
    <h1 class="page-title">Mon Profil</h1>
    @if($isCandidat)
      <div style="display:flex;gap:8px;">
        <button type="button" id="btn-modifier" class="save-btn view-mode" onclick="enableEditing()"><i class="ti ti-edit"></i> Modifier</button>
        <button type="submit" id="btn-enregistrer" class="save-btn edit-mode" style="display:none;"><i class="ti ti-check"></i> Enregistrer</button>
      </div>
    @endif
  </div>

  <div class="layout">

    <!-- Colonne gauche -->
    <div class="left-col">

      <!-- Infos personnelles -->
      <div class="card">
        <div class="avatar-wrap">
          @if($candidat->photo_profil)
            <div class="avatar avatar-with-photo" id="avatar-click" style="background-image: url('{{ asset('storage/' . $candidat->photo_profil) }}'); background-size: cover; background-position: center;" title="Cliquez pour modifier"></div>
          @else
            <div class="avatar" id="avatar-click" title="Cliquez pour modifier">{{ substr($candidat->prenom, 0, 1) }}{{ substr($candidat->nom, 0, 1) }}</div>
          @endif
          <input type="file" id="photo-profil-input" name="photo_profil" accept="image/*" style="display:none">
          <div id="photo-error" style="display:none; margin-top:10px; padding:8px 12px; background:#fef2f2; border:0.5px solid #fecaca; border-radius:8px; font-size:12px; color:#991b1b; align-items:center; gap:8px;">
            <i class="ti ti-alert-circle" style="font-size:15px; flex-shrink:0;"></i>
            <span>La photo ne doit pas dépasser <strong>5 MB</strong>.</span>
          </div>
          <div class="avatar-hint">Cliquez sur la photo pour modifier</div>
        </div>
        <div style="display:flex; gap:8px; margin-bottom:8px;">
          <input class="field-input" type="text" name="prenom" value="{{ $candidat->prenom }}" placeholder="Prénom" required style="margin-bottom:0">
          <input class="field-input" type="text" name="nom" value="{{ $candidat->nom }}" placeholder="Nom" required style="margin-bottom:0">
        </div>
        <input class="field-input" type="text" name="titre_professionnel" value="{{ $candidat->titre_professionnel ?? '' }}" placeholder="Titre / poste">
        
        <div style="margin-top:10px;">
          <input class="field-input" type="email" name="email" value="{{ $candidat->email }}" placeholder="Email" readonly title="Email (non modifiable ici)">
          <input class="field-input" type="text" name="telephone" value="{{ $candidat->telephone ?? '' }}" placeholder="Téléphone" required>
          <input class="field-input" type="text" name="ville" value="{{ $candidat->ville ?? '' }}" placeholder="Ville" required>
          
          <select class="field-input" name="niveau_etudes" required>
            <option value="">Sélectionnez un niveau d'études</option>
            <option value="Bac" {{ $candidat->niveau_etudes == 'Bac' ? 'selected' : '' }}>Bac</option>
            <option value="Licence+2" {{ $candidat->niveau_etudes == 'Licence+2' ? 'selected' : '' }}>Bac+2 / BTS</option>
            <option value="Licence" {{ $candidat->niveau_etudes == 'Licence' ? 'selected' : '' }}>Licence / Bac+3</option>
            <option value="Master" {{ $candidat->niveau_etudes == 'Master' ? 'selected' : '' }}>Master / Bac+5</option>
            <option value="Doctorat" {{ $candidat->niveau_etudes == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
          </select>
          
          <input class="field-input" type="number" name="annees_experience" value="{{ $candidat->annees_experience ?? '' }}" placeholder="Années d'expérience" required min="0" max="50">
        </div>
      </div>

      <!-- Profil complété -->
      <div class="card">
        <div class="completion-header">
          <span class="completion-title">Profil complété</span>
          <span class="completion-pct">{{ $completion }}%</span>
        </div>
        <div class="completion-bar"><div class="completion-fill" style="width: {{ $completion }}%;"></div></div>
        <ul class="checklist">
          <li class="{{ $steps['photo'] ? 'done' : '' }}">
            <i class="ti {{ $steps['photo'] ? 'ti-circle-check-filled icon-check' : 'ti-circle icon-circle' }}"></i>
            <span>Photo de profil</span>
          </li>
          <li class="{{ $steps['telephone'] ? 'done' : '' }}">
            <i class="ti {{ $steps['telephone'] ? 'ti-circle-check-filled icon-check' : 'ti-circle icon-circle' }}"></i>
            <span>Informations personnelles</span>
          </li>
          <li class="{{ $steps['cv'] ? 'done' : '' }}">
            <i class="ti {{ $steps['cv'] ? 'ti-circle-check-filled icon-check' : 'ti-circle icon-circle' }}"></i>
            <span>CV importé</span>
          </li>
          <li class="{{ $steps['competences'] ? 'done' : '' }}">
            <i class="ti {{ $steps['competences'] ? 'ti-circle-check-filled icon-check' : 'ti-circle icon-circle' }}"></i>
            <span>Compétences renseignées</span>
          </li>
        </ul>
      </div>

      <!-- Mon CV -->
      <div class="card">
        <div class="card-section-header" style="margin-bottom:12px;">
          <div class="card-section-title" style="margin-bottom:0"><i class="ti ti-file-text"></i> Mon CV</div>
          @if($principalCv)
            <a href="{{ route('cvs.download', ['id_cv' => $principalCv->id_cv]) }}" class="add-link"><i class="ti ti-download"></i> Télécharger</a>
          @endif
        </div>
        @if($principalCv)
          <div class="cv-row" @if(!$isEntreprise) onclick="window.open('{{ asset('storage/' . $principalCv->contenu_fichier) }}', '_blank')" style="cursor: pointer;" title="Cliquez pour afficher votre CV" @endif>
            <div class="cv-info">
              <i class="ti ti-file-description cv-icon"></i>
              <div>
                <div class="cv-name">{{ $principalCv->nom_fichier }}</div>
                <div class="cv-date">Mis à jour le {{ $principalCv->date_upload->format('d/m/Y') }}</div>
              </div>
            </div>
          </div>
        @else
          <div class="cv-row" @if(!$isEntreprise) onclick="document.getElementById('cv-upload').click()" style="cursor: pointer;" title="Cliquez pour importer votre CV" @endif>
            <div class="cv-info">
              <i class="ti ti-upload cv-icon"></i>
              <div>
                <div class="cv-name">Aucun CV importé</div>
                <div class="cv-date">@if($isEntreprise) Ce candidat n'a pas de CV @else Cliquez pour importer @endif</div>
              </div>
            </div>
          </div>
        @endif
        @if(!$isEntreprise)
          <div id="cv-error" style="display:none; margin-top:10px; padding:8px 12px; background:#fef2f2; border:0.5px solid #fecaca; border-radius:8px; font-size:12px; color:#991b1b; align-items:center; gap:8px;">
            <i class="ti ti-alert-circle" style="font-size:15px; flex-shrink:0;"></i>
            <span>Le CV ne doit pas dépasser <strong>5 MB</strong>.</span>
          </div>
          <input type="file" id="cv-upload" name="cv_file" accept=".pdf,.doc,.docx" style="display:none" onchange="uploadCv(this)">
        @endif
      </div>

    </div>

    <!-- Colonne droite -->
    <div class="right-col">

      <!-- Compétences -->
      <div class="card">
        <div class="card-section-title"><i class="ti ti-star"></i> Compétences</div>
        <div class="tags-wrap" id="tags-wrap">
          @foreach($competences as $competence)
            @if(trim($competence))
              <div class="tag">{{ trim($competence) }} <span class="tag-remove" onclick="removeTag(this)">×</span></div>
            @endif
          @endforeach
        </div>
        <div class="skill-add-row">
          <input type="hidden" id="competences-input" name="competences" value="{{ $candidat->competences ?? '' }}">
          <input class="skill-input" id="skill-input" type="text" placeholder="Ajouter une compétence..." onkeydown="if(event.key==='Enter') addTag()">
          <button type="button" class="skill-add-btn" onclick="addTag()"><i class="ti ti-plus"></i></button>
        </div>
      </div>

      <!-- Expériences -->
      <div class="card">
        <div class="card-section-header">
          <div class="card-section-title" style="margin-bottom:0"><i class="ti ti-briefcase"></i> Expériences</div>
          <span class="add-link" onclick="openModal('modal-experience')"><i class="ti ti-plus"></i> Ajouter</span>
        </div>
        @forelse($experiences as $exp)
          <div class="entry">
            <div class="entry-icon"><i class="ti ti-briefcase"></i></div>
            <div style="flex:1">
              <div class="entry-title">{{ $exp->poste }}</div>
              <div class="entry-sub">{{ $exp->entreprise }} · {{ $exp->periode }}</div>
              @if($exp->description)
                <div class="entry-desc">{{ $exp->description }}</div>
              @endif
            </div>
            <button type="button" class="entry-delete" title="Supprimer" onclick="deleteExperience({{ $exp->id_experience }})"><i class="ti ti-trash"></i></button>
          </div>
        @empty
          <div class="empty-state">Aucune expérience ajoutée — <span style="color:var(--accent);cursor:pointer" onclick="openModal('modal-experience')">Ajouter</span></div>
        @endforelse
      </div>

      <!-- Formation -->
      <div class="card">
        <div class="card-section-header">
          <div class="card-section-title" style="margin-bottom:0"><i class="ti ti-school"></i> Formation</div>
          <span class="add-link" onclick="openModal('modal-formation')"><i class="ti ti-plus"></i> Ajouter</span>
        </div>
        @forelse($formations as $form)
          <div class="entry">
            <div class="entry-icon"><i class="ti ti-school"></i></div>
            <div style="flex:1">
              <div class="entry-title">{{ $form->diplome }}</div>
              <div class="entry-sub">{{ $form->etablissement }} · {{ $form->periode }}</div>
              @if($form->description)
                <div class="entry-desc">{{ $form->description }}</div>
              @endif
            </div>
            <button type="button" class="entry-delete" title="Supprimer" onclick="deleteFormation({{ $form->id_formation }})"><i class="ti ti-trash"></i></button>
          </div>
        @empty
          <div class="empty-state">Aucune formation ajoutée — <span style="color:var(--accent);cursor:pointer" onclick="openModal('modal-formation')">Ajouter</span></div>
        @endforelse
      </div>

      <!-- Candidatures récentes -->
      <div class="card">
        <div class="cand-header">
          <div class="cand-title">Candidatures récentes</div>
          <a href="{{ route('candidat.dashboard') }}" class="voir-tout">Voir tout <i class="ti ti-chevron-right"></i></a>
        </div>
        @php
          $recentApplications = \App\Models\Candidature::with('offre.entreprise')
              ->where('id_candidat', $candidat->id_candidat)
              ->orderByDesc('date_soumission')
              ->limit(3)
              ->get();
        @endphp
        @if($recentApplications->count() > 0)
          @foreach($recentApplications as $app)
            <div class="cand-item">
              <div class="cand-avatar" style="background:#5b4be8;">{{ substr($app->offre->entreprise->nom_entreprise, 0, 2) }}</div>
              <div class="cand-info">
                <div class="cand-name">{{ $app->offre->titre_offre }}</div>
                <div class="cand-company">{{ $app->offre->entreprise->nom_entreprise }}</div>
              </div>
              <span class="badge badge-blue">En cours</span>
            </div>
          @endforeach
        @else
          <div style="text-align: center; padding: 20px; color: var(--text-tertiary); font-size: 13px;">
            Aucune candidature pour le moment
          </div>
        @endif
      </div>

    </div>
  </div>
</form>

{{-- Modal Expérience --}}
<div class="modal-overlay" id="modal-experience">
  <div class="modal">
    <div class="modal-title"><i class="ti ti-briefcase" style="color:var(--accent)"></i> Ajouter une expérience</div>
    <form action="{{ route('candidat.experiences.store') }}" method="POST">
      @csrf
      <div class="modal-field">
        <label>Intitulé du poste *</label>
        <input type="text" name="poste" placeholder="Ex: Développeur Full Stack" required>
      </div>
      <div class="modal-field">
        <label>Entreprise *</label>
        <input type="text" name="entreprise" placeholder="Ex: StartupXYZ" required>
      </div>
      <div class="modal-row">
        <div class="modal-field">
          <label>Année début *</label>
          <input type="text" name="annee_debut" placeholder="2022" required maxlength="4">
        </div>
        <div class="modal-field">
          <label>Année fin</label>
          <input type="text" name="annee_fin" placeholder="2024 (vide = Présent)" maxlength="4">
        </div>
      </div>
      <div class="modal-field">
        <label>Description (optionnel)</label>
        <textarea name="description" rows="3" placeholder="Décrivez vos missions..."></textarea>
      </div>
      <div class="modal-actions">
        <button type="button" class="modal-cancel" onclick="closeModal('modal-experience')">Annuler</button>
        <button type="submit" class="modal-save"><i class="ti ti-check"></i> Enregistrer</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Formation --}}
<div class="modal-overlay" id="modal-formation">
  <div class="modal">
    <div class="modal-title"><i class="ti ti-school" style="color:var(--accent)"></i> Ajouter une formation</div>
    <form action="{{ route('candidat.formations.store') }}" method="POST">
      @csrf
      <div class="modal-field">
        <label>Diplôme / Titre *</label>
        <input type="text" name="diplome" placeholder="Ex: Master Informatique" required>
      </div>
      <div class="modal-field">
        <label>Établissement *</label>
        <input type="text" name="etablissement" placeholder="Ex: Université de Paris" required>
      </div>
      <div class="modal-row">
        <div class="modal-field">
          <label>Année début *</label>
          <input type="text" name="annee_debut" placeholder="2020" required maxlength="4">
        </div>
        <div class="modal-field">
          <label>Année fin</label>
          <input type="text" name="annee_fin" placeholder="2022 (vide = Présent)" maxlength="4">
        </div>
      </div>
      <div class="modal-field">
        <label>Description (optionnel)</label>
        <textarea name="description" rows="2" placeholder="Spécialisation, mention..."></textarea>
      </div>
      <div class="modal-actions">
        <button type="button" class="modal-cancel" onclick="closeModal('modal-formation')">Annuler</button>
        <button type="submit" class="modal-save"><i class="ti ti-check"></i> Enregistrer</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Avatar click handler for photo upload
  document.getElementById('avatar-click').addEventListener('click', function() {
    document.getElementById('photo-profil-input').click();
  });

  // Photo upload handler
  document.getElementById('photo-profil-input').addEventListener('change', function() {
    const photoError = document.getElementById('photo-error');
    if (photoError) photoError.style.display = 'none';

    if (this.files && this.files[0]) {
      const file = this.files[0];
      const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

      if (file.size > MAX_SIZE) {
        this.value = '';
        if (photoError) photoError.style.display = 'flex';
        return;
      }

      // Enable editing mode
      enableEditing();
      // Show a preview of the selected photo
      const reader = new FileReader();
      reader.onload = function(e) {
        const avatar = document.getElementById('avatar-click');
        avatar.classList.add('avatar-with-photo');
        avatar.style.backgroundImage = 'url(' + e.target.result + ')';
        avatar.style.backgroundSize = 'cover';
        avatar.style.backgroundPosition = 'center';
        avatar.textContent = '';
      };
      reader.readAsDataURL(file);
    }
  });

  function removeTag(el) {
    el.closest('.tag').remove();
    updateCompetencesInput();
  }

  function addTag() {
    const input = document.getElementById('skill-input');
    const val = input.value.trim();
    if (!val) return;
    const wrap = document.getElementById('tags-wrap');
    const tag = document.createElement('div');
    tag.className = 'tag';
    tag.innerHTML = val + ' <span class="tag-remove" onclick="removeTag(this)">×</span>';
    wrap.appendChild(tag);
    input.value = '';
    updateCompetencesInput();
  }

  function updateCompetencesInput() {
    const wrap = document.getElementById('tags-wrap');
    const tags = wrap.querySelectorAll('.tag');
    const competences = Array.from(tags).map(tag => tag.textContent.replace('×', '').trim()).join(', ');
    document.getElementById('competences-input').value = competences;
  }

  function uploadCv(input) {
    const cvError = document.getElementById('cv-error');
    if (cvError) cvError.style.display = 'none';

    if (input.files && input.files[0]) {
      const file = input.files[0];
      const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

      if (file.size > MAX_SIZE) {
        input.value = '';
        if (cvError) cvError.style.display = 'flex';
        return;
      }

      // Enable all fields for form submission
      document.querySelectorAll('.field-input').forEach(function(el) {
        el.disabled = false;
      });
      // Submit the form
      input.closest('form').submit();
    }
  }

  // Disable all fields on page load (view mode), except skill-input
  document.querySelectorAll('.field-input').forEach(function(el) {
    if (el.id !== 'skill-input') {
      el.disabled = true;
    }
  });

  // Initialize competences input on page load
  updateCompetencesInput();

  function enableEditing() {
    document.querySelectorAll('.field-input').forEach(function(el) {
      el.disabled = false;
    });
    document.getElementById('btn-modifier').style.display = 'none';
    document.getElementById('btn-enregistrer').style.display = 'inline-flex';
    // Focus on the first field
    var firstInput = document.querySelector('.field-input');
    if (firstInput) firstInput.focus();
  }

  document.getElementById('btn-enregistrer').addEventListener('click', function () {
    this.innerHTML = '<i class="ti ti-check"></i> Enregistré !';
    this.style.background = '#16a34a';
  });

  // Prevent profile form submission if photo or CV exceeds 5MB
  const profileForm = document.querySelector('form[action="' + "{{ route('candidat.profil.update') }}" + '"]');
  if (profileForm) {
    profileForm.addEventListener('submit', function(e) {
      const photoInput = document.getElementById('photo-profil-input');
      const photoError = document.getElementById('photo-error');
      const cvInput = document.getElementById('cv-upload');
      const cvError = document.getElementById('cv-error');
      const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

      let hasError = false;

      if (photoInput && photoInput.files && photoInput.files[0]) {
        if (photoInput.files[0].size > MAX_SIZE) {
          hasError = true;
          if (photoError) photoError.style.display = 'flex';
          photoInput.value = '';
        }
      }

      if (cvInput && cvInput.files && cvInput.files[0]) {
        if (cvInput.files[0].size > MAX_SIZE) {
          hasError = true;
          if (cvError) cvError.style.display = 'flex';
          cvInput.value = '';
        }
      }

      if (hasError) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      }
    });
  }

  function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeModal(id) {
    document.getElementById(id).classList.remove('open');
  }

  function deleteExperience(id) {
    if (confirm('Supprimer cette expérience ?')) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route('candidat.experiences.destroy', ':id') }}'.replace(':id', id);
      form.style.display = 'none';
      
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = '{{ csrf_token() }}';
      form.appendChild(csrfInput);
      
      const methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      methodInput.value = 'DELETE';
      form.appendChild(methodInput);
      
      document.body.appendChild(form);
      form.submit();
    }
  }

  function deleteFormation(id) {
    if (confirm('Supprimer cette formation ?')) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route('candidat.formations.destroy', ':id') }}'.replace(':id', id);
      form.style.display = 'none';
      
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = '{{ csrf_token() }}';
      form.appendChild(csrfInput);
      
      const methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      methodInput.value = 'DELETE';
      form.appendChild(methodInput);
      
      document.body.appendChild(form);
      form.submit();
    }
  }

  // Close modal on overlay click
  document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) closeModal(overlay.id);
    });
  });
  // Auto-open modal if validation errors for experience/formation
  @if($errors->has('poste') || $errors->has('entreprise'))
    openModal('modal-experience');
  @elseif($errors->has('diplome') || $errors->has('etablissement'))
    openModal('modal-formation');
  @endif
</script>
</body>
</html>
