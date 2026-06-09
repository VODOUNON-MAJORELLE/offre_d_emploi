<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gestion des Entreprises — Talentlink Admin</title>
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
    .logo-cell { width:38px;height:38px;border-radius:12px;object-fit:cover;flex-shrink:0; }
    .logo-initials { width:38px;height:38px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:13px;color:#fff;flex-shrink:0; }
    .cell-ent { display:flex;align-items:center;gap:12px; }
    .cell-title { font-weight:600;color:#1a1550; }
    .cell-sub { font-size:12px;color:#9090b0;margin-top:2px; }
    .rating { display:flex;align-items:center;gap:5px; }
    .rating i { font-size:13px;color:#f59e0b; }
    .rating span { font-size:12px;color:#9090b0; }
    .badge { display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:600; }
    .badge-actif    { background:#d1fae5;color:#065f46; }
    .badge-suspendu { background:#fef3c7;color:#92400e; }
    .badge-supprime { background:#fee2e2;color:#991b1b; }
    .count-chip { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:8px;background:#f4f4f8;font-size:12px;font-weight:600;color:#5040e8; }
    .action-group { display:flex;gap:6px;align-items:center;flex-wrap:wrap; }
    .btn-action { padding:6px 14px;border:none;border-radius:9px;font-size:12px;font-weight:600;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:6px;transition:all 0.15s;white-space:nowrap; }
    .btn-action.suspend  { background:#fef3c7;color:#92400e; }
    .btn-action.suspend:hover { background:#fde68a; }
    .btn-action.delete   { background:#fee2e2;color:#dc2626; }
    .btn-action.delete:hover  { background:#fecaca; }
    .btn-action.restore  { background:#d1fae5;color:#16a34a; }
    .btn-action.restore:hover { background:#a7f3d0; }
    .btn-action.profile  { background:#f4f5fa;color:#5040e8; }
    .btn-action.profile:hover { background:#eeeeff; }
    .empty-state { padding:3rem 2rem;text-align:center; }
    .empty-state i { font-size:48px;color:#c0c0d8;margin-bottom:1rem;display:block; }
    .empty-state p { color:#9090b0;font-size:14px; }
    .pagination-wrap { padding:1rem 1.4rem;display:flex;justify-content:center; }
    .info-warning { background:#fef9ec;border:1px solid #fde68a;border-radius:12px;padding:12px 16px;display:flex;align-items:center;gap:10px;font-size:13px;color:#92400e;margin-bottom:1.4rem; }
  </style>
</head>
<body>
@include('admin.partials.sidebar')

<div class="main">
  <div class="page-header">
    <div>
      <div class="page-title"><i class="ti ti-building" style="color:#5040e8;margin-right:8px"></i>Gestion des Entreprises</div>
      <div class="page-sub">Consultez, suspendez, supprimez ou réactivez les comptes entreprises</div>
    </div>
  </div>

  @if(session('success'))
    <div class="flash success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
  @endif

  <div class="info-warning">
    <i class="ti ti-info-circle" style="font-size:18px"></i>
    <span>Suspendre ou supprimer une entreprise mettra automatiquement en pause toutes ses offres actives.</span>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    @php $tabDefs = ['tous' => 'Toutes', 'actif' => 'Actives', 'suspendu' => 'Suspendues', 'supprimé' => 'Supprimées']; @endphp
    @foreach($tabDefs as $key => $label)
      @php $cnt = $key === 'tous' ? array_sum($counts) : ($counts[$key] ?? 0); @endphp
      <a href="{{ route('admin.entreprises', ['statut' => $key, 'search' => $search]) }}"
         class="tab {{ $statut === $key ? 'active' : '' }}">
        {{ $label }} <span class="n">{{ $cnt }}</span>
      </a>
    @endforeach
  </div>

  <!-- Search -->
  <form method="GET" action="{{ route('admin.entreprises') }}">
    <input type="hidden" name="statut" value="{{ $statut }}" />
    <div class="search-bar">
      <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par nom, email ou secteur..." class="search-input" />
      <button type="submit" class="search-btn"><i class="ti ti-search"></i> Rechercher</button>
    </div>
  </form>

  <!-- Table -->
  <div class="card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Entreprise</th>
            <th>Secteur</th>
            <th>Ville</th>
            <th>Offres</th>
            <th>Note</th>
            <th>Inscription</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($entreprises as $entreprise)
            @php
              $initials = strtoupper(substr($entreprise->nom_entreprise, 0, 2));
              $grads = ['linear-gradient(135deg,#5040e8,#7c6ff0)','linear-gradient(135deg,#10b981,#0ea5e9)','linear-gradient(135deg,#f59e0b,#f97316)','linear-gradient(135deg,#ec4899,#a855f7)','linear-gradient(135deg,#ef4444,#f97316)'];
              $grad = $grads[$entreprise->id_entreprise % count($grads)];
            @endphp
            <tr>
              <td>
                <div class="cell-ent">
                  @if($entreprise->logo)
                    <img src="{{ Storage::url($entreprise->logo) }}" class="logo-cell" alt="{{ $entreprise->nom_entreprise }}">
                  @else
                    <div class="logo-initials" style="background:{{ $grad }}">{{ $initials }}</div>
                  @endif
                  <div>
                    <div class="cell-title">{{ $entreprise->nom_entreprise }}</div>
                    <div class="cell-sub">{{ $entreprise->email }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $entreprise->secteur_activite ?? '—' }}</td>
              <td>{{ $entreprise->ville_entreprise ?? '—' }}</td>
              <td>
                <span class="count-chip"><i class="ti ti-briefcase"></i> {{ $entreprise->offres_count }}</span>
              </td>
              <td>
                <div class="rating">
                  <i class="ti ti-star-filled"></i>
                  <span>{{ number_format($entreprise->note_moyenne, 1) }}/5</span>
                </div>
              </td>
              <td style="white-space:nowrap">{{ $entreprise->date_inscription ? $entreprise->date_inscription->format('d/m/Y') : '—' }}</td>
              <td>
                @if($entreprise->statut_compte === 'actif')
                  <span class="badge badge-actif"><i class="ti ti-circle-check"></i> Active</span>
                @elseif($entreprise->statut_compte === 'suspendu')
                  <span class="badge badge-suspendu"><i class="ti ti-ban"></i> Suspendue</span>
                @else
                  <span class="badge badge-supprime"><i class="ti ti-trash"></i> Supprimée</span>
                @endif
              </td>
              <td>
                <div class="action-group">
                  {{-- Voir profil --}}
                  <a href="{{ route('candidat.entreprise.profil', $entreprise->id_entreprise) }}" class="btn-action profile" target="_blank">
                    <i class="ti ti-eye"></i>
                  </a>

                  @if($entreprise->statut_compte === 'actif')
                    <form method="POST" action="{{ route('admin.entreprises.suspendre', $entreprise->id_entreprise) }}">
                      @csrf
                      <button type="submit" class="btn-action suspend"
                              onclick="return confirm('Suspendre {{ addslashes($entreprise->nom_entreprise) }} ? Ses offres actives seront mises en pause.')">
                        <i class="ti ti-ban"></i> Suspendre
                      </button>
                    </form>
                    <form method="POST" action="{{ route('admin.entreprises.supprimer', $entreprise->id_entreprise) }}">
                      @csrf
                      <button type="submit" class="btn-action delete"
                              onclick="return confirm('Supprimer {{ addslashes($entreprise->nom_entreprise) }} ?')">
                        <i class="ti ti-trash"></i>
                      </button>
                    </form>
                  @elseif($entreprise->statut_compte === 'suspendu')
                    <form method="POST" action="{{ route('admin.entreprises.reactiver', $entreprise->id_entreprise) }}">
                      @csrf
                      <button type="submit" class="btn-action restore">
                        <i class="ti ti-refresh"></i> Réactiver
                      </button>
                    </form>
                    <form method="POST" action="{{ route('admin.entreprises.supprimer', $entreprise->id_entreprise) }}">
                      @csrf
                      <button type="submit" class="btn-action delete"
                              onclick="return confirm('Supprimer {{ addslashes($entreprise->nom_entreprise) }} ?')">
                        <i class="ti ti-trash"></i>
                      </button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('admin.entreprises.reactiver', $entreprise->id_entreprise) }}">
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
              <td colspan="8">
                <div class="empty-state">
                  <i class="ti ti-building-off"></i>
                  <p>Aucune entreprise trouvée.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($entreprises->hasPages())
      <div class="pagination-wrap">{{ $entreprises->links() }}</div>
    @endif
  </div>
</div>
</body>
</html>
