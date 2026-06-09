{{-- resources/views/admin/partials/sidebar.blade.php --}}
{{-- Uniquement le HTML de la barre latérale — inclure dans <body> uniquement --}}
<div class="sidebar">
  <div class="logo">
    <div class="logo-av">AD</div>
    <span>Talentlink</span>
  </div>

  <div class="nav-section-label">Général</div>
  <div class="nav-links">
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="ti ti-layout-dashboard"></i> Dashboard
    </a>
  </div>

  <div class="nav-section-label">Modération</div>
  <div class="nav-links">
    <a href="{{ route('admin.offres') }}"
       class="nav-link {{ request()->routeIs('admin.offres*') ? 'active' : '' }}">
      <i class="ti ti-briefcase"></i> Offres
      @php $pendingOffres = \App\Models\Offre::where('statut_offre','active')->count(); @endphp
      @if($pendingOffres > 0)
        <span class="badge-count">{{ $pendingOffres }}</span>
      @endif
    </a>
    <a href="{{ route('admin.avis') }}"
       class="nav-link {{ request()->routeIs('admin.avis*') ? 'active' : '' }}">
      <i class="ti ti-star"></i> Avis
      @php $pendingAvis = \App\Models\Avis::where('statut_avis','publié')->count(); @endphp
      @if($pendingAvis > 0)
        <span class="badge-count">{{ $pendingAvis }}</span>
      @endif
    </a>
  </div>

  <div class="nav-section-label">Comptes</div>
  <div class="nav-links">
    <a href="{{ route('admin.candidats') }}"
       class="nav-link {{ request()->routeIs('admin.candidats*') ? 'active' : '' }}">
      <i class="ti ti-users"></i> Candidats
    </a>
    <a href="{{ route('admin.entreprises') }}"
       class="nav-link {{ request()->routeIs('admin.entreprises*') ? 'active' : '' }}">
      <i class="ti ti-building"></i> Entreprises
    </a>
  </div>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">
        <i class="ti ti-logout"></i> Déconnexion
      </button>
    </form>
  </div>
</div>
