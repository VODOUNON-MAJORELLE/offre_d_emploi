<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Notifications — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--green-light:#d1fae5;
  --orange:#f59e0b;--orange-light:#fef3c7;
  --purple:#a855f7;--purple-light:#f3e8ff;
  --blue:#3b82f6;--blue-light:#dbeafe;
  --r:14px;--rs:8px;
}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s}
.nav-link:hover{color:var(--t1)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--accent);text-decoration:none}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
.user-av-entreprise{width:32px;height:32px;border-radius:50%;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.user-av-candidat{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* PAGE */
.page{max-width:760px;margin:0 auto;padding:32px 20px 60px}
.back-link{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--t2);margin-bottom:20px;cursor:pointer;text-decoration:none;transition:color .12s}
.back-link:hover{color:var(--t1)}

.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:6px;flex-wrap:wrap;gap:12px}
.title-row{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.page-title{font-size:24px;font-weight:800}
.new-badge{font-size:12px;font-weight:600;padding:4px 12px;border-radius:99px;background:var(--blue-light);color:#1d4ed8}
.page-sub{font-size:13px;color:var(--t2);margin-bottom:24px}
.mark-all-btn{display:inline-flex;align-items:center;gap:7px;padding:10px 18px;border:0.5px solid var(--border);border-radius:var(--rs);background:var(--card);font-size:13px;font-weight:500;font-family:inherit;color:var(--t1);cursor:pointer;white-space:nowrap;transition:background .12s}
.mark-all-btn:hover{background:#f5f6fa}

/* TABS */
.tabs{display:flex;gap:4px;margin-bottom:20px;background:var(--card);border:0.5px solid var(--border);border-radius:var(--rs);padding:4px;width:fit-content}
.tab{padding:8px 18px;border-radius:6px;font-size:13px;font-weight:500;cursor:pointer;transition:background .12s,color .12s;color:var(--t2)}
.tab.active{background:linear-gradient(135deg,#7c6ff0,#5b4be8);color:#fff}
.tab:hover:not(.active){background:#f5f6fa;color:var(--t1)}

/* NOTIF CARD */
.notif-card{background:var(--card);border:0.5px solid var(--border);border-radius:var(--r);padding:18px 20px;margin-bottom:10px;display:flex;align-items:flex-start;gap:16px;cursor:pointer;transition:box-shadow .15s;position:relative}
.notif-card:hover{box-shadow:0 4px 18px rgba(0,0,0,.07)}
.notif-card.unread{border-left:3px solid var(--accent)}
.notif-card.read{opacity:.75}

.notif-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
.ni-blue{background:var(--blue-light);color:var(--blue)}
.ni-purple{background:var(--purple-light);color:var(--purple)}
.ni-green{background:var(--green-light);color:var(--green)}
.ni-orange{background:var(--orange-light);color:var(--orange)}
.ni-accent{background:var(--accent-light);color:var(--accent)}

.notif-body{flex:1;min-width:0}
.notif-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:4px}
.notif-title{font-size:14px;font-weight:700}
.notif-meta{display:flex;align-items:center;gap:8px;flex-shrink:0}
.notif-time{font-size:11px;color:var(--t3);white-space:nowrap}
.unread-dot{width:8px;height:8px;border-radius:50%;background:var(--blue);flex-shrink:0}
.notif-desc{font-size:13px;color:var(--t2);line-height:1.5}

/* Empty state */
.empty{text-align:center;padding:48px 20px;color:var(--t3)}
.empty i{font-size:36px;margin-bottom:12px;display:block;opacity:.4}
.empty p{font-size:13px}

/* Section label */
.section-label{font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--t3);margin:20px 0 10px}
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
        <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
        <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      @elseif($isEntreprise)
        <a class="nav-link" href="{{ route('entreprise.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('entreprise.profil') }}">Profil</a>
      @endif
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $unreadNotifCount = \App\Models\Notification::where(function($query) use ($isCandidat, $isEntreprise) {
          if ($isCandidat) {
              $query->where('id_candidat', \Illuminate\Support\Facades\Auth::guard('candidat')->user()->id_candidat);
          } elseif ($isEntreprise) {
              $query->where('id_entreprise', \Illuminate\Support\Facades\Auth::guard('entreprise')->user()->id_entreprise);
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
      <div class="user-av-candidat">{{ $initials }}</div>
    @elseif($isEntreprise)
      @php
        $user = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        $initials = substr($user->nom_entreprise, 0, 2);
      @endphp
      <div class="user-av-entreprise">{{ $initials }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<div class="page">
  @if($isCandidat)
    <a href="{{ route('candidat.dashboard') }}" class="back-link"><i class="ti ti-arrow-left"></i> Retour aux candidatures</a>
  @elseif($isEntreprise)
    <a href="{{ route('entreprise.dashboard') }}" class="back-link"><i class="ti ti-arrow-left"></i> Retour au tableau de bord</a>
  @endif

  <div class="page-header">
    <div>
      <div class="title-row">
        <div class="page-title">Notifications</div>
        <span class="new-badge" id="new-count">0 nouvelle</span>
      </div>
      <div class="page-sub">Restez informé de l'activité de votre compte.</div>
    </div>
    <button class="mark-all-btn" onclick="markAll()">Tout marquer comme lu</button>
  </div>

  @php
    $notifications = \App\Models\Notification::where(function($query) use ($isCandidat, $isEntreprise) {
        if ($isCandidat) {
            $query->where('id_candidat', \Illuminate\Support\Facades\Auth::guard('candidat')->user()->id_candidat);
        } elseif ($isEntreprise) {
            $query->where('id_entreprise', \Illuminate\Support\Facades\Auth::guard('entreprise')->user()->id_entreprise);
        }
    })->orderByDesc('date_envoi')->get();
    
    $unreadCount = $notifications->where('statut_lecture', 'non lu')->count();
  @endphp

  <div id="notif-list">
    @if($notifications->count() > 0)
      @php
        $unread = $notifications->where('statut_lecture', 'non lu');
        $read = $notifications->where('statut_lecture', '!=', 'non lu');
      @endphp
      
      @if($unread->count() > 0)
        <div class="section-label">Nouvelles</div>
        @foreach($unread as $notif)
          @php
            $iconClass = 'ni-blue';
            $icon = 'ti ti-bell';
            if (str_contains($notif->type_notification, 'candidature')) {
                $iconClass = 'ni-accent';
                $icon = 'ti ti-briefcase';
            } elseif (str_contains($notif->type_notification, 'message')) {
                $iconClass = 'ni-purple';
                $icon = 'ti ti-message-circle';
            } elseif (str_contains($notif->type_notification, 'entretien')) {
                $iconClass = 'ni-green';
                $icon = 'ti ti-calendar';
            } elseif (str_contains($notif->type_notification, 'offre')) {
                $iconClass = 'ni-orange';
                $icon = 'ti ti-star';
            }
          @endphp
          <div class="notif-card unread" onclick="markRead({{ $notif->id_notification }})">
            <div class="notif-icon {{ $iconClass }}"><i class="{{ $icon }}"></i></div>
            <div class="notif-body">
              <div class="notif-top">
                <div class="notif-title">{{ $notif->type_notification }}</div>
                <div class="notif-meta">
                  <span class="notif-time">{{ $notif->date_envoi->diffForHumans() }}</span>
                  <div class="unread-dot"></div>
                </div>
              </div>
              <div class="notif-desc">{{ $notif->contenu_notification }}</div>
            </div>
          </div>
        @endforeach
      @endif
      
      @if($read->count() > 0)
        <div class="section-label">Précédentes</div>
        @foreach($read as $notif)
          @php
            $iconClass = 'ni-blue';
            $icon = 'ti ti-bell';
            if (str_contains($notif->type_notification, 'candidature')) {
                $iconClass = 'ni-accent';
                $icon = 'ti ti-briefcase';
            } elseif (str_contains($notif->type_notification, 'message')) {
                $iconClass = 'ni-purple';
                $icon = 'ti ti-message-circle';
            } elseif (str_contains($notif->type_notification, 'entretien')) {
                $iconClass = 'ni-green';
                $icon = 'ti ti-calendar';
            } elseif (str_contains($notif->type_notification, 'offre')) {
                $iconClass = 'ni-orange';
                $icon = 'ti ti-star';
            }
          @endphp
          <div class="notif-card read">
            <div class="notif-icon {{ $iconClass }}"><i class="{{ $icon }}"></i></div>
            <div class="notif-body">
              <div class="notif-top">
                <div class="notif-title">{{ $notif->type_notification }}</div>
                <div class="notif-meta">
                  <span class="notif-time">{{ $notif->date_envoi->diffForHumans() }}</span>
                </div>
              </div>
              <div class="notif-desc">{{ $notif->contenu_notification }}</div>
            </div>
          </div>
        @endforeach
      @endif
    @else
      <div class="empty"><i class="ti ti-bell-off"></i><p>Aucune notification pour l'instant.</p></div>
    @endif
  </div>
</div>

<script>
const unreadCount = {{ $unreadCount }};
const badge = document.getElementById('new-count');
badge.textContent = unreadCount > 0 ? unreadCount + ' nouvelle' + (unreadCount > 1 ? 's' : '') : 'Tout lu';
badge.style.background = unreadCount > 0 ? '' : '#f3f4f6';
badge.style.color = unreadCount > 0 ? '' : 'var(--t3)';

function markRead(id) {
  fetch('/notifications/' + id + '/mark-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
    .then(() => location.reload());
}

function markAll() {
  fetch('/notifications/mark-all-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content } })
    .then(() => location.reload());
}
</script>
</body>
</html>
