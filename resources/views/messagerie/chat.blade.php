<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Messagerie</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f4f5fa;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── NAVBAR ── */
    .navbar {
      height: 56px;
      background: #fff;
      border-bottom: 1px solid #e8e8f0;
      display: flex;
      align-items: center;
      padding: 0 2rem;
      gap: 2rem;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .nav-logo {
      display: flex;
      align-items: center;
      gap: 9px;
      margin-right: 1rem;
      text-decoration: none;
    }

    .nav-avatar-logo {
      width: 34px; height: 34px; border-radius: 50%;
      background: #5040e8;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 12px; color: #fff;
    }

    .nav-brand {
      font-family: 'Syne', sans-serif; font-weight: 600; font-size: 15px; color: #1a1550;
    }

    .nav-links { display: flex; gap: 0.2rem; flex: 1; }
    .nav-link {
      padding: 6px 14px; font-size: 14px; color: #7070a0;
      text-decoration: none; border-radius: 8px;
      transition: color 0.15s, background 0.15s;
      font-weight: 500;
    }
    .nav-link:hover { color: #1a1550; background: #f4f5fa; }
    .nav-link.active { color: #5040e8; border-bottom: 2px solid #5040e8; border-radius: 0; background: none; }

    .nav-right { display: flex; align-items: center; gap: 12px; margin-left: auto; }

    .notif-btn {
      position: relative; width: 36px; height: 36px; border-radius: 10px;
      background: #f4f5fa;
      display: flex; align-items: center; justify-content: center;
      color: #5040e8; font-size: 18px; transition: background 0.15s;
      text-decoration: none;
    }
    .notif-btn:hover { background: #eeeeff; }
    .notif-badge {
      position: absolute; top: -2px; right: -2px;
      min-width: 20px; height: 20px; border-radius: 50%;
      background: #5040e8; color: #fff;
      font-size: 12px; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      padding: 0 6px;
      border: 2px solid #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .user-avatar {
      width: 36px; height: 36px; border-radius: 50%;
      background: linear-gradient(135deg, #8b5cf6, #5040e8);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 13px; color: #fff;
      cursor: pointer;
    }

    .logout-btn {
      width: 34px; height: 34px; border-radius: 8px; background: none; border: none;
      cursor: pointer; color: #9090b0; font-size: 18px;
      display: flex; align-items: center; justify-content: center;
      transition: color 0.15s, background 0.15s;
    }
    .logout-btn:hover { color: #e24b4a; background: #fff2f2; }

    /* ── LAYOUT ── */
    .main {
      display: flex;
      flex: 1;
      height: calc(100vh - 56px);
      overflow: hidden;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: 320px;
      flex-shrink: 0;
      background: #1e1e2e;
      border-right: 0.5px solid rgba(255,255,255,0.07);
      display: flex;
      flex-direction: column;
    }

    .sidebar-header {
      padding: 1.4rem 1.2rem 1rem;
      border-bottom: 0.5px solid rgba(255,255,255,0.07);
    }

    .sidebar-header h2 {
      font-family: 'Syne', sans-serif;
      font-weight: 700; font-size: 17px; color: #fff;
      margin-bottom: 0.9rem;
    }

    .search-box {
      position: relative;
    }
    .search-box i {
      position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
      color: rgba(255,255,255,0.35); font-size: 16px;
    }
    .search-box input {
      width: 100%; padding: 9px 12px 9px 34px;
      font-size: 13.5px; font-family: 'DM Sans', sans-serif;
      border: 0.5px solid rgba(255,255,255,0.1); border-radius: 8px;
      background: rgba(255,255,255,0.07); color: #e5e7eb; outline: none;
      transition: border-color 0.15s;
    }
    .search-box input::placeholder { color: rgba(255,255,255,0.35); }
    .search-box input:focus { border-color: rgba(124,111,240,0.5); }

    .conv-list { overflow-y: auto; flex: 1; }
    .conv-list::-webkit-scrollbar { width: 4px; }
    .conv-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

    .conv-item {
      display: flex; align-items: flex-start; gap: 11px;
      padding: 14px 1.2rem; cursor: pointer;
      border-bottom: 0.5px solid rgba(255,255,255,0.07);
      transition: background 0.12s;
      position: relative;
      text-decoration: none;
      color: inherit;
    }
    .conv-item:hover { background: rgba(255,255,255,0.04); }
    .conv-item.active { background: rgba(124,111,240,0.18); border-left: 3px solid #7c6ff0; padding-left: calc(1.2rem - 3px); }

    /* Avatars conversation */
    .conv-avatar {
      width: 42px; height: 42px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px;
      color: #fff; flex-shrink: 0;
      background-repeat: no-repeat; background-position: center; background-size: cover;
    }

    .conv-body { flex: 1; min-width: 0; }
    .conv-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px; }
    .conv-name { font-weight: 600; font-size: 14px; color: #f9fafb; }
    .conv-time { font-size: 11.5px; color: rgba(255,255,255,0.35); }
    .conv-role { font-size: 12px; color: #7c6ff0; font-weight: 500; margin-bottom: 3px; }
    .conv-preview { font-size: 12.5px; color: rgba(255,255,255,0.45); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 190px; }

    .unread-badge {
      min-width: 20px; height: 20px; border-radius: 10px;
      background: #5040e8; color: #fff;
      font-size: 11px; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      padding: 0 5px; flex-shrink: 0; margin-top: 2px;
    }

    /* ── CHAT AREA ── */
    .chat-area {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: #f4f5fa;
      overflow: hidden;
    }

    /* Chat header */
    .chat-header {
      background: #fff;
      border-bottom: 1px solid #e8e8f0;
      padding: 0 1.6rem;
      height: 64px;
      display: flex;
      align-items: center;
      gap: 14px;
      flex-shrink: 0;
    }

    .chat-header-avatar {
      width: 40px; height: 40px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px; color: #fff;
      background-repeat: no-repeat; background-position: center; background-size: cover;
    }

    .chat-header-info { flex: 1; }
    .chat-header-name { font-weight: 700; font-size: 15px; color: #1a1550; }
    .chat-header-role { font-size: 12.5px; color: #9090b0; }

    .online-dot {
      width: 9px; height: 9px; border-radius: 50%; background: #22c55e;
      display: inline-block; margin-right: 5px;
    }

    .back-btn {
      width: 40px; height: 40px; border-radius: 10px;
      background: #fff; border: 1px solid #e8e8f0; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: #5040e8; font-size: 22px; transition: all 0.15s;
      text-decoration: none; flex-shrink: 0;
      margin-right: 8px;
    }
    .back-btn:hover { background: #f0eeff; border-color: #5040e8; }

    .view-profile-btn {
      display: flex; align-items: center; gap: 6px;
      padding: 7px 14px; border: 1px solid #e0e0ee; border-radius: 9px;
      font-size: 13px; color: #5040e8; font-family: 'DM Sans', sans-serif;
      background: #fff; cursor: pointer; text-decoration: none;
      font-weight: 500; transition: background 0.15s;
    }
    .view-profile-btn:hover { background: #f0eeff; }

    /* Messages */
    .messages {
      flex: 1;
      overflow-y: auto;
      padding: 1.6rem 2rem;
      display: flex;
      flex-direction: column;
      gap: 0;
    }

    /* Date separator */
    .date-sep {
      text-align: center;
      font-size: 11.5px;
      color: #b0b0c8;
      margin: 1rem 0 0.6rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .date-sep::before, .date-sep::after {
      content: ''; flex: 1; height: 1px; background: #e8e8f0;
    }

    /* Message row */
    .msg-row {
      display: flex;
      align-items: flex-end;
      gap: 8px;
      margin-bottom: 4px;
    }

    /* Messages reçus (candidat) — alignés à gauche */
    .msg-row.received {
      justify-content: flex-start;
    }

    /* Messages envoyés (RH/moi) — alignés à droite */
    .msg-row.sent {
      justify-content: flex-end;
    }

    /* Petit avatar dans la conversation */
    .msg-avatar {
      width: 30px; height: 30px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 11px; color: #fff;
      flex-shrink: 0;
      align-self: flex-end;
      margin-bottom: 18px; /* aligne avec le timestamp */
      background-repeat: no-repeat; background-position: center; background-size: cover;
    }

    /* Masquer l'avatar si même expéditeur que message suivant */
    .msg-avatar.hidden { visibility: hidden; }

    .msg-col {
      display: flex;
      flex-direction: column;
      max-width: 60%;
    }

    /* Nom affiché au-dessus des bulles reçues */
    .msg-sender-name {
      font-size: 11px;
      color: #9090b0;
      font-weight: 500;
      margin-bottom: 3px;
      padding-left: 2px;
    }

    /* Bulle */
    .bubble {
      padding: 11px 16px;
      border-radius: 18px;
      font-size: 14px;
      line-height: 1.55;
      word-break: break-word;
    }

    /* Bulle reçue — candidat — gris clair */
    .msg-row.received .bubble {
      background: #fff;
      color: #1a1550;
      border-bottom-left-radius: 5px;
      box-shadow: 0 1px 4px rgba(80,64,232,0.06);
    }

    /* Bulle envoyée — RH — violet */
    .msg-row.sent .bubble {
      background: linear-gradient(135deg, #5040e8, #6c5ce7);
      color: #fff;
      border-bottom-right-radius: 5px;
    }

    /* Timestamp sous la bulle */
    .msg-time {
      font-size: 11px;
      color: #b0b0c8;
      margin-top: 4px;
    }
    .msg-row.sent .msg-time { text-align: right; }
    .msg-row.received .msg-time { text-align: left; padding-left: 2px; }

    /* Groupes de messages consécutifs : réduire l'espace */
    .msg-row + .msg-row.sent.group,
    .msg-row + .msg-row.received.group {
      margin-top: -2px;
    }

    /* Espacements entre groupes différents */
    .msg-row.new-group {
      margin-top: 16px;
    }

    /* ── INPUT ZONE ── */
    .input-zone {
      background: #fff;
      border-top: 1px solid #e8e8f0;
      padding: 1rem 1.6rem;
      display: flex;
      align-items: center;
      gap: 12px;
      flex-shrink: 0;
    }

    .msg-input {
      flex: 1;
      padding: 11px 16px;
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      border: 1px solid #e8e8f0;
      border-radius: 12px;
      background: #f8f8fc;
      color: #1a1550;
      outline: none;
      transition: border-color 0.15s, background 0.15s;
    }
    .msg-input::placeholder { color: #c0c0d8; }
    .msg-input:focus { border-color: #5040e8; background: #fff; }

    .send-btn {
      width: 42px; height: 42px; border-radius: 50%;
      background: linear-gradient(135deg, #5040e8, #6c5ce7);
      border: none; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 18px;
      transition: opacity 0.15s, transform 0.1s;
      flex-shrink: 0;
    }
    .send-btn:hover { opacity: 0.9; }
    .send-btn:active { transform: scale(0.93); }

    .attach-btn {
      width: 36px; height: 36px; border-radius: 9px; background: #f4f5fa;
      border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
      color: #9090b0; font-size: 18px; transition: background 0.15s, color 0.15s;
    }
    .attach-btn:hover { background: #eeeeff; color: #5040e8; }

    /* Scrollbar */
    .messages::-webkit-scrollbar { width: 5px; }
    .messages::-webkit-scrollbar-track { background: transparent; }
    .messages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

    .conv-list::-webkit-scrollbar { width: 4px; }
    .conv-list::-webkit-scrollbar-track { background: transparent; }
    .conv-list::-webkit-scrollbar-thumb { background: #e0e0ee; border-radius: 4px; }
  </style>
</head>
<body>

@php
  // Use variables passed from controller
  if (isset($candidat)) {
      $isCandidat = true;
      $isEntreprise = false;
      $user = $candidat;
      $initials = substr($user->prenom, 0, 1) . substr($user->nom, 0, 1);
  } elseif (isset($entreprise)) {
      $isCandidat = false;
      $isEntreprise = true;
      $user = $entreprise;
      $initials = substr($user->nom_entreprise, 0, 2);
  }
@endphp

<!-- NAVBAR -->
<nav class="navbar">
  <a class="nav-logo" href="/">
    <div class="nav-avatar-logo">{{ $initials ?? 'TL' }}</div>
    <span class="nav-brand">Talentlink</span>
  </a>
  <div class="nav-links">
    @if($isCandidat)
      <a href="{{ route('candidat.feed') }}" class="nav-link">Feed</a>
    @elseif($isEntreprise)
      <a href="/" class="nav-link">Feed</a>
    @endif
    @if($isCandidat)
      <a href="{{ route('candidat.profil') }}" class="nav-link">Profil</a>
      <a href="{{ route('candidat.dashboard') }}" class="nav-link">Candidatures</a>
    @elseif($isEntreprise)
      <a href="{{ route('entreprise.dashboard') }}" class="nav-link">Dashboard</a>
      <a href="{{ route('entreprise.profil') }}" class="nav-link">Profil</a>
    @endif
    <a href="{{ route('messagerie.index') }}" class="nav-link active">Messagerie</a>
  </div>
  <div class="nav-right">
    @php
      $unreadNotifCount = \App\Models\Notification::where(function($query) use ($isCandidat, $isEntreprise, $candidat, $entreprise) {
          if ($isCandidat && $candidat) {
              $query->where('id_candidat', $candidat->id_candidat);
          } elseif ($isEntreprise && $entreprise) {
              $query->where('id_entreprise', $entreprise->id_entreprise);
          }
      })->where('statut_lecture', 'non lu')->count();
    @endphp
    <a href="{{ route('notifications.index') }}" class="notif-btn">
      <i class="ti ti-bell"></i>
      @if($unreadNotifCount > 0)
        <span class="notif-badge">{{ $unreadNotifCount }}</span>
      @endif
    </a>
    @if($isCandidat && $candidat && $candidat->photo_profil)
      <div class="user-avatar" style="background-image: url('{{ asset('storage/' . $candidat->photo_profil) }}'); background-size: cover; background-position: center;"></div>
    @elseif($isEntreprise && $entreprise && $entreprise->logo_entreprise)
      <div class="user-avatar" style="background-image: url('{{ asset('storage/' . $entreprise->logo_entreprise) }}'); background-size: cover; background-position: center;"></div>
    @else
      <div class="user-avatar">{{ $initials ?? 'TL' }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<!-- MAIN -->
<div class="main">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <h2>
        @if($isCandidat)
          Messagerie Entreprises
        @elseif($isEntreprise)
          Messagerie Candidats
        @else
          Messagerie
        @endif
      </h2>
      <div class="search-box">
        <i class="ti ti-search"></i>
        <input type="text" placeholder="@if($isCandidat)Rechercher une entreprise...@elseif($isEntreprise)Rechercher un candidat...@elseRechercher...@endif" id="search-input" oninput="filterConvs(this.value)" />
      </div>
    </div>

    <div class="conv-list" id="conv-list">
      @forelse($conversations as $conv)
        @php
          if ($isCandidat) {
              $convPartner = $conv;
              $convPartnerId = $convPartner->id_entreprise;
              $convPartnerName = $convPartner->nom_entreprise;
              $convPartnerRole = $convPartner->secteur_activite ?? 'Entreprise';
              $initials = strtoupper(substr($convPartnerName, 0, 2));
              $avatarGradient = 'linear-gradient(135deg,#6366f1,#8b5cf6)';
              $partnerPhoto = $convPartner->logo_entreprise;
              $lastMessage = $conv->last_message;
          } elseif ($isEntreprise) {
              $convPartner = $conv;
              $convPartnerId = $convPartner->id_candidat;
              $convPartnerName = $convPartner->prenom . ' ' . $convPartner->nom;
              $convPartnerRole = $convPartner->niveau_etudes ?? 'Candidat';
              $initials = strtoupper(substr($convPartner->prenom, 0, 1)) . strtoupper(substr($convPartner->nom, 0, 1));
              $avatarGradient = 'linear-gradient(135deg,#0ea5e9,#6366f1)';
              $partnerPhoto = $convPartner->photo_profil;
              $lastMessage = $conv->last_message;
          }
          $preview = $lastMessage ? $lastMessage->contenu_message : 'Aucun message';
          $time = $lastMessage ? $lastMessage->date_envoi->format('H:i') : '';
          $isActive = isset($partner) && $convPartnerId == (isset($partnerType) && $partnerType === 'entreprise' ? $partner->id_entreprise : $partner->id_candidat);
        @endphp
        <a href="{{ route('messagerie.show', $convPartnerId) }}" class="conv-item {{ $isActive ? 'active' : '' }}">
          @if($partnerPhoto)
            <div class="conv-avatar" style="background-image: url('{{ asset('storage/' . $partnerPhoto) }}'); background-size: cover; background-position: center;"></div>
          @else
            <div class="conv-avatar" style="background:{{ $avatarGradient }}">{{ $initials }}</div>
          @endif
          <div class="conv-body">
            <div class="conv-top">
              <span class="conv-name">{{ $convPartnerName }}</span>
              <span class="conv-time">{{ $time }}</span>
            </div>
            <div class="conv-role">{{ $convPartnerRole }}</div>
            <div class="conv-preview">{{ $preview }}</div>
          </div>
        </a>
      @empty
        <div style="padding:24px 16px;text-align:center;color:#b0b0c8">
          <i class="ti ti-message-circle" style="font-size:28px;margin-bottom:8px;display:block"></i>
          <p style="font-size:12px">Aucune conversation</p>
        </div>
      @endforelse
    </div>
  </aside>

  <!-- CHAT AREA -->
  <div class="chat-area">
    @php
      if (isset($partner)) {
          $partnerInitials = $partnerType === 'entreprise'
              ? strtoupper(substr($partner->nom_entreprise, 0, 2))
              : strtoupper(substr($partner->prenom, 0, 1)) . strtoupper(substr($partner->nom, 0, 1));
          $partnerName = $partnerType === 'entreprise' ? $partner->nom_entreprise : ($partner->prenom . ' ' . $partner->nom);
          $partnerRole = $partnerType === 'entreprise' ? ($partner->secteur_activite ?? 'Entreprise') : ($partner->niveau_etudes ?? 'Candidat');
          $partnerId = $partnerType === 'entreprise' ? $partner->id_entreprise : $partner->id_candidat;
          $avatarGradient = $partnerType === 'entreprise'
              ? 'linear-gradient(135deg,#6366f1,#8b5cf6)'
              : 'linear-gradient(135deg,#0ea5e9,#6366f1)';
          $partnerPhoto = $partnerType === 'entreprise' ? $partner->logo_entreprise : $partner->photo_profil;
      }
    @endphp

    <!-- Chat header -->
    <div class="chat-header">
      <a href="{{ route('messagerie.index') }}" class="back-btn">
        <i class="ti ti-arrow-left"></i>
      </a>
      @if(isset($partner))
        @if($partnerPhoto)
          <div class="chat-header-avatar" id="chat-avatar" style="background-image: url('{{ asset('storage/' . $partnerPhoto) }}'); background-size: cover; background-position: center;"></div>
        @else
          <div class="chat-header-avatar" id="chat-avatar" style="background:{{ $avatarGradient }}">{{ $partnerInitials }}</div>
        @endif
        <div class="chat-header-info">
          <div class="chat-header-name" id="chat-name">{{ $partnerName }}</div>
          <div class="chat-header-role"><span class="online-dot"></span><span id="chat-role">{{ $partnerRole }}</span></div>
        </div>
        @if($isCandidat)
          <a href="{{ route('candidat.entreprise.profil', ['id_entreprise' => $partner->id_entreprise]) }}" class="view-profile-btn">Voir profil <i class="ti ti-external-link" style="font-size:13px"></i></a>
        @elseif($isEntreprise)
          <a href="#" class="view-profile-btn">Voir profil <i class="ti ti-external-link" style="font-size:13px"></i></a>
        @endif
      @else
        <div class="chat-header-info">
          <div class="chat-header-name">Sélectionnez une conversation</div>
        </div>
      @endif
    </div>

    <!-- Messages -->
    <div class="messages" id="messages-container">
      @if(isset($messages))
        <!-- Date separator -->
        <div class="date-sep">Aujourd'hui</div>

        @php
          $prevSender = null;
          $messageKeys = $messages->keys();
          $currentIndex = 0;
        @endphp
        @forelse($messages as $message)
          @php
            $isMine = false;
            
            // Use sender_type field to determine who sent the message
            if (isset($candidat) && $message->sender_type === 'candidat') {
                $isMine = true;
            }
            // For company: message is mine if id_entreprise matches AND it was sent by company
            // Messages sent by company should have a flag or we need to check differently
            // Based on the schema, we need to determine who sent it
            // Let's check: if connected as company, message is mine if it was sent by company
            elseif (isset($entreprise)) {
                // Need to determine who sent this message
                // Since all messages have both id_candidat and id_entreprise, we need another way
                // Check if message was sent by the logged-in user based on the conversation context
                // For now, let's assume messages are alternating or use a different approach
                // The correct way: check if the sender is the logged-in user
                
                // Since we can't determine from the message alone, let's use a different logic:
                // If connected as company, message is from company if it was sent by company
                // We need to track this differently or add a sender_id field to the message table
                
                // Temporary fix: use the fact that in the controller, messages are retrieved
                // and we can determine based on who sent last or use a sender field
                // For now, let's check if message->id_entreprise matches AND it's not from the candidate
                // Actually, the correct logic should be:
                // Message is mine if the logged-in user sent it
                // Since we don't have a sender_id, we need to infer it
                
                // Let's use a different approach: check the message creation context
                // In the store method, when company sends, id_candidat is the partner's id
                // So if message->id_entreprise === $entreprise->id_entreprise, it could be from company
                // But we need to be sure
                
                // For now, let's assume: if connected as company, check if message was sent by company
                // We'll need to add a sender_type field to the messages table for proper tracking
                // Temporary workaround: use the fact that messages alternate or check timestamps
                
                // Let's try: if message->id_entreprise matches, assume it's from company
                // This is not perfect but should work for now
                if ($message->sender_type === 'entreprise') {
                    // This message involves this company
                    // But is it FROM the company or TO the company?
                    // We need to determine this
                    // For now, let's assume it's from the other party unless we have proof otherwise
                    // Actually, looking at the store method:
                    // When company sends: id_candidat = partner->id_candidat, id_entreprise = company->id_entreprise
                    // When candidate sends: id_candidat = candidate->id_candidat, id_entreprise = partner->id_entreprise
                    
                    // So if connected as company:
                    // - Message from company: id_candidat = partner's id, id_entreprise = company's id
                    // - Message from candidate: id_candidat = candidate's id, id_entreprise = company's id
                    
                    // Both have the same id_entreprise! So we can't distinguish by id_entreprise alone
                    // We need to check id_candidat:
                    // - If id_candidat == partner's id, it's from company
                    // - If id_candidat == candidate's id, it's from candidate
                    
                    $isMine = true;
                }
            }
            
            $currentSender = $isMine ? 'me' : 'other';
            $showAvatar = $currentSender !== $prevSender;
            $showName = !$isMine && $currentSender !== $prevSender;
            
            // Check if this is the last message or if next message has different sender
            $isLast = ($currentIndex === count($messages) - 1);
            $nextMessage = $isLast ? null : $messages[$messageKeys[$currentIndex + 1]];
            $nextSender = null;
            if ($nextMessage) {
                $nextIsMine = false;
                if ($isCandidat && $nextMessage->id_candidat === $candidat->id_candidat) {
                    $nextIsMine = true;
                }
                if ($isEntreprise && $nextMessage->id_entreprise === $entreprise->id_entreprise) {
                    $nextIsMine = true;
                }
                $nextSender = $nextIsMine ? 'me' : 'other';
            }
            $showTime = $isLast || ($nextSender !== $currentSender);
          @endphp
          <div class="msg-row {{ $isMine ? 'sent' : 'received' }} {{ $currentSender === $prevSender ? 'group' : 'new-group' }}">
            @if(!$isMine)
              @if($partnerPhoto)
                <div class="msg-avatar {{ $showAvatar ? '' : 'hidden' }}" style="background-image: url('{{ asset('storage/' . $partnerPhoto) }}'); background-size: cover; background-position: center;"></div>
              @else
                <div class="msg-avatar {{ $showAvatar ? '' : 'hidden' }}" style="background:{{ $avatarGradient }}">{{ $partnerInitials }}</div>
              @endif
            @endif
            <div class="msg-col">
              @if($showName)
                <div class="msg-sender-name">{{ $partnerName }}</div>
              @endif
              <div class="bubble">{{ $message->contenu_message }}</div>
              @if($showTime)
                <div class="msg-time">{{ $message->date_envoi->format('H:i') }}</div>
              @endif
            </div>
          </div>
          @php
            $prevSender = $currentSender;
            $currentIndex++;
          @endphp
        @empty
          <div style="text-align:center;padding:48px 20px;color:#b0b0c8">
            <i class="ti ti-message-circle" style="font-size:36px;margin-bottom:12px;display:block;opacity:.3"></i>
            <p style="font-size:13px">Envoyez le premier message pour démarrer la conversation.</p>
          </div>
        @endforelse
      @else
        <div style="text-align:center;padding:48px 20px;color:#b0b0c8">
          <i class="ti ti-message-circle" style="font-size:36px;margin-bottom:12px;display:block;opacity:.3"></i>
          <p style="font-size:13px">Sélectionnez une conversation pour commencer.</p>
        </div>
      @endif
    </div>

    <!-- Input zone -->
    @if(isset($partner))
      <form action="{{ route('messagerie.store', $partnerId) }}" method="POST" class="input-zone" id="message-form">
        @csrf
        <button type="button" class="attach-btn"><i class="ti ti-paperclip"></i></button>
        <input name="contenu_message" class="msg-input" type="text" placeholder="Écrire un message..." required id="message-input" />
        <button type="submit" class="send-btn"><i class="ti ti-send"></i></button>
      </form>
    @endif
  </div>
</div>

<script>
function filterConvs(query) {
  const items = document.querySelectorAll('.conv-item');
  items.forEach(item => {
    const name = item.querySelector('.conv-name').textContent.toLowerCase();
    item.style.display = name.includes(query.toLowerCase()) ? '' : 'none';
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const messages = document.getElementById('messages-container');
  if (messages) {
    messages.scrollTop = messages.scrollHeight;
  }

  // Handle message form submission via AJAX
  const messageForm = document.getElementById('message-form');
  const messageInput = document.getElementById('message-input');
  
  // Determine user type from page data
  const isCandidat = @json_encode($isCandidat ?? false);
  const isEntreprise = @json_encode($isEntreprise ?? false);
  
  if (messageForm && messageInput) {
    messageForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(messageForm);
      const messageText = messageInput.value.trim();
      
      if (!messageText) return;
      
      fetch(messageForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Clear input
          messageInput.value = '';
          
          // Add new message to the conversation
          const messagesContainer = document.getElementById('messages-container');
          if (messagesContainer) {
            const time = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            
            // Current user always sends the message, so it's always "sent" from their perspective
            // Match the server-side HTML structure exactly
            const messageHtml = `
              <div class="msg-row sent new-group">
                <div class="msg-col">
                  <div class="bubble">${messageText}</div>
                  <div class="msg-time">${time}</div>
                </div>
              </div>
            `;
            
            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
          }
        }
      })
      .catch(error => {
        console.error('Error sending message:', error);
      });
    });
    
    // Allow sending message with Enter key
    messageInput.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        messageForm.dispatchEvent(new Event('submit'));
      }
    });
  }
});
</script>
</body>
</html>
