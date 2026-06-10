<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes Offres — {{ $entreprise->nom_entreprise ?? 'Entreprise' }}</title>
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

.create-btn {
  display: flex; align-items: center; gap: 8px;
  padding: 10px 20px;
  background: rgba(255,255,255,0.2);
  border: 1px solid rgba(255,255,255,0.3);
  border-radius: 12px; color: #fff;
  font-size: 14px; font-weight: 500;
  font-family: 'DM Sans', sans-serif; cursor: pointer;
  backdrop-filter: blur(6px); white-space: nowrap;
  transition: background 0.15s;
  text-decoration: none;
}
.create-btn:hover { background: rgba(255,255,255,0.3); }

/* ── CONTENT ── */
.content { max-width: 860px; margin: 0 auto; padding: 1.8rem 1.5rem 4rem; }

/* Results bar */
.results-bar {
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.2rem; flex-wrap: wrap; gap: 10px;
}

.results-count { font-size: 14px; color: #7070a0; }
.results-count strong { color: #1a1550; font-weight: 700; }

/* ── OFFER CARD ── */
.offer-card {
  background: #fff; border: 1px solid #e8e8f4;
  border-radius: 18px; padding: 1.4rem 1.6rem;
  margin-bottom: 12px; position: relative;
  transition: box-shadow 0.2s, transform 0.15s;
}
.offer-card:hover {
  box-shadow: 0 8px 32px rgba(80,64,232,0.1);
  transform: translateY(-2px);
}

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
.tag.active { background: #eafaf1; color: #16a34a; border-color: #c6efd6; }
.tag.suspend { background: #fef3c7; color: #b45309; border-color: #fde68a; }
.tag.close { background: #fee2e2; color: #991b1b; border-color: #fecaca; }

/* Bottom row */
.card-bottom { display: flex; align-items: center; justify-content: space-between; gap: 16px; }

.candidates-count { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14.5px; color: #1a1550; }

.actions-row { display: flex; align-items: center; gap: 8px; }

.action-btn {
  padding: 9px 14px;
  background: #f4f5fa; color: #7070a0;
  border: 1px solid #e4e4f0; border-radius: 10px;
  font-size: 13px; font-weight: 500;
  font-family: 'DM Sans', sans-serif; cursor: pointer;
  display: flex; align-items: center; gap: 6px;
  transition: background 0.15s, color 0.15s;
  text-decoration: none;
  white-space: nowrap;
}
.action-btn:hover { background: #e8e8f4; color: #5040e8; }
.action-btn.primary {
  background: linear-gradient(135deg, #5040e8, #6c5ce7);
  color: #fff; border: none;
}
.action-btn.primary:hover { opacity: 0.88; }

.divider { height: 1px; background: #f0f0f8; margin: 10px 0; }

/* Empty state */
.empty-state { text-align: center; padding: 60px 20px; color: #9090b0; }
.empty-state-icon { font-size: 48px; margin-bottom: 16px; }
.empty-state-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 18px; color: #1a1550; margin-bottom: 8px; }
.empty-state-text { font-size: 13px; margin-bottom: 20px; }

/* NAV ENTREPRISE */
nav.entreprise-nav{background:#fff;border-bottom:1px solid #e4e4f0;padding:0 28px;height:54px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100}
.nav-left{display:flex;align-items:center;gap:32px}
.nav-logo{display:flex;align-items:center;gap:8px;font-weight:700;font-size:16px;text-decoration:none;color:#1a1550;font-family:'Syne',sans-serif}
.logo-av{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#5040e8,#6c5ce7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff}
.nav-links{display:flex;gap:24px}
.nav-link{font-size:13px;color:#7070a0;cursor:pointer;text-decoration:none;transition:color .12s;padding-bottom:2px;font-family:'DM Sans',sans-serif}
.nav-link:hover{color:#1a1550}
.nav-link.active{color:#5040e8;font-weight:600;border-bottom:2px solid #5040e8}
.nav-right{display:flex;align-items:center;gap:12px}
.notif-btn{position:relative;background:none;border:none;cursor:pointer;font-size:18px;color:#7070a0;text-decoration:none}
.notif-badge{position:absolute;top:-2px;right:-2px;min-width:20px;height:20px;border-radius:50%;background:#3b82f6;color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 6px;border:2px solid #fff;box-shadow:0 2px 4px rgba(0,0,0,.2)}
.user-av{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#5040e8,#6c5ce7);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;cursor:pointer}
.logout-btn{background:none;border:none;cursor:pointer;font-size:18px;color:#9090b0;transition:color .12s}
.logout-btn:hover{color:#1a1550}

@media (max-width: 720px) {
  nav.entreprise-nav { padding: 0 16px; }
  .hero-banner { padding: 2rem 1.5rem 1.5rem; }
  .content { padding: 1.5rem 1rem 3rem; }
}
</style>
</head>
<body>

<!-- CONTENT -->
<div class="content">
  @php
    $offres = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)
      ->orderByDesc('date_publication')
      ->get();
  @endphp

  <a href="{{ route('entreprise.dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #7070a0; font-size: 14px; text-decoration: none; margin-bottom: 1.5rem; font-family: 'DM Sans', sans-serif;"><i class="ti ti-arrow-left"></i> Retour au dashboard</a>
  <h2 style="font-family: 'Syne', sans-serif; font-weight: 700; font-size: 20px; color: #1a1550; margin-bottom: 1.5rem;">Liste des offres</h2>

  <div id="offers-list">
    @if($offres->count() > 0)
      @foreach($offres as $offre)
        @php
          $nbCandidats = \App\Models\Candidature::where('id_offre', $offre->id_offre)->count();
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
          
          $tagClass = 'active';
          $tagText = 'Active';
          if ($offre->statut_offre === 'suspendue') {
            $tagClass = 'suspend';
            $tagText = 'Suspendue';
          } elseif ($offre->statut_offre === 'clôturée') {
            $tagClass = 'close';
            $tagText = 'Clôturée';
          }
          
          $daysAgo = $offre->date_publication->diffInDays(now());
          
          // Parse competences
          $competences = [];
          if ($offre->competences_requises) {
            $competences = array_map('trim', explode(',', $offre->competences_requises));
          }
          
          // Salary display
          $salaryDisplay = 'Non spécifié';
          if ($offre->salaire_min && $offre->salaire_max) {
            $salaryDisplay = number_format($offre->salaire_min, 0, '', ' ') . ' – ' . number_format($offre->salaire_max, 0, '', ' ') . ' ' . ($offre->devise ?? 'FCFA');
          } elseif ($offre->salaire_min) {
            $salaryDisplay = 'À partir de ' . number_format($offre->salaire_min, 0, '', ' ') . ' ' . ($offre->devise ?? 'FCFA');
          } elseif ($offre->salaire_max) {
            $salaryDisplay = 'Jusqu\'à ' . number_format($offre->salaire_max, 0, '', ' ') . ' ' . ($offre->devise ?? 'FCFA');
          }
        @endphp
        <div class="offer-card" data-date="{{ $daysAgo }}" data-candidats="{{ $nbCandidats }}" data-titre="{{ $offre->titre_offre }}">
          <div class="card-top">
            <div class="company-logo" style="background:{{ $color }}">{{ $initials }}</div>
            <div class="card-info">
              <div class="card-title">{{ $offre->titre_offre }}</div>
              <div class="card-company">{{ $entreprise->nom_entreprise }}</div>
              <div class="card-meta">
                <span class="meta-item"><i class="ti ti-map-pin"></i> {{ $offre->ville_poste ?? 'Non spécifié' }}</span>
                <span class="meta-item"><i class="ti ti-clock"></i> Il y a {{ $daysAgo > 0 ? $daysAgo . ' jour' . ($daysAgo > 1 ? 's' : '') : 'aujourd\'hui' }}</span>
              </div>
            </div>
          </div>
          <div class="tags-row">
            <span class="tag {{ $tagClass }}">{{ $tagText }}</span>
            @foreach(array_slice($competences, 0, 3) as $competence)
              <span class="tag">{{ $competence }}</span>
            @endforeach
            @if(count($competences) > 3)
              <span class="tag">+{{ count($competences) - 3 }}</span>
            @endif
          </div>
          <div class="divider"></div>
          <div class="card-bottom">
            <span class="candidates-count">{{ $nbCandidats }} candidat{{ $nbCandidats > 1 ? 's' : '' }}</span>
            <div class="actions-row">
              <a href="{{ route('entreprise.offres.edit', ['id_offre' => $offre->id_offre]) }}" class="action-btn"><i class="ti ti-edit"></i> Modifier</a>
              <a href="{{ route('entreprise.offres.detail', ['id_offre' => $offre->id_offre]) }}" class="action-btn"><i class="ti ti-eye"></i> Voir</a>
            </div>
          </div>
        </div>
      @endforeach
    @else
      <div class="empty-state">
        <div class="empty-state-icon">📭</div>
        <div class="empty-state-title">Aucune offre publiée</div>
        <div class="empty-state-text">Vous n'avez pas encore publié d'offre d'emploi.</div>
        <a href="{{ route('entreprise.offres.create') }}" class="action-btn primary" style="display:inline-flex;margin-top:10px"><i class="ti ti-plus"></i> Créer ma première offre</a>
      </div>
    @endif

  </div><!-- /offers-list -->
</div><!-- /content -->

</body>
</html>
