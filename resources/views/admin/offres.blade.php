<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modération des Offres — Talentlink Admin</title>
  @include('admin.partials.head')
  <style>
    /* ── PAGE STYLES ── */
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.8rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Syne',sans-serif; font-weight:800; font-size:22px; color:#1a1550; }
    .page-sub { font-size:13px; color:#9090b0; margin-top:3px; }

    /* Flash */
    .flash { padding:12px 18px; border-radius:12px; margin-bottom:1.4rem; display:flex; align-items:center; gap:10px; font-size:13.5px; font-weight:500; }
    .flash.success { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
    .flash.error   { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }

    /* Tabs */
    .tabs { display:flex; gap:6px; flex-wrap:wrap; margin-bottom:1.4rem; }
    .tab {
      padding:8px 18px; border-radius:10px; font-size:13px; font-weight:600;
      border:1px solid #e8e8f4; background:#fff; color:#7070a0;
      text-decoration:none; transition:all 0.15s; cursor:pointer; display:flex; align-items:center; gap:7px;
    }
    .tab:hover { border-color:#a0a0e0; color:#5040e8; }
    .tab.active { background:#5040e8; color:#fff; border-color:#5040e8; }
    .tab .n { font-size:11px; background:rgba(255,255,255,.2); padding:2px 7px; border-radius:99px; }
    .tab:not(.active) .n { background:#f0f0fa; color:#5040e8; }

    /* Search bar */
    .search-bar { display:flex; gap:10px; margin-bottom:1.4rem; }
    .search-input {
      flex:1; padding:10px 16px; border:1px solid #e8e8f4; border-radius:12px;
      font-size:13.5px; background:#fff; outline:none; font-family:inherit; color:#1a1550;
      transition:border-color 0.15s;
    }
    .search-input:focus { border-color:#5040e8; }
    .search-btn {
      padding:10px 20px; background:#5040e8; color:#fff; border:none;
      border-radius:12px; font-size:13.5px; font-weight:600; cursor:pointer;
      font-family:inherit; display:flex; align-items:center; gap:8px; transition:background 0.15s;
    }
    .search-btn:hover { background:#3d30c5; }

    /* Card table */
    .card { background:#fff; border:1px solid #e8e8f4; border-radius:18px; overflow:hidden; }
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    thead th {
      padding:14px 18px; background:#f8f8fc; border-bottom:1px solid #e8e8f4;
      font-size:11px; font-weight:700; letter-spacing:0.07em; text-transform:uppercase; color:#9090b0;
      text-align:left; white-space:nowrap;
    }
    tbody td { padding:14px 18px; border-bottom:1px solid #f4f4f8; font-size:13.5px; vertical-align:middle; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:#fbfbfe; }

    .avatar-initials {
      width:36px; height:36px; border-radius:10px; display:flex; align-items:center;
      justify-content:center; font-family:'Syne',sans-serif; font-weight:700;
      font-size:12px; color:#fff; flex-shrink:0;
    }
    .cell-entreprise { display:flex; align-items:center; gap:10px; }
    .cell-title { font-weight:600; color:#1a1550; }
    .cell-sub { font-size:12px; color:#9090b0; margin-top:2px; }

    /* Status badges */
    .badge {
      display:inline-flex; align-items:center; gap:5px;
      padding:4px 12px; border-radius:99px; font-size:12px; font-weight:600;
    }
    .badge-active   { background:#d1fae5; color:#065f46; }
    .badge-warn     { background:#fef3c7; color:#92400e; }
    .badge-rejected { background:#fee2e2; color:#991b1b; }
    .badge-closed   { background:#f3f4f6; color:#6b7280; }
    .badge-suspended{ background:#fff7ed; color:#c2410c; }

    /* Action buttons */
    .action-group { display:flex; gap:6px; align-items:center; }
    .btn-icon {
      width:32px; height:32px; border-radius:9px; border:none; cursor:pointer;
      display:flex; align-items:center; justify-content:center; font-size:16px;
      transition:all 0.15s;
    }
    .btn-icon.validate  { background:#d1fae5; color:#16a34a; }
    .btn-icon.validate:hover { background:#a7f3d0; }
    .btn-icon.reject    { background:#fee2e2; color:#dc2626; }
    .btn-icon.reject:hover  { background:#fecaca; }
    .btn-icon.warn      { background:#fef3c7; color:#d97706; }
    .btn-icon.warn:hover    { background:#fde68a; }
    .btn-icon.view      { background:#f4f5fa; color:#7070a0; }
    .btn-icon.view:hover    { background:#eeeeff; color:#5040e8; }

    /* Modal overlay */
    .modal-overlay {
      display:none; position:fixed; inset:0; background:rgba(26,21,80,0.45);
      z-index:999; align-items:center; justify-content:center; padding:1rem;
    }
    .modal-overlay.open { display:flex; }
    .modal {
      background:#fff; border-radius:20px; width:100%; max-width:480px;
      padding:2rem; box-shadow:0 20px 60px rgba(80,64,232,0.15);
      animation:modalIn 0.2s ease;
    }
    @keyframes modalIn { from { opacity:0; transform:scale(0.95) translateY(10px); } to { opacity:1; transform:none; } }
    .modal-title { font-family:'Syne',sans-serif; font-weight:800; font-size:18px; color:#1a1550; margin-bottom:6px; }
    .modal-desc { font-size:13.5px; color:#9090b0; margin-bottom:1.4rem; }
    .modal-label { font-size:12.5px; font-weight:700; color:#5040e8; margin-bottom:6px; display:block; }
    .modal-textarea {
      width:100%; min-height:110px; border:1.5px solid #e8e8f4; border-radius:12px;
      padding:12px 16px; font-family:inherit; font-size:13.5px; color:#1a1550;
      resize:vertical; outline:none; transition:border-color 0.15s;
    }
    .modal-textarea:focus { border-color:#5040e8; }
    .modal-actions { display:flex; gap:10px; margin-top:1.2rem; justify-content:flex-end; }
    .btn-cancel {
      padding:10px 20px; border:1.5px solid #e8e8f4; border-radius:12px;
      background:#fff; color:#7070a0; font-size:13.5px; font-weight:600;
      cursor:pointer; font-family:inherit; transition:all 0.15s;
    }
    .btn-cancel:hover { background:#f4f4f8; }
    .btn-submit {
      padding:10px 24px; border:none; border-radius:12px;
      font-size:13.5px; font-weight:700; cursor:pointer; font-family:inherit;
      display:flex; align-items:center; gap:8px; transition:all 0.15s;
    }
    .btn-submit.danger  { background:#dc2626; color:#fff; }
    .btn-submit.danger:hover  { background:#b91c1c; }
    .btn-submit.warning { background:#f59e0b; color:#fff; }
    .btn-submit.warning:hover { background:#d97706; }

    /* Empty state */
    .empty-state { padding:3rem 2rem; text-align:center; }
    .empty-state i { font-size:48px; color:#c0c0d8; margin-bottom:1rem; display:block; }
    .empty-state p { color:#9090b0; font-size:14px; }

    /* Pagination */
    .pagination-wrap { padding:1rem 1.4rem; display:flex; justify-content:center; }
    .pagination-wrap nav { display:flex; gap:6px; }
  </style>
</head>
<body>
@include('admin.partials.sidebar')

<div class="main">
  <!-- Header -->
  <div class="page-header">
    <div>
      <div class="page-title"><i class="ti ti-briefcase" style="color:#5040e8;margin-right:8px"></i>Modération des Offres</div>
      <div class="page-sub">Validez, rejetez ou émettez des avertissements sur les offres publiées</div>
    </div>
  </div>

  @if(session('success'))
    <div class="flash success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="flash error"><i class="ti ti-alert-circle"></i> {{ session('error') }}</div>
  @endif

  <!-- Tabs statut -->
  <div class="tabs">
    @php
      $tabDefs = [
        'active'        => ['label' => 'Actives',        'count' => $counts['active'],        'icon' => 'ti-circle-check'],
        'avertissement' => ['label' => 'Avertissement',  'count' => $counts['avertissement'], 'icon' => 'ti-alert-triangle'],
        'rejetée'       => ['label' => 'Rejetées',       'count' => $counts['rejetée'],       'icon' => 'ti-circle-x'],
        'suspendue'     => ['label' => 'Suspendues',     'count' => $counts['suspendue'],     'icon' => 'ti-ban'],
        'clôturée'      => ['label' => 'Clôturées',      'count' => $counts['clôturée'],      'icon' => 'ti-lock'],
        'toutes'        => ['label' => 'Toutes',         'count' => array_sum($counts),       'icon' => 'ti-list'],
      ];
    @endphp
    @foreach($tabDefs as $key => $tab)
      <a href="{{ route('admin.offres', ['statut' => $key, 'search' => $search]) }}"
         class="tab {{ $statut === $key ? 'active' : '' }}">
        <i class="ti {{ $tab['icon'] }}"></i>
        {{ $tab['label'] }}
        <span class="n">{{ $tab['count'] }}</span>
      </a>
    @endforeach
  </div>

  <!-- Search -->
  <form method="GET" action="{{ route('admin.offres') }}">
    <input type="hidden" name="statut" value="{{ $statut }}" />
    <div class="search-bar">
      <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par titre ou entreprise..." class="search-input" />
      <button type="submit" class="search-btn"><i class="ti ti-search"></i> Rechercher</button>
    </div>
  </form>

  <!-- Table -->
  <div class="card">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Offre / Entreprise</th>
            <th>Type</th>
            <th>Lieu</th>
            <th>Publiée le</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($offres as $offre)
            @php
              $initials = strtoupper(substr($offre->entreprise->nom_entreprise ?? 'EP', 0, 2));
              $grads = ['linear-gradient(135deg,#ef4444,#f97316)','linear-gradient(135deg,#6366f1,#8b5cf6)','linear-gradient(135deg,#10b981,#0ea5e9)','linear-gradient(135deg,#f59e0b,#f97316)','linear-gradient(135deg,#ec4899,#a855f7)'];
              $grad = $grads[$offre->id_offre % count($grads)];
            @endphp
            <tr>
              <td>
                <div class="cell-entreprise">
                  <div class="avatar-initials" style="background:{{ $grad }}">{{ $initials }}</div>
                  <div>
                    <div class="cell-title">{{ $offre->titre_offre }}</div>
                    <div class="cell-sub">{{ $offre->entreprise->nom_entreprise ?? '—' }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $offre->type_contrat ?? '—' }}</td>
              <td>{{ $offre->ville_poste }}</td>
              <td>{{ $offre->date_publication ? $offre->date_publication->format('d/m/Y') : '—' }}</td>
              <td>
                @if($offre->statut_offre === 'active')
                  <span class="badge badge-active"><i class="ti ti-circle-check"></i> Active</span>
                @elseif($offre->statut_offre === 'avertissement')
                  <span class="badge badge-warn"><i class="ti ti-alert-triangle"></i> Avertissement</span>
                @elseif($offre->statut_offre === 'rejetée')
                  <span class="badge badge-rejected"><i class="ti ti-circle-x"></i> Rejetée</span>
                @elseif($offre->statut_offre === 'suspendue')
                  <span class="badge badge-suspended"><i class="ti ti-ban"></i> Suspendue</span>
                @else
                  <span class="badge badge-closed"><i class="ti ti-lock"></i> {{ ucfirst($offre->statut_offre) }}</span>
                @endif
              </td>
              <td>
                <div class="action-group">
                  {{-- Valider --}}
                  @if($offre->statut_offre !== 'active')
                    <form method="POST" action="{{ route('admin.offres.valider', $offre->id_offre) }}" style="display:inline">
                      @csrf
                      <button type="submit" class="btn-icon validate" title="Valider"><i class="ti ti-circle-check"></i></button>
                    </form>
                  @endif
                  {{-- Rejeter --}}
                  @if($offre->statut_offre !== 'rejetée')
                    <button class="btn-icon reject" title="Rejeter"
                            onclick="openModal('modal-rejeter-{{ $offre->id_offre }}')">
                      <i class="ti ti-circle-x"></i>
                    </button>
                  @endif
                  {{-- Avertir --}}
                  @if($offre->statut_offre !== 'avertissement')
                    <button class="btn-icon warn" title="Avertissement"
                            onclick="openModal('modal-avertir-{{ $offre->id_offre }}')">
                      <i class="ti ti-alert-triangle"></i>
                    </button>
                  @endif
                </div>

                {{-- Motif affiché si présent --}}
                @if($offre->motif_moderation)
                  <div style="font-size:11px;color:#9090b0;margin-top:4px;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"
                       title="{{ $offre->motif_moderation }}">
                    {{ Str::limit($offre->motif_moderation, 40) }}
                  </div>
                @endif
              </td>
            </tr>

            {{-- Modal Rejeter --}}
            <div id="modal-rejeter-{{ $offre->id_offre }}" class="modal-overlay" onclick="closeModalOnOverlay(event,this)">
              <div class="modal">
                <div class="modal-title"><i class="ti ti-circle-x" style="color:#dc2626"></i> Rejeter l'offre</div>
                <div class="modal-desc">« {{ $offre->titre_offre }} » — {{ $offre->entreprise->nom_entreprise ?? '' }}</div>
                <form method="POST" action="{{ route('admin.offres.rejeter', $offre->id_offre) }}">
                  @csrf
                  <label class="modal-label">Motif du rejet *</label>
                  <textarea name="motif" class="modal-textarea" placeholder="Expliquez pourquoi cette offre est rejetée..." required minlength="10"></textarea>
                  <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('modal-rejeter-{{ $offre->id_offre }}')">Annuler</button>
                    <button type="submit" class="btn-submit danger"><i class="ti ti-circle-x"></i> Confirmer le rejet</button>
                  </div>
                </form>
              </div>
            </div>

            {{-- Modal Avertir --}}
            <div id="modal-avertir-{{ $offre->id_offre }}" class="modal-overlay" onclick="closeModalOnOverlay(event,this)">
              <div class="modal">
                <div class="modal-title"><i class="ti ti-alert-triangle" style="color:#f59e0b"></i> Émettre un avertissement</div>
                <div class="modal-desc">« {{ $offre->titre_offre }} » — {{ $offre->entreprise->nom_entreprise ?? '' }}</div>
                <form method="POST" action="{{ route('admin.offres.avertir', $offre->id_offre) }}">
                  @csrf
                  <label class="modal-label">Motif de l'avertissement *</label>
                  <textarea name="motif" class="modal-textarea" placeholder="Expliquez ce qui pose problème..." required minlength="10"></textarea>
                  <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('modal-avertir-{{ $offre->id_offre }}')">Annuler</button>
                    <button type="submit" class="btn-submit warning"><i class="ti ti-alert-triangle"></i> Envoyer l'avertissement</button>
                  </div>
                </form>
              </div>
            </div>
          @empty
            <tr>
              <td colspan="6">
                <div class="empty-state">
                  <i class="ti ti-briefcase-off"></i>
                  <p>Aucune offre trouvée pour ce filtre.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($offres->hasPages())
      <div class="pagination-wrap">{{ $offres->links() }}</div>
    @endif
  </div>
</div>

<script>
  function openModal(id) { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }
  function closeModalOnOverlay(e, el) { if (e.target === el) el.classList.remove('open'); }
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(m => m.classList.remove('open'));
  });
</script>
</body>
</html>
