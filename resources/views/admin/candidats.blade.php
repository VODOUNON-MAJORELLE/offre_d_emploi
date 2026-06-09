<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestion des Candidats — Talentlink Admin</title>
  @include('admin.partials.head')
  <style>
    .page-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:1.8rem;flex-wrap:wrap;gap:1rem; }
    .page-title { font-family:'Syne',sans-serif;font-weight:800;font-size:22px;color:#1a1550; }
    .page-sub { font-size:13px;color:#9090b0;margin-top:3px; }
    .flash { padding:12px 18px;border-radius:12px;margin-bottom:1.4rem;display:flex;align-items:center;gap:10px;font-size:13.5px;font-weight:500; }
    .flash.success { background:#d1fae5;color:#065f46;border:1px solid #a7f3d0; }
    .tabs { display:flex;gap:6px;flex-wrap:wrap;margin-bottom:1.4rem; }
    .tab { padding:8px 18px;border-radius:10px;font-size:13px;font-weight:600;border:1px solid #e8e8f4;background:#fff;color:#7070a0;text-decoration:none;transition:all 0.15s;display:flex;align-items:center;gap:7px; }
    .tab:hover { border-color:#a0a0e0;color:#5040e8; }
    .tab.active { background:#5040e8;color:#fff;border-color:#5040e8; }
    .tab .n { font-size:11px;background:rgba(255,255,255,.2);padding:2px 7px;border-radius:99px; }
    .tab:not(.active) .n { background:#f0f0fa;color:#5040e8; }
    .search-bar { display:flex;gap:10px;margin-bottom:1.4rem; }
    .search-input { flex:1;padding:10px 16px;border:1px solid #e8e8f4;border-radius:12px;font-size:13.5px;background:#fff;outline:none;font-family:inherit;color:#1a1550;transition:border-color 0.15s; }
    .search-input:focus { border-color:#5040e8; }
    .search-btn { padding:10px 20px;background:#5040e8;color:#fff;border:none;border-radius:12px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:8px;transition:background 0.15s; }
    .search-btn:hover { background:#3d30c5; }
    .card { background:#fff;border:1px solid #e8e8f4;border-radius:18px;overflow:hidden; }
    .table-wrap { overflow-x:auto; }
    table { width:100%;border-collapse:collapse; }
    thead th { padding:14px 18px;background:#f8f8fc;border-bottom:1px solid #e8e8f4;font-size:11px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#9090b0;text-align:left;white-space:nowrap; }
    tbody td { padding:14px 18px;border-bottom:1px solid #f4f4f8;font-size:13.5px;vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:#fbfbfe; }
    .avatar-initials { width:38px;height:38px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:13px;color:#fff;flex-shrink:0; }
    .cell-user { display:flex;align-items:center;gap:12px; }
    .cell-title { font-weight:600;color:#1a1550; }
    .cell-sub { font-size:12px;color:#9090b0;margin-top:2px; }
    .badge { display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:600; }
    .badge-actif    { background:#d1fae5;color:#065f46; }
    .badge-suspendu { background:#fef3c7;color:#92400e; }
    .badge-supprime { background:#fee2e2;color:#991b1b; }
    .action-group { display:flex;gap:6px;align-items:center; }
    .btn-action {
      padding:6px 14px;border:none;border-radius:9px;font-size:12px;font-weight:600;
      cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:6px;
      transition:all 0.15s;white-space:nowrap;
    }
    .btn-action.suspend  { background:#fef3c7;color:#92400e; }
    .btn-action.suspend:hover { background:#fde68a; }
    .btn-action.delete   { background:#fee2e2;color:#dc2626; }
    .btn-action.delete:hover  { background:#fecaca; }
    .btn-action.restore  { background:#d1fae5;color:#16a34a; }
    .btn-action.restore:hover { background:#a7f3d0; }
    .confirm-inline { display:none;align-items:center;gap:8px;margin-top:8px;background:#fff8f0;border:1px solid #fde68a;border-radius:10px;padding:10px 14px; }
    .confirm-inline.open { display:flex; }
    .confirm-text { font-size:12.5px;color:#92400e;font-weight:500; }
    .confirm-yes { padding:5px 14px;background:#dc2626;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer; }
    .confirm-no  { padding:5px 10px;background:none;color:#9090b0;border:none;font-size:12px;cursor:pointer; }
    .empty-state { padding:3rem 2rem;text-align:center; }
    .empty-state i { font-size:48px;color:#c0c0d8;margin-bottom:1rem;display:block; }
    .empty-state p { color:#9090b0;font-size:14px; }
    .pagination-wrap { padding:1rem 1.4rem;display:flex;justify-content:center; }
  </style>
</head>
<body>
@include('admin.partials.sidebar')

<div class="main">
  <div class="page-header">
    <div>
      <div class="page-title"><i class="ti ti-users" style="color:#5040e8;margin-right:8px"></i>Gestion des Candidats</div>
      <div class="page-sub">Consultez, suspendez, supprimez ou réactivez les comptes candidats</div>
    </div>
  </div>

  @if(session('success'))
    <div class="flash success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
  @endif

  <!-- Tabs -->
  <div class="tabs">
    @php $tabDefs = ['tous' => 'Tous', 'actif' => 'Actifs', 'suspendu' => 'Suspendus', 'supprimé' => 'Supprimés']; @endphp
    @foreach($tabDefs as $key => $label)
      @php $cnt = $key === 'tous' ? array_sum($counts) : ($counts[$key] ?? 0); @endphp
      <a href="{{ route('admin.candidats', ['statut' => $key, 'search' => $search]) }}"
         class="tab {{ $statut === $key ? 'active' : '' }}">
        {{ $label }} <span class="n">{{ $cnt }}</span>
      </a>
    @endforeach
  </div>

  <!-- Search -->
  <form method="GET" action="{{ route('admin.candidats') }}">
    <input type="hidden" name="statut" value="{{ $statut }}" />
    <div class="search-bar">
      <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom, prénom ou email..." class="search-input" />
      <button type="submit" class="search-btn"><i class="ti ti-search"></i> Rechercher</button>
    </div>
  </form>

  <!-- Table -->
  <div class="card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Candidat</th>
            <th>Ville</th>
            <th>Niveau</th>
            <th>Inscription</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($candidats as $candidat)
            @php
              $initials = strtoupper(substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1));
              $grads = ['linear-gradient(135deg,#6366f1,#8b5cf6)','linear-gradient(135deg,#10b981,#0ea5e9)','linear-gradient(135deg,#f59e0b,#ec4899)','linear-gradient(135deg,#5040e8,#a78bfa)'];
              $grad = $grads[$candidat->id_candidat % count($grads)];
            @endphp
            <tr>
              <td>
                <div class="cell-user">
                  @if($candidat->photo_profil)
                    <img src="{{ Storage::url($candidat->photo_profil) }}" width="38" height="38" style="border-radius:12px;object-fit:cover;flex-shrink:0" alt="">
                  @else
                    <div class="avatar-initials" style="background:{{ $grad }}">{{ $initials }}</div>
                  @endif
                  <div>
                    <div class="cell-title">{{ $candidat->prenom }} {{ $candidat->nom }}</div>
                    <div class="cell-sub">{{ $candidat->email }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $candidat->ville ?? '—' }}</td>
              <td>{{ $candidat->niveau_etudes ?? '—' }}</td>
              <td style="white-space:nowrap">{{ $candidat->date_inscription ? $candidat->date_inscription->format('d/m/Y') : '—' }}</td>
              <td>
                @if($candidat->statut_compte === 'actif')
                  <span class="badge badge-actif"><i class="ti ti-circle-check"></i> Actif</span>
                @elseif($candidat->statut_compte === 'suspendu')
                  <span class="badge badge-suspendu"><i class="ti ti-ban"></i> Suspendu</span>
                @else
                  <span class="badge badge-supprime"><i class="ti ti-trash"></i> Supprimé</span>
                @endif
              </td>
              <td>
                <div class="action-group">
                  @if($candidat->statut_compte === 'actif')
                    {{-- Suspendre --}}
                    <form method="POST" action="{{ route('admin.candidats.suspendre', $candidat->id_candidat) }}">
                      @csrf
                      <button type="submit" class="btn-action suspend"
                              onclick="return confirm('Suspendre {{ addslashes($candidat->prenom . ' ' . $candidat->nom) }} ?')">
                        <i class="ti ti-ban"></i> Suspendre
                      </button>
                    </form>
                    {{-- Supprimer --}}
                    <form method="POST" action="{{ route('admin.candidats.supprimer', $candidat->id_candidat) }}">
                      @csrf
                      <button type="submit" class="btn-action delete"
                              onclick="return confirm('Supprimer définitivement {{ addslashes($candidat->prenom . ' ' . $candidat->nom) }} ?')">
                        <i class="ti ti-trash"></i> Supprimer
                      </button>
                    </form>
                  @elseif($candidat->statut_compte === 'suspendu')
                    {{-- Réactiver --}}
                    <form method="POST" action="{{ route('admin.candidats.reactiver', $candidat->id_candidat) }}">
                      @csrf
                      <button type="submit" class="btn-action restore">
                        <i class="ti ti-refresh"></i> Réactiver
                      </button>
                    </form>
                    {{-- Supprimer --}}
                    <form method="POST" action="{{ route('admin.candidats.supprimer', $candidat->id_candidat) }}">
                      @csrf
                      <button type="submit" class="btn-action delete"
                              onclick="return confirm('Supprimer {{ addslashes($candidat->prenom . ' ' . $candidat->nom) }} ?')">
                        <i class="ti ti-trash"></i> Supprimer
                      </button>
                    </form>
                  @else
                    {{-- Réactiver un compte supprimé --}}
                    <form method="POST" action="{{ route('admin.candidats.reactiver', $candidat->id_candidat) }}">
                      @csrf
                      <button type="submit" class="btn-action restore">
                        <i class="ti ti-refresh"></i> Réactiver
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">
                <div class="empty-state">
                  <i class="ti ti-users-off"></i>
                  <p>Aucun candidat trouvé.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($candidats->hasPages())
      <div class="pagination-wrap">{{ $candidats->links() }}</div>
    @endif
  </div>
</div>
</body>
</html>
