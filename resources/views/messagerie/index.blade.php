<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Messagerie — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --sidebar:#1e1e2e;--sidebar2:#2a2a3e;--sidebar-border:rgba(255,255,255,0.07);
  --green:#10b981;--r:12px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);height:100vh;display:flex;flex-direction:column;overflow:hidden}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;z-index:100}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px}
.nav-link:hover{color:var(--t1)}
.nav-link.active{color:var(--accent);font-weight:600;border-bottom:2px solid var(--accent)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;font-size:18px;color:var(--t2);text-decoration:none}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
.user-av{width:32px;height:32px;border-radius:50%;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* LAYOUT */
.layout{display:flex;flex:1;overflow:hidden}

/* SIDEBAR */
.sidebar{width:310px;background:var(--sidebar);display:flex;flex-direction:column;flex-shrink:0;border-right:0.5px solid var(--sidebar-border)}
.sidebar-title{padding:20px 18px 14px;font-size:16px;font-weight:700;color:#fff;border-bottom:0.5px solid var(--sidebar-border)}
.search-wrap{padding:12px 14px;border-bottom:0.5px solid var(--sidebar-border)}
.search-input{width:100%;background:rgba(255,255,255,0.07);border:0.5px solid rgba(255,255,255,0.1);border-radius:var(--rs);padding:9px 12px 9px 34px;font-size:12px;color:#e5e7eb;font-family:inherit;outline:none;transition:border-color .15s;position:relative}
.search-input::placeholder{color:rgba(255,255,255,0.35)}
.search-input:focus{border-color:rgba(124,111,240,.5)}
.search-wrap{position:relative}
.search-icon{position:absolute;left:24px;top:50%;transform:translateY(-50%);font-size:14px;color:rgba(255,255,255,.35);pointer-events:none}
.conv-list{flex:1;overflow-y:auto}
.conv-list::-webkit-scrollbar{width:4px}
.conv-list::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:2px}
.conv-item{display:flex;align-items:center;gap:12px;padding:14px 16px;cursor:pointer;border-bottom:0.5px solid var(--sidebar-border);transition:background .12s;position:relative;text-decoration:none;color:inherit}
.conv-item:hover{background:rgba(255,255,255,.04)}
.conv-item.active{background:rgba(124,111,240,.18);border-left:3px solid var(--accent2)}
.conv-av{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0;background-repeat:no-repeat;background-position:center;background-size:cover}
.conv-body{flex:1;min-width:0}
.conv-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:2px}
.conv-name{font-size:13px;font-weight:600;color:#f9fafb}
.conv-time{font-size:11px;color:rgba(255,255,255,.35)}
.conv-role{font-size:11px;color:var(--accent2);margin-bottom:2px}
.conv-preview{font-size:12px;color:rgba(255,255,255,.45);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.conv-badge{width:18px;height:18px;border-radius:50%;background:var(--accent);color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}

/* CHAT */
.chat{flex:1;display:flex;flex-direction:column;background:var(--bg);min-width:0}
.chat-header{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 20px;height:64px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.chat-header-left{display:flex;align-items:center;gap:12px}
.ch-av{width:40px;height:40px;border-radius:50%;background:#374151;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff}
.ch-name{font-size:15px;font-weight:700}
.ch-role{font-size:12px;color:var(--t2)}
.online-dot{width:8px;height:8px;border-radius:50%;background:var(--green);display:inline-block;margin-right:4px}
.ch-online{font-size:12px;color:var(--green);display:flex;align-items:center;gap:4px}
.voir-profil-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:12px;font-weight:500;font-family:inherit;cursor:pointer;transition:background .12s;text-decoration:none;color:var(--t1)}
.voir-profil-btn:hover{background:#f5f6fa}

/* MESSAGES */
.messages{flex:1;overflow-y:auto;padding:24px 20px;display:flex;flex-direction:column;gap:4px}
.messages::-webkit-scrollbar{width:4px}
.messages::-webkit-scrollbar-thumb{background:rgba(0,0,0,.1);border-radius:2px}
.msg-sender-label{font-size:11px;color:var(--t3);margin-bottom:4px;padding-left:2px}
.bubble{max-width:62%;padding:12px 16px;border-radius:16px;font-size:13px;line-height:1.6;word-break:break-word}
.bubble.sent{background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff;border-bottom-right-radius:4px;align-self:flex-end}
.bubble.recv{background:#fff;color:var(--t1);border:0.5px solid var(--border);border-bottom-left-radius:4px;align-self:flex-start}
.msg-time{font-size:10px;color:var(--t3);margin-top:3px;padding:0 2px}
.msg-time.sent-time{align-self:flex-end}
.msg-time.recv-time{align-self:flex-start}
.msg-group{display:flex;flex-direction:column;margin-bottom:14px}
.msg-group.sent{align-items:flex-end}
.msg-group.recv{align-items:flex-start}

/* INPUT */
.chat-input-wrap{background:var(--card);border-top:0.5px solid var(--border);padding:12px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0}
.msg-input{flex:1;border:0.5px solid var(--border);border-radius:24px;padding:11px 18px;font-size:13px;font-family:inherit;color:var(--t1);outline:none;transition:border-color .15s;background:#fafafa}
.msg-input:focus{border-color:var(--accent);background:#fff}
.msg-input::placeholder{color:var(--t3)}
.send-btn{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#7c6ff0,#5b4be8);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;transition:opacity .15s}
.send-btn:hover{opacity:.88}

/* Empty state */
.empty-chat{flex:1;display:flex;align-items:center;justify-content:center;flex-direction:column;color:var(--t3)}
.empty-chat i{font-size:48px;margin-bottom:16px;opacity:.3}
.empty-chat p{font-size:13px}
</style>
</head>
<body>

<nav>
  <div class="nav-left">
    <div class="nav-logo"><div class="logo-av">JR</div><span>Talentlink</span></div>
    <div class="nav-links">
      @php
        $isCandidat = \Illuminate\Support\Facades\Auth::guard('candidat')->check();
        $isEntreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->check();
      @endphp
      @if($isCandidat)
        <a class="nav-link" href="{{ route('candidat.feed') }}">Feed</a>
      @elseif($isEntreprise)
        <a class="nav-link" href="/">Feed</a>
      @endif
      @if($isCandidat)
        <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
        <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      @elseif($isEntreprise)
        <a class="nav-link" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="#">Profil</a>
      @endif
      <a class="nav-link active">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $candidat = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
      $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
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
    @if($isCandidat)
      @php
        $user = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
        $initials = substr($user->prenom, 0, 1) . substr($user->nom, 0, 1);
      @endphp
      @if($user->photo_profil)
        <div class="user-av" style="background-image: url('{{ asset('storage/' . $user->photo_profil) }}'); background-size: cover; background-position: center;"></div>
      @else
        <div class="user-av" style="background:linear-gradient(135deg,#ec4899,#a855f7)">{{ $initials }}</div>
      @endif
    @elseif($isEntreprise)
      @php
        $user = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        $initials = substr($user->nom_entreprise, 0, 2);
      @endphp
      @if($user->logo_entreprise)
        <div class="user-av" style="background-image: url('{{ asset('storage/' . $user->logo_entreprise) }}'); background-size: cover; background-position: center;"></div>
      @else
        <div class="user-av">{{ $initials }}</div>
      @endif
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<div class="layout">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-title">
      @if($isCandidat)
        Messagerie Entreprises
      @elseif($isEntreprise)
        Messagerie Candidats
      @else
        Messagerie
      @endif
    </div>
    <div class="search-wrap">
      <i class="ti ti-search search-icon"></i>
      <input class="search-input" type="text" placeholder="@if($isCandidat)Rechercher une entreprise...@elseif($isEntreprise)Rechercher un candidat...@elseRechercher...@endif">
    </div>
    <div class="conv-list">
      @if(isset($conversations) && $conversations->count() > 0)
        @foreach($conversations as $contact)
          @if($contact)
            @php
              $lastMsg = $contact->last_message ?? null;
              $partnerId = $isCandidat ? $contact->id_entreprise : $contact->id_candidat;
              $partnerName = $isCandidat ? $contact->nom_entreprise : ($contact->prenom . ' ' . $contact->nom);
              $partnerInitials = $isCandidat
                  ? strtoupper(substr($contact->nom_entreprise, 0, 2))
                  : strtoupper(substr($contact->prenom, 0, 1) . substr($contact->nom, 0, 1));
              $partnerPhoto = $isCandidat ? $contact->logo_entreprise : $contact->photo_profil;
              $unread = $lastMsg && $lastMsg->statut_lecture === 'non lu';
              $role = $isCandidat ? $contact->titre_offre ?? 'Recruteur' : ($contact->niveau_etudes ?? 'Candidat');
              $color = '#6c63ff';
            @endphp
            <a href="{{ route('messagerie.show', $partnerId) }}" class="conv-item {{ $unread ? 'active' : '' }}">
              @if($partnerPhoto)
                <div class="conv-av" style="background-image: url('{{ asset('storage/' . $partnerPhoto) }}'); background-size: cover; background-position: center;"></div>
              @else
                <div class="conv-av" style="background:{{ $color }}">{{ $partnerInitials }}</div>
              @endif
              <div class="conv-body">
                <div class="conv-top"><span class="conv-name">{{ $partnerName }}</span><span class="conv-time">{{ $lastMsg ? $lastMsg->date_envoi->diffForHumans() : '' }}</span></div>
                <div class="conv-role">{{ $role }}</div>
                <div class="conv-preview">{{ $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->contenu_message, 50) : 'Aucun message' }}</div>
              </div>
              @if($unread)
                <div class="conv-badge">1</div>
              @endif
            </a>
          @endif
        @endforeach
      @else
        <div style="padding:40px 20px;text-align:center;color:rgba(255,255,255,.4)">
          <i class="ti ti-message-circle-off" style="font-size:32px;margin-bottom:12px;display:block"></i>
          <p style="font-size:13px">@if($isCandidat)Aucune conversation. Postulez à une offre pour démarrer un échange.@elseAucune conversation. Les candidats vous contacteront après avoir postulé.@endif</p>
        </div>
      @endif
    </div>
  </div>

  <!-- Chat -->
  <div class="chat">
    <div class="empty-chat">
      <i class="ti ti-message-circle"></i>
      <p>Sélectionnez une conversation pour commencer</p>
    </div>
  </div>
</div>

</body>
</html>
