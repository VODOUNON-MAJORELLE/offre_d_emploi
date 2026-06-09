<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil entreprise - {{ $entreprise->nom_entreprise ?? 'Talentlink' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,sans-serif;background:#f0f2f5;color:#1a1a2e}
.page{padding:24px;max-width:960px;margin:0 auto}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.topbar h1{font-size:22px;font-weight:600}
.btn-save{background:#6c63ff;color:#fff;border:none;border-radius:8px;padding:8px 18px;font-size:14px;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:6px}
.layout{display:grid;grid-template-columns:260px 1fr;gap:16px}
.card{background:#fff;border:0.5px solid #e0e0e0;border-radius:12px;padding:16px;margin-bottom:16px}
.logo-box{display:flex;flex-direction:column;align-items:center;margin-bottom:12px}
.logo-circle{width:72px;height:72px;background:#6c63ff;border-radius:16px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:24px;font-weight:600;cursor:pointer}
.logo-hint{font-size:11px;color:#999;margin-top:6px}
.company-name{font-size:16px;font-weight:600;border-bottom:0.5px solid #e0e0e0;padding-bottom:6px;margin-bottom:8px;width:100%}
.meta-row{display:flex;align-items:center;gap:6px;font-size:13px;color:#555;padding:4px 0;border-bottom:0.5px solid #f0f0f0}
.meta-row-edit{display:flex;align-items:center;gap:6px;font-size:13px;color:#555;padding:4px 0;border-bottom:0.5px solid #f0f0f0}
.meta-row i{font-size:15px;color:#aaa}
.section-title{font-size:14px;font-weight:600;margin-bottom:10px}
.tags{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px}
.tag{background:#f5f5f5;border:0.5px solid #e0e0e0;border-radius:20px;padding:3px 10px;font-size:12px;display:flex;align-items:center;gap:4px}
.tag-x{cursor:pointer;color:#aaa;font-size:11px}
.add-tag{display:flex;align-items:center;gap:6px}
.add-tag input{flex:1;border:0.5px solid #e0e0e0;border-radius:8px;padding:5px 10px;font-size:13px;background:#f9f9f9;color:#1a1a2e}
.add-tag button{width:28px;height:28px;background:#6c63ff;border:none;border-radius:8px;color:#fff;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1}
.stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.stat-box{background:#f5f5f5;border-radius:8px;padding:10px;text-align:center}
.stat-num{font-size:20px;font-weight:600;color:#6c63ff}
.stat-lbl{font-size:11px;color:#888;margin-top:2px}
.about-textarea{width:100%;height:80px;border:0.5px solid #e0e0e0;border-radius:8px;padding:8px;font-size:13px;resize:none;background:#f9f9f9;color:#1a1a2e}
.media-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px}
.media-title{font-size:16px;font-weight:600}
.btn-add-photo{background:#6c63ff;color:#fff;border:none;border-radius:8px;padding:6px 12px;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:4px}
.media-sub{font-size:12px;color:#aaa;margin-bottom:10px}
.filter-tabs{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
.ftab{border:0.5px solid #e0e0e0;border-radius:20px;padding:4px 12px;font-size:12px;cursor:pointer;background:#f5f5f5;color:#666}
.ftab.active{background:#6c63ff;color:#fff;border-color:#6c63ff}
.add-photo-form{border:0.5px solid #e0e0e0;border-radius:10px;padding:14px;margin-bottom:14px}
.form-label{font-size:11px;font-weight:600;color:#888;letter-spacing:.05em;margin-bottom:4px;text-transform:uppercase}
.form-input{width:100%;border:0.5px solid #e0e0e0;border-radius:8px;padding:7px 10px;font-size:13px;background:#f9f9f9;color:#1a1a2e;margin-bottom:10px}
.cat-tabs{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px}
.ctab{border:0.5px solid #e0e0e0;border-radius:20px;padding:4px 12px;font-size:12px;cursor:pointer;background:#f5f5f5;color:#666}
.ctab.active{background:#6c63ff;color:#fff;border-color:#6c63ff}
.upload-zone{border:1.5px dashed #ccc;border-radius:10px;height:80px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;cursor:pointer;margin-bottom:10px;color:#aaa}
.upload-zone i{font-size:22px}
.upload-zone span{font-size:12px}
.form-actions{display:flex;gap:10px;align-items:center}
.btn-submit{background:#6c63ff;color:#fff;border:none;border-radius:8px;padding:8px 20px;font-size:14px;cursor:pointer;font-weight:500}
.btn-cancel{background:none;border:none;font-size:14px;cursor:pointer;color:#888}
.photos-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:8px}
.photo-card{border-radius:10px;height:90px;display:flex;flex-direction:column;justify-content:flex-end;padding:8px;position:relative;overflow:hidden}
.photo-card .pc-bg{position:absolute;inset:0;border-radius:10px}
.photo-card .pc-content{position:relative;z-index:1}
.photo-card .pc-title{font-size:12px;font-weight:500;color:#fff}
.photo-card .pc-badge{display:inline-block;background:rgba(0,0,0,0.35);color:#fff;font-size:10px;padding:2px 7px;border-radius:10px;margin-top:2px}
.photo-add-card{border:1.5px dashed #ccc;border-radius:10px;height:90px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;cursor:pointer;color:#aaa}
.photo-add-card i{font-size:20px}
.photo-add-card span{font-size:12px}
.photos-total{font-size:12px;color:#aaa;text-align:right;margin-top:4px}
.offres-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.offres-title{font-size:16px;font-weight:600}
.btn-new-offre{background:none;border:none;color:#6c63ff;font-size:13px;cursor:pointer;display:flex;align-items:center;gap:4px}
.offre-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:0.5px solid #f0f0f0}
.offre-row:last-child{border-bottom:none}
.offre-name{font-size:14px;font-weight:500}
.offre-meta{font-size:12px;color:#aaa;margin-top:2px}
.offre-actions{display:flex;align-items:center;gap:8px}
.badge-cdi{background:#e8f4fd;color:#1a6fa8;border-radius:6px;padding:3px 8px;font-size:11px;font-weight:500}
.btn-voir{background:none;border:none;color:#6c63ff;font-size:13px;cursor:pointer}
.avis-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.avis-global{display:flex;align-items:center;gap:12px;margin-bottom:14px;padding:12px;background:#f9f9f9;border-radius:10px}
.avis-score-big{font-size:36px;font-weight:600;color:#6c63ff}
.avis-stars-big{display:flex;gap:3px;margin-bottom:4px}
.avis-stars-big i{font-size:22px;color:#f5a623}
.avis-count-lbl{font-size:12px;color:#aaa}
.repartition{flex:1}
.rep-row{display:flex;align-items:center;gap:6px;margin-bottom:4px}
.rep-stars{font-size:11px;color:#666;min-width:32px}
.rep-bar-bg{flex:1;height:6px;background:#e8e8e8;border-radius:3px;overflow:hidden}
.rep-bar{height:6px;background:#6c63ff;border-radius:3px}
.rep-n{font-size:11px;color:#aaa;min-width:18px;text-align:right}
.avis-item {
  padding: 18px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  margin-bottom: 16px;
  transition: all 0.2s ease;
}
.avis-item:hover {
  border-color: #cbd5e1;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
}
.avis-item:last-child {
  margin-bottom: 0;
}
.avis-text {
  font-size: 14px;
  color: #334155;
  line-height: 1.6;
  margin-bottom: 12px;
}
.avis-item-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}
.avis-author{display:flex;align-items:center;gap:10px}
.avis-avatar{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600}
.avis-name{font-size:14px;font-weight:600;color:#1a1a2e}
.avis-role{font-size:12px;color:#888;margin-top:2px}
.avis-stars{display:flex;gap:2px}
.avis-stars i{font-size:14px;color:#f5a623}
.avis-stars i.empty{color:#ddd}
.avis-date{font-size:12px;color:#999}
.avis-actions{display:flex;gap:8px;margin-top:12px;justify-content:flex-end}
.btn-edit-avis{background:#6c63ff;color:#fff;border:none;border-radius:6px;padding:8px 14px;font-size:12px;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:5px;transition:all .2s}
.btn-edit-avis:hover{background:#5a52d5;transform:translateY(-1px)}
.btn-delete-avis{background:#ef4444;color:#fff;border:none;border-radius:6px;padding:8px 14px;font-size:12px;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:5px;transition:all .2s}
.btn-delete-avis:hover{background:#dc2626;transform:translateY(-1px)}
.write-avis {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 24px;
  margin-top: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}
.write-avis:hover {
  box-shadow: 0 6px 24px rgba(108, 99, 255, 0.08);
  border-color: #cbd5e1;
}
.write-avis-title {
  font-size: 16px;
  font-weight: 700;
  color: #1a1a2e;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.write-avis-title i {
  color: #6c63ff;
  font-size: 20px;
}
.rating-label {
  font-size: 13px;
  font-weight: 600;
  color: #4b5563;
  margin-bottom: 8px;
}
.star-input {
  display: flex;
  gap: 8px;
  margin-bottom: 18px;
}
.star-input i {
  font-size: 28px;
  cursor: pointer;
  color: #e2e8f0;
  transition: transform 0.2s ease, color 0.2s ease, text-shadow 0.2s ease;
}
.star-input i:hover {
  transform: scale(1.2);
}
.star-input i.lit {
  color: #f5a623;
  text-shadow: 0 0 10px rgba(245, 166, 35, 0.3);
}
.avis-textarea {
  width: 100%;
  height: 110px;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  padding: 14px;
  font-size: 14px;
  line-height: 1.5;
  resize: none;
  background: #f8fafc;
  color: #1a1a2e;
  margin-bottom: 16px;
  transition: all 0.3s ease;
  font-family: inherit;
}
.avis-textarea:focus {
  outline: none;
  background: #ffffff;
  border-color: #6c63ff;
  box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.15);
}
.btn-submit-avis {
  background: linear-gradient(135deg, #6c63ff, #5b4be8);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 10px 24px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 4px 12px rgba(108, 99, 255, 0.2);
}
.btn-submit-avis:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(108, 99, 255, 0.3);
}
.btn-submit-avis:active {
  transform: translateY(1px);
}
.mode-toggle{display:flex;gap:8px;margin-bottom:16px}
.mode-btn{padding:5px 14px;border-radius:20px;border:0.5px solid #e0e0e0;font-size:12px;cursor:pointer;background:#f5f5f5;color:#666}
.mode-btn.active{background:#6c63ff;color:#fff;border-color:#6c63ff}
.view-mode-note{font-size:12px;color:#aaa;margin-bottom:10px;display:flex;align-items:center;gap:5px;background:#fff8e1;padding:8px 12px;border-radius:8px;color:#b07d00}

/* NAV CANDIDAT & ENTREPRISE */
nav.candidat-nav, nav.entreprise-nav{background:#fff;border-bottom:0.5px solid #e0e0e0;padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100; margin-bottom: 24px;}
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
.user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:#9ca3af;transition:color .12s}
.logout-btn:hover{color:#1a1a2e}

@media (max-width: 720px) {
  .layout { grid-template-columns: 1fr; }
  body { padding: 0 0 16px; }
  nav.candidat-nav, nav.entreprise-nav { padding: 0 16px; margin-bottom: 24px; }
}
</style>
</head>
<body>
@php
  $isCandidatMode = \Illuminate\Support\Facades\Auth::guard('candidat')->check();
  if($isCandidatMode) {
    $candidatInfo = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
  }
@endphp

@if($isCandidatMode)
<nav class="candidat-nav">
  <div class="nav-left">
    <a href="/" class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </a>
    <div class="nav-links">
      <a class="nav-link" href="/">Feed</a>
      <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $unreadNotifCount = \App\Models\Notification::where('id_entreprise', $entreprise->id_entreprise)->where('statut_lecture', 'non lu')->count();
      $candidatInitials = substr($candidatInfo->prenom, 0, 1) . substr($candidatInfo->nom, 0, 1);
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
      <div class="user-av">{{ $candidatInitials }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>
@else
<nav class="entreprise-nav">
  <div class="nav-left">
    <div class="nav-logo">
      <div class="logo-av">JR</div>
      <span>Talentlink</span>
    </div>
    <div class="nav-links">
      <a class="nav-link" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
      <a class="nav-link active" href="{{ route('entreprise.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
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
@endif

<div class="page">
  @php
    $routeName = request()->route() ? request()->route()->getName() : '';
    $isCandidatModeView = str_starts_with($routeName, 'candidat.') || str_starts_with($routeName, 'entreprises.show');
    
    $isEntreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->check() && !$isCandidatModeView;
    $isCandidat = \Illuminate\Support\Facades\Auth::guard('candidat')->check() || $isCandidatModeView;
    
    $initials = substr($entreprise->nom_entreprise ?? 'TV', 0, 2);
    $valeurs = array_filter(array_map('trim', explode(',', $entreprise->valeurs ?? '')));
    $offres = $entreprise->offres()->where('statut_offre', 'active')->get();
    $avis = $entreprise->avis()->with('candidat')->orderByDesc('date_avis')->get();
    $noteMoyenne = $entreprise->note_moyenne ?? 0;
    $nbOffres = $offres->count();
    $nbCandidatures = \App\Models\Candidature::whereIn('id_offre', $offres->pluck('id_offre'))->count();
    $nbEmbauches = 0; // Pas de colonne statut dans candidatures, à implémenter si nécessaire
  @endphp

  <div class="topbar">
    <h1>Profil entreprise</h1>
    @if($isEntreprise)
      <div style="display:flex;gap:8px;">
        <button type="button" id="btn-modifier-e" class="btn-save" style="background:#374151;" onclick="enableEditingE()"><i class="ti ti-edit"></i> Modifier</button>
        <button type="button" id="btn-enregistrer-e" class="btn-save" style="display:none;" onclick="document.getElementById('profil-form').submit()"><i class="ti ti-check"></i> Enregistrer</button>
      </div>
    @endif
  </div>

  <form id="profil-form" action="{{ route('entreprise.profil.update') }}" method="POST" enctype="multipart/form-data" style="display:none">
    @csrf
  </form>

  @if(session('success'))
    <div style="background:#d1fae5; border:0.5px solid #10b981; border-radius:12px; padding:12px 16px; margin-bottom:16px;">
      <div style="display:flex; align-items:center; gap:8px;">
        <span style="font-size:18px;">✅</span>
        <div style="font-size:13px; color:#065f46;">{{ session('success') }}</div>
      </div>
    </div>
  @endif

  <div class="layout">
    <!-- COLONNE GAUCHE -->
    <div>
      <div class="card">
        <div class="logo-box">
          @if($isEntreprise)
            <input type="file" id="logo-input" name="logo" accept="image/*" style="display:none" onchange="updateLogoPreview(this)" form="profil-form">
            <div class="logo-circle" id="logo-preview" onclick="document.getElementById('logo-input').click()" style="cursor:pointer">
              @if($entreprise->logo)
                <img src="{{ asset('storage/' . $entreprise->logo) }}" style="width:100%;height:100%;border-radius:16px;object-fit:cover">
              @else
                {{ $initials }}
              @endif
            </div>
            <span class="logo-hint">Cliquez sur le logo pour modifier</span>
          @else
            <div class="logo-circle">
              @if($entreprise->logo)
                <img src="{{ asset('storage/' . $entreprise->logo) }}" style="width:100%;height:100%;border-radius:16px;object-fit:cover">
              @else
                {{ $initials }}
              @endif
            </div>
          @endif
        </div>
        @if($isEntreprise)
          <input type="text" class="company-name-edit" id="edit-nom" name="nom_entreprise" value="{{ $entreprise->nom_entreprise }}" style="display:none;width:100%;border:0.5px solid #e0e0e0;border-radius:8px;padding:8px;font-size:16px;font-weight:600;margin-bottom:8px" form="profil-form">
        @endif
        <div class="company-name" id="display-nom">{{ $entreprise->nom_entreprise }}</div>
        @if($isEntreprise)
          <input type="text" id="edit-secteur" name="secteur_activite" value="{{ $entreprise->secteur_activite ?? '' }}" placeholder="Secteur d'activité" style="display:none;width:100%;border:0.5px solid #e0e0e0;border-radius:8px;padding:6px 10px;font-size:13px;margin-bottom:8px;background:#f9f9f9;color:#1a1a2e" form="profil-form">
        @endif
        <div style="font-size:13px;color:#aaa;margin-bottom:10px" id="display-secteur">{{ $entreprise->secteur_activite ?? 'Secteur d\'activité non spécifié' }}</div>
        @if($isEntreprise)
          <div class="meta-row-edit" id="edit-ville" style="display:none">
            <i class="ti ti-map-pin" style="font-size:15px;color:#aaa"></i>
            <input type="text" name="ville_entreprise" value="{{ $entreprise->ville_entreprise ?? '' }}" placeholder="Ville" style="flex:1;border:0.5px solid #e0e0e0;border-radius:8px;padding:4px 10px;font-size:13px;background:#f9f9f9;color:#1a1a2e" form="profil-form">
          </div>
        @endif
        <div class="meta-row"><i class="ti ti-map-pin"></i> {{ $entreprise->ville_entreprise ?? 'Ville non spécifiée' }}</div>
        @if($isEntreprise)
          <div class="meta-row-edit" id="edit-telephone" style="display:none">
            <i class="ti ti-phone" style="font-size:15px;color:#aaa"></i>
            <input type="text" name="telephone" value="{{ $entreprise->telephone ?? '' }}" placeholder="Téléphone" style="flex:1;border:0.5px solid #e0e0e0;border-radius:8px;padding:4px 10px;font-size:13px;background:#f9f9f9;color:#1a1a2e" form="profil-form">
          </div>
        @endif
        @if($entreprise->telephone)
          <div class="meta-row"><i class="ti ti-phone"></i> {{ $entreprise->telephone }}</div>
        @endif
      </div>

      <div class="card">
        <div class="section-title">Statistiques</div>
        <div class="stats-grid">
          <div class="stat-box"><div class="stat-num">{{ $nbOffres }}</div><div class="stat-lbl">Offres publiées</div></div>
          <div class="stat-box"><div class="stat-num">{{ $nbCandidatures }}</div><div class="stat-lbl">Candidatures</div></div>
          <div class="stat-box"><div class="stat-num">{{ $nbEmbauches }}</div><div class="stat-lbl">Embauches</div></div>
          <div class="stat-box"><div class="stat-num">{{ $noteMoyenne }}/5</div><div class="stat-lbl">Score employeur</div></div>
        </div>
      </div>
    </div>

    <!-- COLONNE DROITE -->
    <div>
      <div class="card">
        <div class="section-title" style="font-size:16px">À propos de {{ $entreprise->nom_entreprise }}</div>
        @if($isEntreprise)
          <textarea class="about-textarea" id="edit-description" name="description" placeholder="Décrivez votre entreprise..." form="profil-form">{{ $entreprise->description ?? '' }}</textarea>
        @else
          <div style="font-size:13px;color:#555;line-height:1.5">{{ $entreprise->description ?? 'Aucune description disponible.' }}</div>
        @endif
      </div>

      <!-- OFFRES PUBLIÉES -->
      <div class="card">
        <div class="offres-header">
          <div class="offres-title">Offres publiées</div>
          @if($isEntreprise)
            <a href="{{ route('entreprise.offres.create') }}" class="btn-new-offre"><i class="ti ti-plus"></i> Nouvelle offre</a>
          @endif
        </div>
        @if($offres->count() > 0)
          @foreach($offres as $offre)
            @php
              $nbCandidatsOffre = \App\Models\Candidature::where('id_offre', $offre->id_offre)->count();
            @endphp
            <div class="offre-row">
              <div><div class="offre-name">{{ $offre->titre_offre }}</div><div class="offre-meta">{{ $nbCandidatsOffre }} candidats · {{ $offre->date_publication ? $offre->date_publication->diffForHumans() : 'Récemment' }}</div></div>
              <div class="offre-actions"><span class="badge-cdi">{{ $offre->type_contrat ?? 'CDI' }}</span><a href="{{ route('entreprise.offres.detail', ['id_offre' => $offre->id_offre]) }}" class="btn-voir">Voir</a></div>
            </div>
          @endforeach
        @else
          <div style="text-align:center;padding:20px;color:#aaa;font-size:13px">Aucune offre publiée</div>
        @endif
      </div>

      <!-- SECTION AVIS -->
      <div class="card">
        <div class="avis-header">
          <div class="media-title"><i class="ti ti-star" style="font-size:15px;vertical-align:-2px;margin-right:4px"></i> Avis & notes</div>
        </div>

        @if($isCandidat)
          <!-- VUE CANDIDAT -->
          <div id="view-candidat">
            <div class="avis-global">
              <div style="text-align:center;min-width:80px">
                <div class="avis-score-big" id="score-display">{{ $noteMoyenne }}</div>
                <div class="avis-stars-big" id="stars-big"></div>
                <div class="avis-count-lbl" id="count-lbl">{{ $avis->count() }} avis</div>
              </div>
              <div class="repartition" id="repartition"></div>
            </div>

            @php
              $candidaturesPourAvis = \App\Models\Candidature::where('id_candidat', \Illuminate\Support\Facades\Auth::guard('candidat')->user()->id_candidat)
                  ->whereIn('id_offre', $offres->pluck('id_offre'))
                  ->with('progressions.etapeOffre')
                  ->get();
              
              // Check if candidate has passed interview stage
              $hasPassedInterview = false;
              foreach($candidaturesPourAvis as $candidature) {
                  if ($candidature->progressions->contains(function($progression) {
                      return str_contains(strtolower($progression->etapeOffre->nom_etape ?? ''), 'entretien') 
                          && $progression->statut_etape === 'complétée';
                  })) {
                      $hasPassedInterview = true;
                      break;
                  }
              }
              
              // Check if candidate has already left an avis for this company
              $hasExistingAvis = \App\Models\Avis::where('id_candidat', \Illuminate\Support\Facades\Auth::guard('candidat')->user()->id_candidat)
                  ->where('id_entreprise', $entreprise->id_entreprise)
                  ->exists();
            @endphp
            
            <div id="avis-list"></div>

            @if($hasPassedInterview || $hasExistingAvis)
              <div class="write-avis">
                <form action="{{ route('candidat.avis.store', ['id_entreprise' => $entreprise->id_entreprise]) }}" method="POST" id="form-avis" onsubmit="return validateAvisForm()">
                  @csrf
                  <input type="hidden" name="note_clarte_offre" id="note_clarte_offre" value="0">
                  <input type="hidden" name="note_qualite_retours" id="note_qualite_retours" value="0">
                  <input type="hidden" name="note_respect_processus" id="note_respect_processus" value="0">
                  <input type="hidden" name="note_professionnalisme" id="note_professionnalisme" value="0">
                  <div class="write-avis-title"><i class="ti ti-message-2"></i> Laisser un avis</div>
                  
                  @if($errors->any())
                    <div style="background:#fee2e2;color:#b91c1c;padding:12px;border-radius:10px;font-size:13px;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                      <i class="ti ti-alert-circle"></i>
                      <span>{{ $errors->first() }}</span>
                    </div>
                  @endif
                  
                  <div class="rating-label">Votre évaluation globale</div>
                  <div class="star-input" id="star-input">
                    <i class="ti ti-star" data-val="1"></i>
                    <i class="ti ti-star" data-val="2"></i>
                    <i class="ti ti-star" data-val="3"></i>
                    <i class="ti ti-star" data-val="4"></i>
                    <i class="ti ti-star" data-val="5"></i>
                  </div>
                  <textarea class="avis-textarea" name="commentaire" id="avis-text" placeholder="Partagez votre expérience avec cette entreprise..." required></textarea>
                  <button type="submit" class="btn-submit-avis"><i class="ti ti-send"></i> Publier mon avis</button>
                </form>
              </div>
            @else
              <div style="background:#e0f2fe;color:#0284c7;padding:12px 16px;border-radius:12px;font-size:13px;margin-top:20px;text-align:center;display:flex;align-items:center;justify-content:center;gap:8px;border:0.5px solid #b3e0ff;">
                <i class="ti ti-info-circle" style="font-size:16px;"></i> Vous devez avoir passé le stade entretien pour laisser un avis.
              </div>
            @endif
          </div>
        @else
          <!-- VUE ENTREPRISE -->
          <div id="view-entreprise">
            <div class="avis-global">
              <div style="text-align:center;min-width:80px">
                <div class="avis-score-big" id="score-display-e">{{ $noteMoyenne }}</div>
                <div class="avis-stars-big" id="stars-big-e"></div>
                <div class="avis-count-lbl" id="count-lbl-e">{{ $avis->count() }} avis</div>
              </div>
              <div class="repartition" id="repartition-e"></div>
            </div>
            <div id="avis-list-e"></div>
          </div>
        @endif
      </div>

    </div>
  </div>
</div>

<script>
@php
  $avisData = [];
  $currentCandidatId = $isCandidatMode ? $candidatInfo->id_candidat : null;
  foreach($avis as $a) {
    $candidat = $a->candidat;
    $isAuthor = $isCandidatMode && $candidat->id_candidat === $currentCandidatId;
    $avisData[] = [
      'id' => $a->id_avis,
      'name' => ($candidat->prenom ?? '') . ' ' . ($candidat->nom ?? ''),
      'role' => $candidat->niveau_etudes ?? 'Candidat',
      'rating' => $a->note_globale ?? 5,
      'text' => $a->commentaire ?? '',
      'date' => $a->date_avis ? $a->date_avis->diffForHumans() : 'Récemment',
      'color' => '#6c63ff',
      'initials' => substr($candidat->prenom ?? '', 0, 1) . substr($candidat->nom ?? '', 0, 1),
      'isAuthor' => $isAuthor,
      'entrepriseId' => $entreprise->id_entreprise
    ];
  }
@endphp
var avisData = @json($avisData);
var selectedRating = 0;

function renderStars(rating, containerId) {
  var c = document.getElementById(containerId);
  c.innerHTML = "";
  for (var i = 1; i <= 5; i++) {
    var el = document.createElement("i");
    el.className = "ti " + (i <= Math.floor(rating) ? "ti-star-filled" : (i - 0.5 <= rating ? "ti-star-half-filled" : "ti-star"));
    c.appendChild(el);
  }
}

function renderRepartition(data, cid) {
  var counts = [0,0,0,0,0];
  data.forEach(function(a){ if(a.rating>=1&&a.rating<=5) counts[a.rating-1]++; });
  var max = Math.max.apply(null, counts) || 1;
  var c = document.getElementById(cid);
  if (!c) return;
  c.innerHTML = "";
  for (var s = 5; s >= 1; s--) {
    var n = counts[s-1];
    var pct = Math.round(n / max * 100);
    c.innerHTML += '<div class="rep-row"><span class="rep-stars">'+s+' ★</span><div class="rep-bar-bg"><div class="rep-bar" style="width:'+pct+'%"></div></div><span class="rep-n">'+n+'</span></div>';
  }
}

function renderAvisList(data, containerId) {
  var c = document.getElementById(containerId);
  if (!c) return;
  c.innerHTML = "";
  data.forEach(function(a) {
    var div = document.createElement("div");
    div.className = "avis-item";
    var stars = "";
    for (var i = 1; i <= 5; i++) stars += '<i class="ti ' + (i <= a.rating ? "ti-star-filled" : "ti-star empty") + '"></i>';
    
    var actionButtons = "";
    if (a.isAuthor) {
      actionButtons = '<div class="avis-actions">' +
        '<button onclick="editAvis(' + a.id + ', ' + a.entrepriseId + ')" class="btn-edit-avis"><i class="ti ti-edit"></i> Modifier</button>' +
        '<button onclick="deleteAvis(' + a.id + ', ' + a.entrepriseId + ')" class="btn-delete-avis"><i class="ti ti-trash"></i> Supprimer</button>' +
        '</div>';
    }
    
    div.innerHTML = '<div class="avis-item-top"><div class="avis-author"><div class="avis-avatar" style="background:'+a.color+'22;color:'+a.color+'">'+a.initials+'</div><div><div class="avis-name">'+a.name+'</div><div class="avis-role">'+a.role+'</div></div></div><div style="text-align:right"><div class="avis-stars">'+stars+'</div><div class="avis-date">'+a.date+'</div></div></div><div class="avis-text">'+a.text+'</div>' + actionButtons;
    c.appendChild(div);
  });
}

function updateScore(data, scoreId, starsId, countId) {
  var scoreEl = document.getElementById(scoreId);
  if (!scoreEl) return;
  var total = data.length;
  var sum = data.reduce(function(a,b){ return a + b.rating; }, 0);
  var avg = total ? Math.round(sum / total * 10) / 10 : 0;
  scoreEl.textContent = avg.toFixed(1);
  renderStars(avg, starsId);
  document.getElementById(countId).textContent = total + " avis";
}

function refreshAll() {
  renderAvisList(avisData, "avis-list");
  renderAvisList(avisData, "avis-list-e");
  updateScore(avisData, "score-display", "stars-big", "count-lbl");
  updateScore(avisData, "score-display-e", "stars-big-e", "count-lbl-e");
  renderRepartition(avisData, "repartition");
  renderRepartition(avisData, "repartition-e");
}

refreshAll();

var starEls = document.querySelectorAll("#star-input i");
starEls.forEach(function(el) {
  el.addEventListener("mouseover", function() {
    var v = parseInt(el.getAttribute("data-val"));
    starEls.forEach(function(s, idx) { s.className = "ti " + (idx < v ? "ti-star-filled lit" : "ti-star"); });
  });
  el.addEventListener("mouseout", function() {
    starEls.forEach(function(s, idx) { s.className = "ti " + (idx < selectedRating ? "ti-star-filled lit" : "ti-star"); });
  });
  el.addEventListener("click", function() {
    selectedRating = parseInt(el.getAttribute("data-val"));
    starEls.forEach(function(s, idx) { s.className = "ti " + (idx < selectedRating ? "ti-star-filled lit" : "ti-star"); });
  });
});

function validateAvisForm() {
  if (!selectedRating) { 
    alert("Veuillez sélectionner une note."); 
    return false; 
  }
  
  // Remplir les champs cachés avec la note globale choisie
  document.getElementById("note_clarte_offre").value = selectedRating;
  document.getElementById("note_qualite_retours").value = selectedRating;
  document.getElementById("note_respect_processus").value = selectedRating;
  document.getElementById("note_professionnalisme").value = selectedRating;
  
  return true;
}

function editAvis(avisId, entrepriseId) {
  console.log('editAvis called with avisId:', avisId, 'entrepriseId:', entrepriseId);
  
  // Find the avis in the data
  var avis = avisData.find(function(a) { return a.id === avisId; });
  if (!avis) {
    console.error('Avis not found with id:', avisId);
    alert('Avis non trouvé');
    return;
  }
  
  console.log('Found avis:', avis);
  
  // Populate the form with existing data
  selectedRating = avis.rating;
  var starEls = document.querySelectorAll("#star-input i");
  if (starEls.length === 0) {
    console.error('Star input elements not found');
    alert('Formulaire non disponible');
    return;
  }
  
  starEls.forEach(function(s, idx) { s.className = "ti " + (idx < selectedRating ? "ti-star-filled lit" : "ti-star"); });
  
  var avisText = document.getElementById("avis-text");
  if (!avisText) {
    console.error('avis-text element not found');
    alert('Formulaire non disponible');
    return;
  }
  
  avisText.value = avis.text;
  
  // Change form to edit mode
  var form = document.getElementById("form-avis");
  if (!form) {
    console.error('form-avis element not found');
    alert('Formulaire non disponible');
    return;
  }
  
  form.action = "{{ route('candidat.avis.update', ['id_avis' => ':avisId']) }}".replace(':avisId', avisId);
  form.style.display = 'block';
  var submitBtn = form.querySelector('button[type="submit"]');
  if (submitBtn) {
    submitBtn.innerHTML = '<i class="ti ti-check"></i> Mettre à jour mon avis';
  }
  
  // Scroll to form
  form.scrollIntoView({ behavior: 'smooth', block: 'center' });
  console.log('Form updated and scrolled to');
}

function deleteAvis(avisId, entrepriseId) {
  if (!confirm("Êtes-vous sûr de vouloir supprimer cet avis ?")) return;
  
  // Create form for deletion
  var form = document.createElement("form");
  form.method = "POST";
  form.action = "{{ route('candidat.avis.destroy', ['id_avis' => ':avisId']) }}".replace(':avisId', avisId);
  
  var csrfInput = document.createElement("input");
  csrfInput.type = "hidden";
  csrfInput.name = "_token";
  csrfInput.value = document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}";
  form.appendChild(csrfInput);
  
  var methodInput = document.createElement("input");
  methodInput.type = "hidden";
  methodInput.name = "_method";
  methodInput.value = "DELETE";
  form.appendChild(methodInput);
  
  document.body.appendChild(form);
  form.submit();
}

function setMode(mode) {
  document.getElementById("view-candidat").style.display = mode === "candidat" ? "" : "none";
  document.getElementById("view-entreprise").style.display = mode === "entreprise" ? "" : "none";
  document.getElementById("btn-candidat").className = "mode-btn" + (mode === "candidat" ? " active" : "");
  document.getElementById("btn-entreprise").className = "mode-btn" + (mode === "entreprise" ? " active" : "");
}

document.querySelectorAll(".ftab").forEach(function(t) {
  t.addEventListener("click", function() {
    document.querySelectorAll(".ftab").forEach(function(x){ x.classList.remove("active"); });
    t.classList.add("active");
  });
});
document.querySelectorAll(".ctab").forEach(function(t) {
  t.addEventListener("click", function() {
    document.querySelectorAll(".ctab").forEach(function(x){ x.classList.remove("active"); });
    t.classList.add("active");
  });
});

// View mode: disable textarea on load
var aboutTextarea = document.querySelector('.about-textarea');
if (aboutTextarea) aboutTextarea.disabled = true;

function enableEditingE() {
  // Show editable fields
  document.getElementById('edit-nom').style.display = 'block';
  document.getElementById('display-nom').style.display = 'none';
  document.getElementById('edit-secteur').style.display = 'block';
  document.getElementById('display-secteur').style.display = 'none';
  document.getElementById('edit-ville').style.display = 'flex';
  document.getElementById('edit-telephone').style.display = 'flex';
  
  // Enable the textarea
  if (aboutTextarea) {
    aboutTextarea.disabled = false;
    aboutTextarea.focus();
  }
  // Toggle buttons
  document.getElementById('btn-modifier-e').style.display = 'none';
  document.getElementById('btn-enregistrer-e').style.display = 'flex';
}

function updateLogoPreview(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var preview = document.getElementById('logo-preview');
      preview.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;border-radius:16px;object-fit:cover">';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
</body>
</html>
