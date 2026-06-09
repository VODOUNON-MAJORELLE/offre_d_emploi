<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Dashboard Administrateur</title>
  @include('admin.partials.head')
  <style>
    /* ── HEADER ── */
    .page-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 1.8rem; flex-wrap: wrap; gap: 1rem;
    }
    .header-left { display: flex; align-items: center; gap: 16px; }
    .admin-avatar {
      width: 52px; height: 52px; border-radius: 14px;
      background: linear-gradient(135deg, #5040e8, #6c5ce7);
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; color: #fff; flex-shrink: 0;
    }
    .header-titles h1 {
      font-family: 'Syne', sans-serif; font-weight: 800;
      font-size: 22px; color: #1a1550; margin-bottom: 2px;
    }
    .header-titles p { font-size: 13px; color: #9090b0; }
    .status-pill {
      display: flex; align-items: center; gap: 8px;
      padding: 9px 18px; background: #fff;
      border: 1px solid #e4e4f0; border-radius: 12px;
      font-size: 13.5px; font-weight: 500; color: #1a1550;
    }
    .status-pill i { color: #5040e8; font-size: 15px; }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; background: #22c55e; }

    /* ── GRID ── */
    .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 14px; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }

    /* ── CARD BASE ── */
    .card {
      background: #fff; border: 1px solid #e8e8f4;
      border-radius: 18px; padding: 1.4rem;
    }

    /* ── STAT CARDS ── */
    .stat-card { display: flex; flex-direction: column; gap: 6px; position: relative; }
    .stat-label {
      font-size: 10.5px; font-weight: 600; letter-spacing: 0.08em;
      text-transform: uppercase; color: #9090b0;
      display: flex; justify-content: space-between; align-items: center;
    }
    .stat-icon {
      width: 32px; height: 32px; border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
      font-size: 16px;
    }
    .stat-icon.blue   { background: #eef2ff; color: #5040e8; }
    .stat-icon.green  { background: #eafaf1; color: #16a34a; }
    .stat-icon.purple { background: #f3eeff; color: #7c3aed; }
    .stat-icon.red    { background: #fff2f2; color: #dc2626; }
    .stat-num {
      font-family: 'Syne', sans-serif; font-weight: 800;
      font-size: 32px; color: #1a1550; line-height: 1;
    }
    .stat-sub { font-size: 12px; color: #9090b0; }
    .stat-sub.alert { color: #dc2626; font-weight: 600; }
    .stat-bar { height: 3px; border-radius: 3px; margin-top: 4px; }
    .stat-bar.blue   { background: #5040e8; }
    .stat-bar.green  { background: #22c55e; }
    .stat-bar.purple { background: #7c3aed; }
    .stat-bar.red    { background: #dc2626; }

    /* ── CHART CARDS ── */
    .chart-card { display: flex; flex-direction: column; gap: 4px; }
    .chart-title {
      font-family: 'Syne', sans-serif; font-weight: 700;
      font-size: 15px; color: #1a1550;
      display: flex; align-items: center; gap: 8px;
    }
    .chart-title i { font-size: 16px; color: #5040e8; }
    .chart-sub { font-size: 12.5px; color: #9090b0; margin-bottom: 0.8rem; }
    .chart-wrap { position: relative; }
    canvas { width: 100% !important; }
    .chart-legend { display: flex; gap: 16px; margin-top: 10px; }
    .legend-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #7070a0; }
    .legend-dot { width: 8px; height: 8px; border-radius: 50%; }

    /* ── MODERATION ── */
    .section-title {
      font-family: 'Syne', sans-serif; font-weight: 700;
      font-size: 15px; color: #1a1550;
      display: flex; align-items: center; gap: 8px;
      margin-bottom: 1.1rem;
    }
    .section-title i { font-size: 16px; color: #f59e0b; }
    .count-badge {
      width: 22px; height: 22px; border-radius: 50%;
      background: #f59e0b; color: #fff;
      font-size: 11px; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
    }
    .mod-list { display: flex; flex-direction: column; gap: 2px; }
    .mod-item {
      display: flex; align-items: center; gap: 14px;
      padding: 11px 10px; border-radius: 12px;
      transition: background 0.12s; cursor: pointer;
    }
    .mod-item:hover { background: #f8f8fc; }
    .mod-avatar {
      width: 38px; height: 38px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 13px; color: #fff;
      flex-shrink: 0;
    }
    .mod-info { flex: 1; min-width: 0; }
    .mod-title { font-weight: 600; font-size: 13.5px; color: #1a1550; }
    .mod-sub { font-size: 12px; color: #9090b0; margin-top: 1px; }
    .mod-actions { display: flex; gap: 8px; align-items: center; }
    .action-btn {
      width: 30px; height: 30px; border-radius: 50%;
      border: none; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      font-size: 16px; transition: background 0.15s;
      text-decoration: none;
    }
    .action-btn.approve { background: #eafaf1; color: #16a34a; }
    .action-btn.approve:hover { background: #d4f4e4; }
    .action-btn.reject  { background: #fff2f2; color: #dc2626; }
    .action-btn.reject:hover  { background: #fde0e0; }
    .action-btn.view    { background: #f4f5fa; color: #7070a0; }
    .action-btn.view:hover    { background: #eeeeff; color: #5040e8; }

    /* ── SUSPECTS ── */
    .suspects-section { margin-bottom: 14px; }

    /* ── STATS GLOBALES ── */
    .global-stats-card {
      background: linear-gradient(135deg, #eef0ff, #e8eeff);
      border: 1px solid #d8daf4;
      border-radius: 18px; padding: 1.4rem;
    }
    .global-stats-card .section-title i { color: #5040e8; }
    .stats-mini-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .mini-stat { background: #fff; border-radius: 12px; padding: 1rem; }
    .mini-stat-num {
      font-family: 'Syne', sans-serif; font-weight: 800;
      font-size: 22px; color: #5040e8; margin-bottom: 3px;
    }
    .mini-stat-label { font-size: 12px; color: #9090b0; }

    /* ── RIGHT COLUMN ── */
    .right-col { display: flex; flex-direction: column; gap: 14px; }

    @media (max-width: 1100px) {
      .grid-4 { grid-template-columns: repeat(2, 1fr); }
      .grid-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 650px) {
      .grid-4 { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>

@include('admin.partials.sidebar')

<!-- MAIN CONTAINER -->
<div class="main">
  <!-- HEADER -->
  <div class="page-header">
    <div class="header-left">
      <div class="admin-avatar"><i class="ti ti-shield-check"></i></div>
      <div class="header-titles">
        <h1>Dashboard Administrateur</h1>
        <p>Vue globale de la plateforme Talentlink</p>
      </div>
    </div>
    <div class="status-pill">
      <i class="ti ti-bolt"></i>
      Tous systèmes opérationnels
      <span class="status-dot"></span>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div class="grid-4">

    <div class="card stat-card">
      <div class="stat-label">
        Entreprises actives
        <div class="stat-icon blue"><i class="ti ti-building"></i></div>
      </div>
      <div class="stat-num">{{ number_format($stats['entreprises'] ?? 0, 0, ',', ' ') }}</div>
      <div class="stat-sub">+{{ $stats['entreprises_recent'] ?? 0 }} ce mois</div>
      <div class="stat-bar blue"></div>
    </div>

    <div class="card stat-card">
      <div class="stat-label">
        Candidats inscrits
        <div class="stat-icon green"><i class="ti ti-users"></i></div>
      </div>
      <div class="stat-num">{{ number_format($stats['candidats'] ?? 0, 0, ',', ' ') }}</div>
      <div class="stat-sub">+{{ $stats['candidats_recent'] ?? 0 }} cette semaine</div>
      <div class="stat-bar green"></div>
    </div>

    <div class="card stat-card">
      <div class="stat-label">
        Offres publiées
        <div class="stat-icon purple"><i class="ti ti-briefcase"></i></div>
      </div>
      <div class="stat-num">{{ number_format($stats['offres'] ?? 0, 0, ',', ' ') }}</div>
      <div class="stat-sub">+{{ $stats['offres_recent'] ?? 0 }} ce mois</div>
      <div class="stat-bar purple"></div>
    </div>

    <div class="card stat-card">
      <div class="stat-label">
        À modérer
        <div class="stat-icon red"><i class="ti ti-alert-triangle"></i></div>
      </div>
      <div class="stat-num">{{ count($recent_offres) }}</div>
      <div class="stat-sub alert">Requiert une action</div>
      <div class="stat-bar red"></div>
    </div>

  </div>

  <!-- CHARTS ROW -->
  <div class="grid-2">

    <!-- Line chart: Croissance -->
    <div class="card chart-card">
      <div class="chart-title"><i class="ti ti-trending-up"></i> Croissance de la plateforme</div>
      <div class="chart-sub">Évolution des inscriptions et des offres</div>
      <div class="chart-wrap">
        <canvas id="lineChart" height="180"></canvas>
      </div>
      <div class="chart-legend">
        <div class="legend-item"><span class="legend-dot" style="background:#5040e8"></span>Candidats</div>
        <div class="legend-item"><span class="legend-dot" style="background:#a78bfa"></span>Offres</div>
      </div>
    </div>

    <!-- Bar chart: Candidatures -->
    <div class="card chart-card">
      <div class="chart-title">Candidatures mensuelles</div>
      <div class="chart-sub">Volume de candidatures reçues par mois</div>
      <div class="chart-wrap">
        <canvas id="barChart" height="180"></canvas>
      </div>
    </div>

  </div>

  <!-- BOTTOM ROW -->
  <div class="grid-2">

    <!-- LEFT: Modération -->
    <div class="card">
      <div class="section-title">
        <i class="ti ti-alert-triangle"></i>
        Offres récentes à valider
        <span class="count-badge">{{ count($recent_offres) }}</span>
      </div>
      <div class="mod-list" id="mod-list">
        @forelse($recent_offres as $offre)
          @php
            $initials = substr($offre->entreprise->nom_entreprise ?? 'EP', 0, 2);
            $gradients = [
              'linear-gradient(135deg,#ef4444,#f97316)',
              'linear-gradient(135deg,#6366f1,#8b5cf6)',
              'linear-gradient(135deg,#10b981,#0ea5e9)',
              'linear-gradient(135deg,#f59e0b,#f97316)',
              'linear-gradient(135deg,#ec4899,#a855f7)',
            ];
            $grad = $gradients[$loop->index % count($gradients)];
          @endphp
          <div class="mod-item">
            <div class="mod-avatar" style="background:{{ $grad }}">{{ $initials }}</div>
            <div class="mod-info">
              <div class="mod-title">{{ $offre->titre_offre }}</div>
              <div class="mod-sub">{{ $offre->entreprise->nom_entreprise ?? 'N/A' }} · {{ $offre->date_publication ? $offre->date_publication->format('Y-m-d') : 'Récemment' }}</div>
            </div>
            <div class="mod-actions">
              <button class="action-btn approve" title="Approuver" onclick="moderateItem(this,'approve')"><i class="ti ti-circle-check"></i></button>
              <button class="action-btn reject"  title="Rejeter"   onclick="moderateItem(this,'reject')"><i class="ti ti-circle-x"></i></button>
              <a href="{{ route('admin.offres') }}" class="action-btn view" title="Voir"><i class="ti ti-eye"></i></a>
            </div>
          </div>
        @empty
          <div style="padding: 24px; text-align: center; color: #9090b0; font-size: 13.5px;">Aucune offre récente</div>
        @endforelse
      </div>
    </div>

    <!-- RIGHT: Suspects + Stats globales -->
    <div class="right-col">

      <!-- Candidats récents -->
      <div class="card suspects-section">
        <div class="section-title" style="margin-bottom:0.8rem">
          <i class="ti ti-user-plus" style="color:#5040e8"></i>
          Candidats récents
          <span class="count-badge" style="background:#5040e8">{{ count($recent_candidats) }}</span>
        </div>
        <div class="mod-list">
          @forelse($recent_candidats as $c)
            @php
              $initials = strtoupper(substr($c->prenom, 0, 1) . substr($c->nom, 0, 1));
              $grads = ['linear-gradient(135deg,#6366f1,#8b5cf6)','linear-gradient(135deg,#10b981,#0ea5e9)','linear-gradient(135deg,#f59e0b,#ec4899)','linear-gradient(135deg,#5040e8,#a78bfa)','linear-gradient(135deg,#ef4444,#f97316)'];
              $grad = $grads[$loop->index % count($grads)];
            @endphp
            <div class="mod-item">
              <div class="mod-avatar" style="background:{{ $grad }}">{{ $initials }}</div>
              <div class="mod-info">
                <div class="mod-title">{{ $c->prenom }} {{ $c->nom }}</div>
                <div class="mod-sub">{{ $c->email }} · {{ $c->ville ?? '' }}</div>
              </div>
              <div style="font-size:11px;color:#9090b0;white-space:nowrap">
                {{ $c->date_inscription ? $c->date_inscription->diffForHumans() : '' }}
              </div>
            </div>
          @empty
            <div style="padding: 24px; text-align: center; color: #9090b0; font-size: 13.5px;">Aucun candidat récent</div>
          @endforelse
        </div>
        <a href="{{ route('admin.candidats') }}" style="display:block;text-align:center;padding:10px;font-size:13px;color:#5040e8;font-weight:600;text-decoration:none;border-top:1px solid #f0f0f8;margin-top:4px">
          Voir tous les candidats →
        </a>
      </div>

      <!-- Avis récents -->
      <div class="global-stats-card">
        <div class="section-title" style="margin-bottom:1rem">
          <i class="ti ti-message-2" style="color:#5040e8"></i>
          Avis récents
          <span class="count-badge">{{ count($recent_avis) }}</span>
        </div>
        <div class="mod-list">
          @forelse($recent_avis as $avis)
            @php
              $initials = substr($avis->candidat->prenom ?? 'C', 0, 1) . substr($avis->candidat->nom ?? 'A', 0, 1);
              $gradients = [
                'linear-gradient(135deg,#10b981,#0ea5e9)',
                'linear-gradient(135deg,#6366f1,#8b5cf6)',
                'linear-gradient(135deg,#f59e0b,#f97316)',
              ];
              $grad = $gradients[$loop->index % count($gradients)];
            @endphp
            <div class="mod-item">
              <div class="mod-avatar" style="background:{{ $grad }}">{{ $initials }}</div>
              <div class="mod-info">
                <div class="mod-title">{{ $avis->candidat->prenom ?? '' }} {{ $avis->candidat->nom ?? '' }}</div>
                <div class="mod-sub">
                  {{ $avis->entreprise->nom_entreprise ?? 'N/A' }} · 
                  <span style="color:#f59e0b">{{ str_repeat('★', $avis->note_globale ?? 0) }}{{ str_repeat('☆', 5 - ($avis->note_globale ?? 0)) }}</span>
                </div>
                <div style="font-size:12px;color:#7070a0;margin-top:2px;line-height:1.4">
                  {{ Str::limit($avis->commentaire ?? '', 80) }}
                </div>
              </div>
              <div class="mod-actions">
                <a href="{{ route('admin.avis', ['search' => $avis->candidat->nom ?? '']) }}" class="action-btn view" title="Voir détails">
                  <i class="ti ti-eye"></i>
                </a>
              </div>
            </div>
          @empty
            <div style="padding: 24px; text-align: center; color: #9090b0; font-size: 13.5px;">Aucun avis récent</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
  const months = @json($chart_months);

  // Line chart — Croissance
  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: months,
      datasets: [
        {
          label: 'Candidats',
          data: @json($candidat_counts),
          borderColor: '#5040e8',
          backgroundColor: 'rgba(80,64,232,0.08)',
          borderWidth: 2.5,
          pointRadius: 4,
          pointBackgroundColor: '#5040e8',
          tension: 0.4,
          fill: true,
        },
        {
          label: 'Offres',
          data: @json($offre_counts),
          borderColor: '#a78bfa',
          backgroundColor: 'rgba(167,139,250,0.06)',
          borderWidth: 2.5,
          pointRadius: 4,
          pointBackgroundColor: '#a78bfa',
          tension: 0.4,
          fill: true,
        }
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#b0b0c8' } },
        y: {
          min: 0,
          ticks: { font: { size: 11 }, color: '#b0b0c8' },
          grid: { color: '#f0f0f8' }
        }
      }
    }
  });

  // Bar chart — Candidatures
  new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Candidatures',
        data: @json($candidature_counts),
        backgroundColor: (ctx) => {
          const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
          gradient.addColorStop(0, '#5040e8');
          gradient.addColorStop(1, '#a78bfa');
          return gradient;
        },
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#b0b0c8' } },
        y: {
          min: 0,
          ticks: { font: { size: 11 }, color: '#b0b0c8' },
          grid: { color: '#f0f0f8' }
        }
      }
    }
  });

  // Moderation actions
  let modCount = {{ count($recent_offres) }};

  function moderateItem(btn, action) {
    const item = btn.closest('.mod-item');
    item.style.transition = 'opacity 0.3s, transform 0.3s';
    item.style.opacity = '0';
    item.style.transform = 'translateX(20px)';
    setTimeout(() => {
      item.remove();
      modCount = Math.max(0, modCount - 1);
      document.querySelector('.count-badge').textContent = modCount;
      const statMod = document.querySelectorAll('.stat-num')[3];
      if (statMod) {
        statMod.textContent = modCount;
      }
    }, 300);
  }

  // Suspect actions
  function blockSuspect(id) {
    const el = document.getElementById(id);
    el.style.transition = 'opacity 0.3s';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 300);
  }

  function ignoreSuspect(id) {
    const el = document.getElementById(id);
    el.style.transition = 'opacity 0.3s';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 300);
  }
</script>
</body>
</html>
