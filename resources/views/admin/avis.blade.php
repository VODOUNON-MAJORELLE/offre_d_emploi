<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modération des Avis — Talentlink Admin</title>
  @include('admin.partials.head')
  <style>
    .page-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:1.8rem;flex-wrap:wrap;gap:1rem; }
    .page-title { font-family:'Syne',sans-serif;font-weight:800;font-size:22px;color:#1a1550; }
    .page-sub { font-size:13px;color:#9090b0;margin-top:3px; }
    .flash { padding:12px 18px;border-radius:12px;margin-bottom:1.4rem;display:flex;align-items:center;gap:10px;font-size:13.5px;font-weight:500; }
    .flash.success { background:#d1fae5;color:#065f46;border:1px solid #a7f3d0; }
    .flash.error   { background:#fee2e2;color:#991b1b;border:1px solid #fecaca; }
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
    .avatar-initials { width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:12px;color:#fff;flex-shrink:0; }
    .cell-main { display:flex;align-items:center;gap:10px; }
    .cell-title { font-weight:600;color:#1a1550; }
    .cell-sub { font-size:12px;color:#9090b0;margin-top:2px; }
    .stars { display:flex;gap:2px;color:#f59e0b; }
    .stars i { font-size:14px; }
    .stars-empty { color:#e8e8f4; }
    .comment-text { font-size:13px;color:#334155;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
    .badge { display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:600; }
    .badge-pub  { background:#d1fae5;color:#065f46; }
    .badge-warn { background:#fef3c7;color:#92400e; }
    .badge-del  { background:#fee2e2;color:#991b1b; }
    .action-group { display:flex;gap:6px;align-items:center; }
    .btn-icon { width:32px;height:32px;border-radius:9px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;transition:all 0.15s; }
    .btn-icon.restore { background:#d1fae5;color:#16a34a; }
    .btn-icon.restore:hover { background:#a7f3d0; }
    .btn-icon.del     { background:#fee2e2;color:#dc2626; }
    .btn-icon.del:hover     { background:#fecaca; }
    .btn-icon.warn    { background:#fef3c7;color:#d97706; }
    .btn-icon.warn:hover    { background:#fde68a; }
    .modal-overlay { display:none;position:fixed;inset:0;background:rgba(26,21,80,0.45);z-index:999;align-items:center;justify-content:center;padding:1rem; }
    .modal-overlay.open { display:flex; }
    .modal { background:#fff;border-radius:20px;width:100%;max-width:480px;padding:2rem;box-shadow:0 20px 60px rgba(80,64,232,0.15);animation:modalIn 0.2s ease; }
    @keyframes modalIn { from{opacity:0;transform:scale(0.95) translateY(10px)} to{opacity:1;transform:none} }
    .modal-title { font-family:'Syne',sans-serif;font-weight:800;font-size:18px;color:#1a1550;margin-bottom:6px; }
    .modal-desc { font-size:13.5px;color:#9090b0;margin-bottom:1.4rem; }
    .modal-excerpt { background:#f8f8fc;border-radius:10px;padding:12px 14px;font-size:13px;color:#334155;font-style:italic;margin-bottom:1.2rem;border-left:3px solid #e8e8f4; }
    .modal-label { font-size:12.5px;font-weight:700;color:#5040e8;margin-bottom:6px;display:block; }
    .modal-textarea { width:100%;min-height:110px;border:1.5px solid #e8e8f4;border-radius:12px;padding:12px 16px;font-family:inherit;font-size:13.5px;color:#1a1550;resize:vertical;outline:none;transition:border-color 0.15s; }
    .modal-textarea:focus { border-color:#5040e8; }
    .modal-actions { display:flex;gap:10px;margin-top:1.2rem;justify-content:flex-end; }
    .btn-cancel { padding:10px 20px;border:1.5px solid #e8e8f4;border-radius:12px;background:#fff;color:#7070a0;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:all 0.15s; }
    .btn-cancel:hover { background:#f4f4f8; }
    .btn-submit { padding:10px 24px;border:none;border-radius:12px;font-size:13.5px;font-weight:700;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:8px;transition:all 0.15s; }
    .btn-submit.danger { background:#dc2626;color:#fff; }
    .btn-submit.danger:hover { background:#b91c1c; }
    .btn-submit.warning { background:#f59e0b;color:#fff; }
    .btn-submit.warning:hover { background:#d97706; }
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
      <div class="page-title"><i class="ti ti-star" style="color:#f59e0b;margin-right:8px"></i>Modération des Avis</div>
      <div class="page-sub">Gérez les avis publiés par les candidats sur les entreprises</div>
    </div>
  </div>

  @if(session('success'))
    <div class="flash success"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
  @endif

  <!-- Tabs -->
  <div class="tabs">
    @php
      $tabDefs = [
        'publié'        => ['label' => 'Publiés',       'icon' => 'ti-circle-check'],
        'avertissement' => ['label' => 'Avertissement', 'icon' => 'ti-alert-triangle'],
        'supprimé'      => ['label' => 'Supprimés',     'icon' => 'ti-trash'],
        'tous'          => ['label' => 'Tous',           'icon' => 'ti-list'],
      ];
      $allCount = array_sum($counts);
    @endphp
    @foreach($tabDefs as $key => $tab)
      @php $cnt = $key === 'tous' ? $allCount : ($counts[$key] ?? 0); @endphp
      <a href="{{ route('admin.avis', ['statut' => $key, 'search' => $search]) }}"
         class="tab {{ $statut === $key ? 'active' : '' }}">
        <i class="ti {{ $tab['icon'] }}"></i>
        {{ $tab['label'] }}
        <span class="n">{{ $cnt }}</span>
      </a>
    @endforeach
  </div>

  <!-- Search -->
  <form method="GET" action="{{ route('admin.avis') }}">
    <input type="hidden" name="statut" value="{{ $statut }}" />
    <div class="search-bar">
      <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher par candidat, entreprise ou commentaire..." class="search-input" />
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
            <th>Entreprise</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($avis_list as $avis)
            @php
              $initials = strtoupper(substr($avis->candidat->prenom ?? 'CA', 0, 1) . substr($avis->candidat->nom ?? 'ND', 0, 1));
              $grads = ['linear-gradient(135deg,#6366f1,#8b5cf6)','linear-gradient(135deg,#10b981,#0ea5e9)','linear-gradient(135deg,#f59e0b,#f97316)','linear-gradient(135deg,#ec4899,#a855f7)'];
              $grad = $grads[$avis->id_avis % count($grads)];
            @endphp
            <tr>
              <td>
                <div class="cell-main">
                  <div class="avatar-initials" style="background:{{ $grad }}">{{ $initials }}</div>
                  <div>
                    <div class="cell-title">{{ $avis->candidat->prenom ?? '—' }} {{ $avis->candidat->nom ?? '' }}</div>
                    <div class="cell-sub">{{ $avis->candidat->email ?? '' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="cell-title">{{ $avis->entreprise->nom_entreprise ?? '—' }}</div>
                <div class="cell-sub">{{ $avis->entreprise->secteur_activite ?? '' }}</div>
              </td>
              <td>
                <div class="stars">
                  @for($s = 1; $s <= 5; $s++)
                    <i class="ti ti-star-filled {{ $s <= $avis->note_globale ? '' : 'stars-empty' }}"></i>
                  @endfor
                </div>
                <div style="font-size:11px;color:#9090b0;margin-top:2px">{{ $avis->note_globale }}/5</div>
              </td>
              <td>
                @if($avis->commentaire)
                  <div class="comment-text" title="{{ $avis->commentaire }}">{{ $avis->commentaire }}</div>
                @else
                  <span style="color:#c0c0d8;font-style:italic">Aucun commentaire</span>
                @endif
                @if($avis->motif_moderation)
                  <div style="font-size:11px;color:#dc2626;margin-top:4px">⚑ {{ Str::limit($avis->motif_moderation, 45) }}</div>
                @endif
              </td>
              <td style="white-space:nowrap">{{ $avis->date_avis ? $avis->date_avis->format('d/m/Y') : '—' }}</td>
              <td>
                @if($avis->statut_avis === 'publié')
                  <span class="badge badge-pub"><i class="ti ti-circle-check"></i> Publié</span>
                @elseif($avis->statut_avis === 'avertissement')
                  <span class="badge badge-warn"><i class="ti ti-alert-triangle"></i> Avertissement</span>
                @else
                  <span class="badge badge-del"><i class="ti ti-trash"></i> Supprimé</span>
                @endif
              </td>
              <td>
                <div class="action-group">
                  @if($avis->statut_avis !== 'publié')
                    <form method="POST" action="{{ route('admin.avis.restaurer', $avis->id_avis) }}" style="display:inline">
                      @csrf
                      <button type="submit" class="btn-icon restore" title="Restaurer"><i class="ti ti-refresh"></i></button>
                    </form>
                  @endif
                  @if($avis->statut_avis !== 'avertissement')
                    <button class="btn-icon warn" title="Avertissement" onclick="openModal('modal-avertir-avis-{{ $avis->id_avis }}')">
                      <i class="ti ti-alert-triangle"></i>
                    </button>
                  @endif
                  @if($avis->statut_avis !== 'supprimé')
                    <button class="btn-icon del" title="Supprimer" onclick="openModal('modal-suppr-avis-{{ $avis->id_avis }}')">
                      <i class="ti ti-trash"></i>
                    </button>
                  @endif
                </div>
              </td>
            </tr>

            {{-- Modal Supprimer --}}
            <div id="modal-suppr-avis-{{ $avis->id_avis }}" class="modal-overlay" onclick="closeModalOnOverlay(event,this)">
              <div class="modal">
                <div class="modal-title"><i class="ti ti-trash" style="color:#dc2626"></i> Supprimer l'avis</div>
                <div class="modal-desc">Avis de {{ $avis->candidat->prenom ?? '' }} {{ $avis->candidat->nom ?? '' }} sur {{ $avis->entreprise->nom_entreprise ?? '' }}</div>
                @if($avis->commentaire)
                  <div class="modal-excerpt">« {{ Str::limit($avis->commentaire, 150) }} »</div>
                @endif
                <form method="POST" action="{{ route('admin.avis.supprimer', $avis->id_avis) }}">
                  @csrf
                  <label class="modal-label">Motif de la suppression *</label>
                  <textarea name="motif" class="modal-textarea" placeholder="Expliquez pourquoi cet avis est inapproprié..." required minlength="10"></textarea>
                  <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('modal-suppr-avis-{{ $avis->id_avis }}')">Annuler</button>
                    <button type="submit" class="btn-submit danger"><i class="ti ti-trash"></i> Supprimer</button>
                  </div>
                </form>
              </div>
            </div>

            {{-- Modal Avertir --}}
            <div id="modal-avertir-avis-{{ $avis->id_avis }}" class="modal-overlay" onclick="closeModalOnOverlay(event,this)">
              <div class="modal">
                <div class="modal-title"><i class="ti ti-alert-triangle" style="color:#f59e0b"></i> Avertissement</div>
                <div class="modal-desc">Avis de {{ $avis->candidat->prenom ?? '' }} {{ $avis->candidat->nom ?? '' }}</div>
                <form method="POST" action="{{ route('admin.avis.avertir', $avis->id_avis) }}">
                  @csrf
                  <label class="modal-label">Motif de l'avertissement *</label>
                  <textarea name="motif" class="modal-textarea" placeholder="Expliquez ce qui pose problème dans cet avis..." required minlength="10"></textarea>
                  <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('modal-avertir-avis-{{ $avis->id_avis }}')">Annuler</button>
                    <button type="submit" class="btn-submit warning"><i class="ti ti-alert-triangle"></i> Envoyer l'avertissement</button>
                  </div>
                </form>
              </div>
            </div>
          @empty
            <tr>
              <td colspan="7">
                <div class="empty-state">
                  <i class="ti ti-star-off"></i>
                  <p>Aucun avis trouvé pour ce filtre.</p>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($avis_list->hasPages())
      <div class="pagination-wrap">{{ $avis_list->links() }}</div>
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
