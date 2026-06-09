<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feed — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#f0f2f7;--card:#fff;--border:rgba(0,0,0,0.08);
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --accent:#5b4be8;--accent2:#7c6ff0;--accent-light:#eeedf9;
  --green:#10b981;--r:14px;--rs:8px;
}
html,body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:var(--bg);color:var(--t1);min-height:100vh}

/* NAV */
nav{background:var(--card);border-bottom:0.5px solid var(--border);padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;margin-bottom:0}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px;text-decoration:none;color:var(--t1)}
.logo-av{width:30px;height:30px;border-radius:8px;background:#6c63ff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:var(--t2);cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px}
.nav-link:hover{color:var(--t1)}
.nav-link.active{color:var(--accent);font-weight:600;border-bottom:2px solid var(--accent)}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:var(--t2);text-decoration:none}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
.user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#a855f7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:var(--t3);transition:color .12s}
.logout-btn:hover{color:var(--t1)}

/* HERO SEARCH */
.hero{
  background:linear-gradient(135deg,#2d1b8e 0%,#5b4be8 45%,#0f7b8c 100%);
  padding:36px 24px 40px;
}
.hero-inner{max-width:860px;margin:0 auto}
.hero-title{font-size:24px;font-weight:800;color:#fff;margin-bottom:18px}
.search-row{display:flex;gap:10px;align-items:center}
.search-wrap{flex:1;position:relative}
.search-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:16px;color:rgba(255,255,255,.5);pointer-events:none}
.search-input{
  width:100%;
  background:rgba(255,255,255,.15);
  border:0.5px solid rgba(255,255,255,.25);
  border-radius:99px;
  padding:12px 16px 12px 40px;
  font-size:14px;font-family:inherit;
  color:#fff;outline:none;
  transition:border-color .15s,background .15s;
  backdrop-filter:blur(8px);
}
.search-input::placeholder{color:rgba(255,255,255,.5)}
.search-input:focus{border-color:rgba(255,255,255,.6);background:rgba(255,255,255,.2)}
.filter-btn{
  display:inline-flex;align-items:center;gap:7px;
  padding:11px 18px;
  background:rgba(255,255,255,.15);
  border:0.5px solid rgba(255,255,255,.3);
  border-radius:99px;
  color:#fff;font-size:13px;font-weight:500;font-family:inherit;
  cursor:pointer;white-space:nowrap;
  backdrop-filter:blur(8px);
  transition:background .15s;
}
.filter-btn:hover{background:rgba(255,255,255,.25)}

.filter-select{
  border:0.5px solid rgba(255,255,255,.3);
  border-radius:99px;
  padding:10px 16px;
  font-size:13px;font-family:inherit;
  color:#fff;background:rgba(255,255,255,.15);
  outline:none;cursor:pointer;
  backdrop-filter:blur(8px);
  transition:border-color .15s,background .15s;
  appearance:none;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,.5)' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 12px center;
}
.filter-select:hover{border-color:rgba(255,255,255,.6);background:rgba(255,255,255,.2)}
.filter-select option{background:#fff;color:#1a1a2e}

/* BODY */
.body{max-width:860px;margin:0 auto;padding:24px 20px 60px}

/* RESULTS BAR */
.results-bar{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px}
.results-count{font-size:14px;color:var(--t1)}
.results-count span{font-weight:700}
.sort-select{border:0.5px solid var(--border);border-radius:var(--rs);padding:7px 30px 7px 12px;font-size:12px;font-family:inherit;color:var(--t2);background:var(--card);outline:none;cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center}

/* OFFRE CARD */
.offre-card{
  background:var(--card);
  border:0.5px solid var(--border);
  border-radius:var(--r);
  padding:20px 22px;
  margin-bottom:12px;
  transition:box-shadow .15s,border-color .15s;
  position:relative;
}
.offre-card:hover{box-shadow:0 6px 24px rgba(91,75,232,.1);border-color:rgba(91,75,232,.18)}

.card-top{display:flex;align-items:flex-start;gap:14px;margin-bottom:12px}
.co-av{width:46px;height:46px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;flex-shrink:0}
.card-info{flex:1;min-width:0}
.card-title{font-size:16px;font-weight:700;color:var(--t1);margin-bottom:2px}
.card-company{font-size:13px;color:var(--t2);margin-bottom:6px}
.card-meta{display:flex;align-items:center;gap:14px;flex-wrap:wrap}
.meta-item{display:flex;align-items:center;gap:4px;font-size:12px;color:var(--t3)}
.meta-item i{font-size:13px}
.bookmark-btn{background:none;border:none;cursor:pointer;font-size:19px;color:var(--t3);transition:color .15s;flex-shrink:0;padding:2px}
.bookmark-btn:hover{color:var(--accent)}
.bookmark-btn.saved{color:var(--accent)}

.tags{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:16px}
.tag{padding:4px 11px;border-radius:99px;font-size:11px;font-weight:500}
.tag-cdi{background:#d1fae5;color:#065f46}
.tag-skill{background:#f3f4f6;color:var(--t1);border:0.5px solid var(--border)}
.tag-more{background:var(--accent-light);color:var(--accent);font-weight:600}

.card-footer{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
.salaire{font-size:14px;font-weight:700;color:var(--t1)}
.footer-right{display:flex;align-items:center;gap:12px}
.score-wrap{display:flex;align-items:center;gap:8px}
.score-bar{width:72px;height:5px;background:#e5e7eb;border-radius:99px;overflow:hidden}
.score-fill{height:100%;background:linear-gradient(90deg,var(--accent2),var(--accent));border-radius:99px}
.score-val{font-size:13px;font-weight:700;color:var(--accent);display:flex;align-items:center;gap:3px;white-space:nowrap}
.postuler-btn{
  display:inline-flex;align-items:center;gap:6px;
  padding:9px 16px;
  background:linear-gradient(135deg,#7c6ff0,#5b4be8);
  color:#fff;border:none;border-radius:var(--rs);
  font-size:13px;font-weight:500;font-family:inherit;
  cursor:pointer;white-space:nowrap;
  transition:opacity .15s;
}
.postuler-btn:hover{opacity:.88}
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-left">
    <a href="/" class="nav-logo"><div class="logo-av">JR</div><span>Talentlink</span></a>
    <div class="nav-links">
      <a class="nav-link active" href="{{ route('candidat.feed') }}">Feed</a>
      <a class="nav-link" href="{{ route('candidat.profil') }}">Profil</a>
      <a class="nav-link" href="{{ route('candidat.dashboard') }}">Candidatures</a>
      <a class="nav-link" href="{{ route('messagerie.index') }}">Messagerie</a>
    </div>
  </div>
  <div class="nav-right">
    @php
      $unreadNotifCount = \App\Models\Notification::where('id_candidat', $candidat->id_candidat)->where('statut_lecture', 'non lu')->count();
      $initials = substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1);
    @endphp
    <a href="{{ route('notifications.index') }}" class="notif-btn">
      <i class="ti ti-bell"></i>
      @if($unreadNotifCount > 0)
        <span class="notif-badge">{{ $unreadNotifCount }}</span>
      @endif
    </a>
    @if($candidat->photo_profil)
      <div class="user-av" style="background-image: url('{{ asset('storage/' . $candidat->photo_profil) }}'); background-size: cover; background-position: center;"></div>
    @else
      <div class="user-av">{{ $initials }}</div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" class="logout-btn"><i class="ti ti-logout"></i></button>
    </form>
  </div>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-inner">
    <div class="hero-title">Trouvez votre prochain job</div>
    <div class="search-row">
      <div class="search-wrap">
        <i class="ti ti-search search-icon"></i>
        <input class="search-input" type="text" id="keyword-input" placeholder="Poste, entreprise, compétence..." oninput="applyFilters()">
      </div>
    </div>
    <div class="filter-row" style="display:flex;gap:10px;margin-top:12px;flex-wrap:wrap;">
      <select class="filter-select" id="location-filter" onchange="applyFilters()">
        <option value="">Localisation</option>
        <option value="Cotonou">Cotonou</option>
        <option value="Porto-Novo">Porto-Novo</option>
        <option value="Parakou">Parakou</option>
        <option value="Abomey">Abomey</option>
        <option value="Ouidah">Ouidah</option>
        <option value="Bohicon">Bohicon</option>
        <option value="Djougou">Djougou</option>
        <option value="Natitingou">Natitingou</option>
        <option value="Kandi">Kandi</option>
        <option value="Lokossa">Lokossa</option>
        <option value="Savalou">Savalou</option>
        <option value="Grand Popo">Grand Popo</option>
        <option value="Malanville">Malanville</option>
        <option value="Nikki">Nikki</option>
        <option value="Ségboroué">Ségboroué</option>
      </select>
      <select class="filter-select" id="contract-filter" onchange="applyFilters()">
        <option value="">Type de contrat</option>
        <option value="CDI">CDI</option>
        <option value="CDD">CDD</option>
        <option value="Freelance">Freelance</option>
        <option value="Stage">Stage</option>
        <option value="Alternance">Alternance</option>
        <option value="Temps partiel">Temps partiel</option>
      </select>
      <select class="filter-select" id="sector-filter" onchange="applyFilters()">
        <option value="">Secteur</option>
        <option value="Technologie">Technologie</option>
        <option value="Finance">Finance</option>
        <option value="Santé">Santé</option>
        <option value="Marketing">Marketing</option>
        <option value="Ressources Humaines">Ressources Humaines</option>
        <option value="Ventes">Ventes</option>
        <option value="Juridique">Juridique</option>
        <option value="Logistique">Logistique</option>
        <option value="Industrie">Industrie</option>
        <option value="Éducation">Éducation</option>
        <option value="Design">Design</option>
        <option value="Communication">Communication</option>
      </select>
      <select class="filter-select" id="salary-filter" onchange="applyFilters()">
        <option value="">Salaire</option>
        <option value="0-100000">0 - 100k FCFA</option>
        <option value="100000-200000">100k - 200k FCFA</option>
        <option value="200000-300000">200k - 300k FCFA</option>
        <option value="300000-400000">300k - 400k FCFA</option>
        <option value="400000-500000">400k - 500k FCFA</option>
        <option value="500000-700000">500k - 700k FCFA</option>
        <option value="700000-1000000">700k - 1M FCFA</option>
        <option value="1000000+">1M+ FCFA</option>
      </select>
    </div>
  </div>
</div>

<!-- BODY -->
<div class="body">
  <div class="results-bar">
    <div class="results-count"><span id="count">{{ $offres->count() }}</span> offres correspondent à votre recherche</div>
  </div>

  <div id="offres-list">
    @foreach($offres as $offre)
      @php
        $initials = strtoupper(substr($offre->entreprise->nom_entreprise, 0, 2));
        $skills = array_filter(array_map('trim', explode(',', $offre->competences_requises ?? '')));
        $skills = array_slice($skills, 0, 3);
        $extra = count(array_filter(array_map('trim', explode(',', $offre->competences_requises ?? '')))) - count($skills);
        $salaire = ($offre->salaire_min && $offre->salaire_max) ? number_format($offre->salaire_min, 0, '', ' ') . ' – ' . number_format($offre->salaire_max, 0, '', ' ') . ' FCFA' : ($offre->salaire_min ? number_format($offre->salaire_min, 0, '', ' ') . ' FCFA' : 'Non spécifié');
        $avgSalary = $offre->salaire_min ? ($offre->salaire_max ? ($offre->salaire_min + $offre->salaire_max) / 2 : $offre->salaire_min) : 0;
        $compatScore = $scores[$offre->id_offre] ?? null;
      @endphp
      <div class="offre-card" 
           data-title="{{ strtolower($offre->titre_offre) }} {{ strtolower($offre->entreprise->nom_entreprise) }} {{ strtolower($offre->competences_requises ?? '') }}"
           data-location="{{ strtolower($offre->ville_poste ?? '') }}"
           data-contract="{{ strtolower($offre->type_contrat ?? '') }}"
           data-sector="{{ strtolower($offre->entreprise->secteur ?? '') }}"
           data-salary="{{ $avgSalary }}">
        <div class="card-top">
          <div class="co-av" style="background:#6c63ff">{{ $initials }}</div>
          <div class="card-info">
            <div class="card-title">{{ $offre->titre_offre }}</div>
            <div class="card-company">{{ $offre->entreprise->nom_entreprise }}</div>
            <div class="card-meta">
              <span class="meta-item"><i class="ti ti-map-pin"></i>{{ $offre->ville_poste ?? 'Non spécifié' }}</span>
              <span class="meta-item"><i class="ti ti-building"></i>{{ $offre->type_contrat ?? 'Sur site' }}</span>
              <span class="meta-item"><i class="ti ti-clock"></i>{{ $offre->date_publication ? $offre->date_publication->diffForHumans() : 'Récemment' }}</span>
            </div>
          </div>
          <button class="bookmark-btn" onclick="toggleSave(this)">
            <i class="ti ti-bookmark"></i>
          </button>
        </div>
        <div class="tags">
          <span class="tag tag-cdi">{{ $offre->type_contrat ?? 'CDI' }}</span>
          @foreach($skills as $skill)
            <span class="tag tag-skill">{{ $skill }}</span>
          @endforeach
          @if($extra > 0)
            <span class="tag tag-more">+{{ $extra }}</span>
          @endif
        </div>
        <div class="card-footer">
          <div class="salaire">{{ $salaire }}</div>
          <div class="footer-right">
            @if($compatScore !== null)
            <div class="score-wrap">
              <div class="score-bar"><div class="score-fill" style="width:{{ $compatScore }}%"></div></div>
              <span class="score-val"><i class="ti ti-trending-up" style="font-size:12px"></i>{{ $compatScore }}%</span>
            </div>
            @else
            <div class="score-wrap">
              <div class="score-bar"><div class="score-fill" style="width:0%"></div></div>
              <span class="score-val"><i class="ti ti-trending-up" style="font-size:12px"></i>--%</span>
            </div>
            @endif
            <button class="postuler-btn" onclick="window.location='{{ route('candidat.offres.postuler', $offre->id_offre) }}'">Postuler <i class="ti ti-chevron-right"></i></button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<script>
function toggleSave(btn) {
  if (btn.classList.contains('saved')) {
    btn.classList.remove('saved');
    btn.innerHTML = '<i class="ti ti-bookmark"></i>';
  } else {
    btn.classList.add('saved');
    btn.innerHTML = '<i class="ti ti-bookmark-filled"></i>';
  }
}

function applyFilters() {
  const keyword = document.getElementById('keyword-input').value.toLowerCase();
  const location = document.getElementById('location-filter').value.toLowerCase();
  const contract = document.getElementById('contract-filter').value.toLowerCase();
  const sector = document.getElementById('sector-filter').value.toLowerCase();
  const salary = document.getElementById('salary-filter').value;

  let count = 0;
  document.querySelectorAll('.offre-card').forEach(card => {
    const title = card.getAttribute('data-title');
    const cardLocation = card.getAttribute('data-location');
    const cardContract = card.getAttribute('data-contract');
    const cardSector = card.getAttribute('data-sector');
    const cardSalary = parseFloat(card.getAttribute('data-salary'));

    let matches = true;

    // Keyword filter
    if (keyword && !title.includes(keyword)) {
      matches = false;
    }

    // Location filter
    if (location && !cardLocation.includes(location)) {
      matches = false;
    }

    // Contract filter
    if (contract && !cardContract.includes(contract)) {
      matches = false;
    }

    // Sector filter
    if (sector && !cardSector.includes(sector)) {
      matches = false;
    }

    // Salary filter
    if (salary) {
      if (salary === '1000000+') {
        if (cardSalary < 1000000) matches = false;
      } else {
        const [min, max] = salary.split('-').map(Number);
        if (cardSalary < min || cardSalary > max) matches = false;
      }
    }

    if (matches) {
      card.style.display = '';
      count++;
    } else {
      card.style.display = 'none';
    }
  });

  document.getElementById('count').textContent = count;
}
</script>
</body>
</html>
