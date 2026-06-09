<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Feed</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f0f1f8;
      min-height: 100vh;
      color: #1a1550;
    }

    /* ── HERO BANNER ── */
    .hero-banner {
      background: linear-gradient(135deg, #3a2fa0 0%, #5040e8 40%, #1a6e8a 100%);
      padding: 2.4rem 2.5rem 2rem;
    }

    .hero-banner h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 800; font-size: 24px; color: #fff;
      margin-bottom: 1.2rem;
    }

    .search-row {
      display: flex; gap: 10px; max-width: 820px;
    }

    .search-box {
      flex: 1; display: flex; align-items: center; gap: 10px;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.25);
      border-radius: 12px; padding: 10px 16px;
      backdrop-filter: blur(6px);
    }
    .search-box i { color: rgba(255,255,255,0.6); font-size: 17px; flex-shrink: 0; }
    .search-box input {
      flex: 1; background: none; border: none; outline: none;
      font-size: 14px; font-family: 'DM Sans', sans-serif;
      color: #fff;
    }
    .search-box input::placeholder { color: rgba(255,255,255,0.5); }

    .filter-btn {
      display: flex; align-items: center; gap: 8px;
      padding: 10px 20px;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.25);
      border-radius: 12px; color: #fff;
      font-size: 14px; font-weight: 500;
      font-family: 'DM Sans', sans-serif; cursor: pointer;
      backdrop-filter: blur(6px); white-space: nowrap;
      transition: background 0.15s;
    }
    .filter-btn:hover { background: rgba(255,255,255,0.25); }

    /* ── CONTENT ── */
    .content { max-width: 860px; margin: 0 auto; padding: 1.8rem 1.5rem 4rem; }

    /* Results bar */
    .results-bar {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 1.2rem; flex-wrap: wrap; gap: 10px;
    }

    .results-count { font-size: 14px; color: #7070a0; }
    .results-count strong { color: #1a1550; font-weight: 700; }

    .sort-select {
      padding: 7px 14px; border: 1px solid #e4e4f0;
      border-radius: 10px; background: #fff;
      font-size: 13px; font-family: 'DM Sans', sans-serif;
      color: #7070a0; outline: none; cursor: pointer;
    }

    /* ── OFFER CARD ── */
    .offer-card {
      background: #fff; border: 1px solid #e8e8f4;
      border-radius: 18px; padding: 1.4rem 1.6rem;
      margin-bottom: 12px; position: relative;
      transition: box-shadow 0.2s, transform 0.15s;
      cursor: pointer;
    }
    .offer-card:hover {
      box-shadow: 0 8px 32px rgba(80,64,232,0.1);
      transform: translateY(-2px);
    }

    /* Bookmark */
    .bookmark-btn {
      position: absolute; top: 1.2rem; right: 1.4rem;
      background: none; border: none; cursor: pointer;
      color: #c0c0d8; font-size: 20px;
      transition: color 0.15s;
    }
    .bookmark-btn:hover { color: #5040e8; }
    .bookmark-btn.saved { color: #5040e8; }

    /* Top row */
    .card-top { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 10px; padding-right: 2rem; }

    .company-logo {
      width: 48px; height: 48px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 15px; color: #fff;
      flex-shrink: 0;
    }

    .card-info { flex: 1; }
    .card-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; color: #1a1550; margin-bottom: 2px; }
    .card-company { font-size: 13px; color: #7070a0; margin-bottom: 6px; }

    .card-meta { display: flex; gap: 14px; flex-wrap: wrap; }
    .meta-item { display: flex; align-items: center; gap: 5px; font-size: 12.5px; color: #9090b0; }
    .meta-item i { font-size: 13px; }

    /* Tags */
    .tags-row { display: flex; gap: 7px; flex-wrap: wrap; margin-bottom: 12px; }
    .tag {
      padding: 4px 12px; border-radius: 20px;
      font-size: 12px; font-weight: 500;
      background: #f0f4ff; color: #5040e8;
      border: 1px solid #dde4ff;
    }
    .tag.cdi { background: #eafaf1; color: #16a34a; border-color: #c6efd6; }
    .tag.more { background: #f4f5fa; color: #9090b0; border-color: #e4e4f0; }

    /* Bottom row */
    .card-bottom { display: flex; align-items: center; justify-content: space-between; gap: 16px; }

    .salary { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14.5px; color: #1a1550; }

    .match-row { display: flex; align-items: center; gap: 10px; }

    .match-bar-track { width: 80px; height: 5px; background: #e8e8f4; border-radius: 4px; overflow: hidden; }
    .match-bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #5040e8, #7c5cf6); }

    .match-pct {
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 13px;
      color: #5040e8; white-space: nowrap;
      display: flex; align-items: center; gap: 4px;
    }
    .match-pct i { font-size: 13px; }

    .postuler-btn {
      padding: 9px 18px;
      background: linear-gradient(135deg, #5040e8, #6c5ce7);
      color: #fff; border: none; border-radius: 10px;
      font-size: 13.5px; font-weight: 500;
      font-family: 'DM Sans', sans-serif; cursor: pointer;
      display: flex; align-items: center; gap: 6px;
      transition: opacity 0.15s, transform 0.1s;
      white-space: nowrap;
    }
    .postuler-btn:hover { opacity: 0.88; }
    .postuler-btn:active { transform: scale(0.96); }

    .divider { height: 1px; background: #f0f0f8; margin: 10px 0; }

    .empty-state { text-align: center; padding: 60px 20px; color: #9090b0; }
    .empty-state-icon { font-size: 48px; margin-bottom: 16px; }
    .empty-state-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 18px; color: #1a1550; margin-bottom: 8px; }
    .empty-state-text { font-size: 13px; }
  </style>
</head>
<body>

<!-- HERO BANNER -->
<div class="hero-banner">
  <h1>Trouvez votre prochain job</h1>
  <div class="search-row">
    <div class="search-box">
      <i class="ti ti-search"></i>
      <input type="text" placeholder="Poste, entreprise, compétence…" id="search-input" oninput="filterOffers()" />
    </div>
    <button class="filter-btn"><i class="ti ti-adjustments-horizontal"></i> Filtres</button>
  </div>
</div>

<!-- CONTENT -->
<div class="content">

  <div class="results-bar">
    <div class="results-count"><strong id="count">{{ $offres->count() }}</strong> offres correspondent à votre recherche</div>
    <select class="sort-select" onchange="sortOffers(this.value)">
      <option value="match">Meilleur match</option>
      <option value="date">Plus récent</option>
      <option value="salaire">Salaire</option>
    </select>
  </div>

  <div id="offers-list">

    @if($offres->count() > 0)
      @foreach($offres as $offre)
        @php
          $initials = substr($offre->titre_offre, 0, 1);
          $colors = [
            'linear-gradient(135deg,#6366f1,#8b5cf6)',
            'linear-gradient(135deg,#f43f5e,#ec4899)',
            'linear-gradient(135deg,#10b981,#0ea5e9)',
            'linear-gradient(135deg,#f59e0b,#f97316)',
            'linear-gradient(135deg,#6366f1,#06b6d4)',
            'linear-gradient(135deg,#06b6d4,#3b82f6)'
          ];
          $color = $colors[array_rand($colors)];
          
          $badgeClass = 'cdi';
          $badgeText = 'CDI';
          if ($offre->statut_offre === 'suspendue') {
            $badgeClass = 'more';
            $badgeText = 'Suspendue';
          } elseif ($offre->statut_offre === 'clôturée') {
            $badgeClass = 'more';
            $badgeText = 'Clôturée';
          }
          
          // Parse competences
          $competences = [];
          if ($offre->competences) {
            $competences = array_map('trim', explode(',', $offre->competences));
          }
          
          // Calculate random match percentage for demo
          $match = rand(70, 95);
          $daysAgo = $offre->date_publication->diffInDays(now());
          
          // Salary display
          $salaryDisplay = 'Non spécifié';
          if ($offre->salaire_min && $offre->salaire_max) {
            $salaryDisplay = number_format($offre->salaire_min, 0, '', ' ') . ' – ' . number_format($offre->salaire_max, 0, '', ' ') . ' ' . ($offre->devise ?? 'FCFA');
          } elseif ($offre->salaire_min) {
            $salaryDisplay = 'À partir de ' . number_format($offre->salaire_min, 0, '', ' ') . ' ' . ($offre->devise ?? 'FCFA');
          } elseif ($offre->salaire_max) {
            $salaryDisplay = 'Jusqu\'à ' . number_format($offre->salaire_max, 0, '', ' ') . ' ' . ($offre->devise ?? 'FCFA');
          }
          
          $typePoste = $offre->type_poste ?? 'CDI';
          $modeTravail = $offre->mode_travail ?? 'Sur site';
        @endphp
        <div class="offer-card" data-match="{{ $match }}" data-date="{{ $daysAgo }}" data-salaire="{{ $offre->salaire_max ?? 0 }}">
          <button class="bookmark-btn" onclick="toggleBookmark(this)"><i class="ti ti-bookmark"></i></button>
          <div class="card-top">
            <div class="company-logo" style="background:{{ $color }}">{{ $initials }}</div>
            <div class="card-info">
              <div class="card-title">{{ $offre->titre_offre }}</div>
              <div class="card-company">{{ $offre->entreprise->nom_entreprise ?? 'Entreprise' }}</div>
              <div class="card-meta">
                <span class="meta-item"><i class="ti ti-map-pin"></i> {{ $offre->ville_poste ?? 'Non spécifié' }}</span>
                <span class="meta-item"><i class="ti ti-building"></i> {{ $modeTravail }}</span>
                <span class="meta-item"><i class="ti ti-clock"></i> Il y a {{ $daysAgo > 0 ? $daysAgo . ' jour' . ($daysAgo > 1 ? 's' : '') : 'aujourd\'hui' }}</span>
              </div>
            </div>
          </div>
          <div class="tags-row">
            <span class="tag {{ $badgeClass }}">{{ $badgeText }}</span>
            @foreach(array_slice($competences, 0, 4) as $competence)
              <span class="tag">{{ $competence }}</span>
            @endforeach
            @if(count($competences) > 4)
              <span class="tag more">+{{ count($competences) - 4 }}</span>
            @endif
          </div>
          <div class="divider"></div>
          <div class="card-bottom">
            <span class="salary">{{ $salaryDisplay }}</span>
            <div class="match-row">
              <div class="match-bar-track"><div class="match-bar-fill" style="width:{{ $match }}%"></div></div>
              <span class="match-pct"><i class="ti ti-bolt"></i> {{ $match }}%</span>
            </div>
          </div>
        </div>
      @endforeach
    @else
      <div class="empty-state">
        <div class="empty-state-icon">📭</div>
        <div class="empty-state-title">Aucune offre disponible</div>
        <div class="empty-state-text">Il n'y a actuellement aucune offre d'emploi publiée.</div>
      </div>
    @endif

  </div><!-- /offers-list -->
</div><!-- /content -->

<script>
  function toggleBookmark(btn) {
    btn.classList.toggle('saved');
    const icon = btn.querySelector('i');
    icon.className = btn.classList.contains('saved') ? 'ti ti-bookmark-filled' : 'ti ti-bookmark';
  }

  function filterOffers() {
    const q = document.getElementById('search-input').value.toLowerCase();
    const cards = document.querySelectorAll('.offer-card');
    let visible = 0;
    cards.forEach(card => {
      const text = card.textContent.toLowerCase();
      const show = text.includes(q);
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    document.getElementById('count').textContent = visible;
  }

  function sortOffers(criterion) {
    const list = document.getElementById('offers-list');
    const cards = [...list.querySelectorAll('.offer-card')];
    cards.sort((a, b) => {
      if (criterion === 'match')   return +b.dataset.match   - +a.dataset.match;
      if (criterion === 'date')    return +a.dataset.date    - +b.dataset.date;
      if (criterion === 'salaire') return +b.dataset.salaire - +a.dataset.salaire;
    });
    cards.forEach(c => list.appendChild(c));
  }
</script>

</body>
</html>
