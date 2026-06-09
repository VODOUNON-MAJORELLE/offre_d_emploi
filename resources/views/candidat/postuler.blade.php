<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidature — {{ $offre->titre_offre }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg-page: #f0f2f7;
      --bg-card: #ffffff;
      --bg-secondary: #f5f6fa;
      --text-primary: #1a1a2e;
      --text-secondary: #6b7280;
      --text-tertiary: #9ca3af;
      --border: rgba(0,0,0,0.08);
      --border-hover: rgba(0,0,0,0.18);
      --accent: #5b4be8;
      --accent-light: #eeedf9;
      --accent-border: #7c6ff0;
      --radius-md: 8px;
      --radius-lg: 12px;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: var(--bg-page);
      color: var(--text-primary);
      min-height: 100vh;
      padding: 20px 16px 40px;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: var(--text-secondary);
      margin-bottom: 18px;
      cursor: pointer;
      text-decoration: none;
      transition: color 0.12s;
    }
    .back-link:hover { color: var(--text-primary); }

    .container { max-width: 520px; margin: 0 auto; }

    /* Job card */
    .job-card {
      background: var(--bg-card);
      border-radius: var(--radius-lg);
      border: 0.5px solid var(--border);
      padding: 14px 16px;
      margin-bottom: 14px;
    }
    .job-header { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .job-avatar {
      width: 40px; height: 40px;
      border-radius: 8px;
      background: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 600; color: #fff;
      flex-shrink: 0;
    }
    .job-title { font-size: 14px; font-weight: 600; color: var(--text-primary); line-height: 1.3; }
    .job-sub { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }
    .job-details { margin-top: 12px; padding-top: 12px; border-top: 0.5px solid var(--border); }
    .detail-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; font-size: 12px; color: var(--text-secondary); }
    .detail-row:last-child { margin-bottom: 0; }
    .detail-row i { font-size: 13px; color: var(--accent); }
    .detail-value { color: var(--text-primary); font-weight: 500; }
    .job-description { margin-top: 12px; padding-top: 12px; border-top: 0.5px solid var(--border); }
    .job-description p { font-size: 12px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 8px; }
    .job-description p:last-child { margin-bottom: 0; }
    .job-skills { margin-top: 12px; padding-top: 12px; border-top: 0.5px solid var(--border); }
    .skill-tag { display: inline-block; padding: 4px 10px; background: var(--accent-light); border: 0.5px solid var(--accent-border); border-radius: 99px; font-size: 11px; color: var(--text-primary); margin-right: 6px; margin-bottom: 6px; }
    .compat-row { display: flex; align-items: center; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 0.5px solid var(--border); }
    .progress-bar {
      flex: 1; height: 5px;
      background: var(--border);
      border-radius: 99px; overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #7c6ff0, #5b4be8);
      border-radius: 99px;
    }
    .compat-label { font-size: 12px; color: var(--accent); font-weight: 500; white-space: nowrap; }

    /* Section card */
    .section {
      background: var(--bg-card);
      border-radius: var(--radius-lg);
      border: 0.5px solid var(--border);
      padding: 18px 16px;
      margin-bottom: 12px;
    }
    .section-title { font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 16px; }

    /* Question */
    .question { margin-bottom: 20px; }
    .question:last-child { margin-bottom: 0; }
    .q-label { font-size: 13px; font-weight: 500; color: var(--text-primary); margin-bottom: 10px; }

    /* Option */
    .option {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 12px;
      border-radius: var(--radius-md);
      border: 0.5px solid var(--border);
      margin-bottom: 6px;
      cursor: pointer;
      transition: background 0.12s, border-color 0.12s;
      user-select: none;
    }
    .option:last-child { margin-bottom: 0; }
    .option:hover { background: var(--bg-secondary); }
    .option.selected { background: var(--accent-light); border-color: var(--accent-border); }

    .radio-circle {
      width: 17px; height: 17px;
      border-radius: 50%;
      border: 1.5px solid var(--border-hover);
      flex-shrink: 0;
      display: flex; align-items: center; justify-content: center;
      transition: border-color 0.12s, background 0.12s;
    }
    .option.selected .radio-circle {
      border-color: var(--accent);
      background: var(--accent);
    }
    .radio-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: #fff;
    }
    .option-text { font-size: 13px; color: var(--text-primary); }

    /* Upload zone */
    .upload-zone {
      border: 1.5px dashed var(--border-hover);
      border-radius: var(--radius-md);
      padding: 26px 16px;
      text-align: center;
      cursor: pointer;
      transition: border-color 0.15s, background 0.15s;
    }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-light); }
    .upload-icon { font-size: 24px; color: var(--text-secondary); margin-bottom: 8px; }
    .upload-label { font-size: 13px; font-weight: 500; color: var(--text-primary); }
    .upload-hint { font-size: 11px; color: var(--text-tertiary); margin-top: 3px; }
    .cv-name { font-size: 12px; color: var(--text-secondary); margin-top: 8px; display: none; }

    /* CV Display */
    .cv-display{
      display:flex;align-items:center;gap:12px;
      padding:14px 16px;
      border:0.5px solid var(--accent-border);
      border-radius:var(--radius-md);
      background:var(--accent-light);
      cursor:pointer;
      transition:border-color .15s,background .15s;
    }
    .cv-display:hover{border-color:var(--accent);background:#e4e3f5}
    .cv-icon{font-size:24px;color:var(--accent)}
    .cv-info{flex:1}
    .cv-filename{font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:2px}
    .cv-hint{font-size:11px;color:var(--text-secondary)}
    .cv-change{font-size:18px;color:var(--accent)}

    /* Lettre */
    .lettre-sub { font-size: 12px; color: var(--text-secondary); margin-bottom: 10px; }
    textarea {
      width: 100%;
      border: 0.5px solid var(--border);
      border-radius: var(--radius-md);
      padding: 10px 12px;
      font-size: 13px;
      font-family: inherit;
      color: var(--text-primary);
      background: var(--bg-card);
      resize: vertical;
      min-height: 110px;
      outline: none;
      transition: border-color 0.15s;
      line-height: 1.6;
    }
    textarea::placeholder { color: var(--text-tertiary); }
    textarea:focus { border-color: var(--accent); }
    .char-count { text-align: right; font-size: 11px; color: var(--text-tertiary); margin-top: 5px; }

    /* Submit */
    .submit-btn {
      width: 100%;
      padding: 16px;
      border: none;
      border-radius: var(--radius-lg);
      background: linear-gradient(135deg, #7c6ff0, #5b4be8);
      color: #fff;
      font-size: 15px;
      font-weight: 500;
      font-family: inherit;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      margin-top: 4px;
      transition: opacity 0.15s, transform 0.1s;
    }
    .submit-btn:hover { opacity: 0.9; }
    .submit-btn:active { transform: scale(0.99); }
    .submit-btn:disabled { background: #1D9E75; cursor: default; opacity: 1; }

    /* Error messages */
    .error-box {
      background: #fef2f2;
      border: 0.5px solid #fecaca;
      border-radius: var(--radius-lg);
      padding: 12px 16px;
      margin-bottom: 14px;
    }
    .error-content {
      display: flex;
      align-items: start;
      gap: 8px;
    }
    .error-icon { font-size: 18px; }
    .error-list {
      margin: 0;
      padding-left: 20px;
      font-size: 13px;
      color: #991b1b;
    }
  </style>
</head>
<body>
<div class="container">

  <a href="/" class="back-link" onclick="history.back(); return false;">
    <i class="ti ti-arrow-left"></i> Retour à l'offre
  </a>

  {{-- Validation Errors --}}
  @if($errors->any())
  <div class="error-box">
    <div class="error-content">
      <span class="error-icon">⚠️</span>
      <ul class="error-list">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
  @endif

  <div class="job-card">
    <div class="job-header">
      <div class="job-avatar">{{ substr($offre->entreprise->nom_entreprise, 0, 2) }}</div>
      <div>
        <div class="job-title">{{ $offre->titre_offre }}</div>
        <div class="job-sub">{{ $offre->entreprise->nom_entreprise }} · {{ $offre->ville_poste }}</div>
      </div>
    </div>
    
    {{-- Détails de l'offre --}}
    <div class="job-details">
      @php
        $salaire = ($offre->salaire_min && $offre->salaire_max) ? number_format($offre->salaire_min, 0, '', ' ') . ' – ' . number_format($offre->salaire_max, 0, '', ' ') . ' FCFA' : ($offre->salaire_min ? number_format($offre->salaire_min, 0, '', ' ') . ' FCFA' : 'Non spécifié');
      @endphp
      <div class="detail-row">
        <i class="ti ti-building"></i>
        <span>Type de contrat :</span>
        <span class="detail-value">{{ $offre->type_contrat ?? 'Non spécifié' }}</span>
      </div>
      <div class="detail-row">
        <i class="ti ti-wallet"></i>
        <span>Salaire :</span>
        <span class="detail-value">{{ $salaire }}</span>
      </div>
      <div class="detail-row">
        <i class="ti ti-clock"></i>
        <span>Expérience requise :</span>
        <span class="detail-value">{{ $offre->experience_requise ?? 0 }} an(s)</span>
      </div>
      <div class="detail-row">
        <i class="ti ti-graduation-cap"></i>
        <span>Niveau d'études :</span>
        <span class="detail-value">{{ $offre->niveau_etudes_requis ?? 'Non spécifié' }}</span>
      </div>
    </div>

    {{-- Description de l'offre --}}
    @if($offre->description_offre)
    <div class="job-description">
      <p>{{ nl2br($offre->description_offre) }}</p>
    </div>
    @endif

    {{-- Compétences requises --}}
    @if($offre->competences_requises)
    <div class="job-skills">
      @php
        $skills = array_filter(array_map('trim', explode(',', $offre->competences_requises)));
      @endphp
      @foreach($skills as $skill)
        <span class="skill-tag">{{ $skill }}</span>
      @endforeach
    </div>
    @endif

    {{-- Barre de compatibilité --}}
    <div class="compat-row">
      @php
        $compatScore = \App\Models\Score::where('id_candidat', Auth::guard('candidat')->user()->id_candidat)
          ->where('id_offre', $offre->id_offre)
          ->value('score_compatibilite') ?? 75;
      @endphp
      <div class="progress-bar"><div class="progress-fill" style="width: {{ $compatScore }}%;"></div></div>
      <div class="compat-label">✦ {{ (int)$compatScore }}% de compatibilité</div>
    </div>
  </div>

  @php
    $previousResponses = isset($existingCandidature) ? $existingCandidature->reponses->keyBy('id_question') : collect();
  @endphp

  <form action="{{ route('candidat.offres.submit', $offre->id_offre) }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Questionnaire (if applicable) --}}
    @if($offre->questionnaire)
      <div class="section">
        <div class="section-title">Questionnaire</div>

        @foreach($offre->questionnaire->questions as $question)
          <div class="question">
            <div class="q-label">{{ $loop->iteration }}. {{ $question->enonce_question }}</div>

            @if($question->type_question === 'QCM')
              @php
                $prevResp = $previousResponses->get($question->id_question);
                $prevSelectedVal = $prevResp ? $prevResp->contenu_reponse : '';
              @endphp
              @foreach($question->options as $option)
                @php
                  $isOptionSelected = ($prevSelectedVal == $option->id_option);
                @endphp
                <div class="option {{ $isOptionSelected ? 'selected' : '' }}" data-q="{{ $question->id_question }}" data-opt="{{ $option->id_option }}" onclick="pick(this, '{{ $question->id_question }}', '{{ $option->id_option }}')">
                  <div class="radio-circle">
                    @if($isOptionSelected)
                      <div class="radio-dot"></div>
                    @endif
                  </div>
                  <div class="option-text">{{ $option->contenu_option }}</div>
                </div>
              @endforeach
              <input type="hidden" id="input_q_{{ $question->id_question }}" name="answers[{{ $question->id_question }}][]" value="{{ $prevSelectedVal }}">
            @else
              @php
                $prevResp = $previousResponses->get($question->id_question);
                $prevTextVal = $prevResp ? $prevResp->contenu_reponse : '';
              @endphp
              <textarea name="answers[{{ $question->id_question }}]" placeholder="Saisissez votre réponse..." required>{{ old('answers.'.$question->id_question, $prevTextVal) }}</textarea>
            @endif
          </div>
        @endforeach
      </div>
    @endif

    {{-- CV --}}
    <div class="section">
      <div class="section-title">CV</div>
      <div class="upload-zone" id="upload-zone" style="{{ isset($existingCandidature) ? 'display:none;' : '' }}" onclick="document.getElementById('cv-input').click()">
        <div class="upload-icon"><i class="ti ti-upload"></i></div>
        <div class="upload-label">Importer votre CV</div>
        <div class="upload-hint">PDF, DOCX — max 5 MB</div>
        <input type="file" id="cv-input" name="cv_file" accept=".pdf,.docx" style="display:none" onchange="handleCV(this)">
      </div>
      <div class="cv-display" id="cv-display" style="{{ isset($existingCandidature) ? 'display:flex;' : 'display:none;' }}" onclick="document.getElementById('cv-input').click()">
        <div class="cv-icon"><i class="ti ti-file-description"></i></div>
        <div class="cv-info">
          <div class="cv-filename" id="cv-filename">{{ $existingCandidature->cv->nom_fichier ?? '' }}</div>
          <div class="cv-hint">Cliquez pour remplacer</div>
        </div>
        <div class="cv-change"><i class="ti ti-refresh"></i></div>
      </div>
      {{-- Message d'erreur taille CV --}}
      <div id="cv-error" style="display:none; margin-top:10px; padding:10px 14px; background:#fef2f2; border:0.5px solid #fecaca; border-radius:8px; font-size:13px; color:#991b1b; align-items:center; gap:8px;">
        <i class="ti ti-alert-circle" style="font-size:16px; flex-shrink:0;"></i>
        <span>Le fichier dépasse la limite de <strong>5 MB</strong>. Veuillez choisir un fichier plus petit.</span>
      </div>
    </div>

    {{-- Lettre de motivation --}}
    <div class="section">
      <div class="section-title">Lettre de motivation</div>
      <div class="lettre-sub">Optionnel mais recommandé — max 2 000 caractères</div>
      <textarea
        id="lettre"
        name="lettre_text"
        maxlength="2000"
        placeholder="Expliquez pourquoi vous êtes le candidat idéal pour ce poste..."
        oninput="updateCount()"
      >{{ old('lettre_text', $existingCandidature->lettre_motivation ?? '') }}</textarea>
      <div class="char-count"><span id="char-count">0</span> / 2 000</div>
    </div>

    <button type="submit" class="submit-btn" id="submit-btn">
      Valider ma candidature <i class="ti ti-check"></i>
    </button>

  </form>

</div>

<script>
  function pick(el, qId, optionId) {
    const q = qId;
    document.querySelectorAll('[data-q="' + q + '"]').forEach(o => {
      o.classList.remove('selected');
      const dot = o.querySelector('.radio-dot');
      if (dot) dot.remove();
    });
    el.classList.add('selected');
    const circle = el.querySelector('.radio-circle');
    const dot = document.createElement('div');
    dot.className = 'radio-dot';
    circle.appendChild(dot);
    
    // Update the hidden input with the selected option ID
    const input = document.getElementById('input_q_' + q);
    if (input) {
      input.value = optionId;
    }
  }

  function updateCount() {
    document.getElementById('char-count').textContent =
      document.getElementById('lettre').value.length;
  }

  function handleCV(input) {
    const errorDiv = document.getElementById('cv-error');
    const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

    // Reset error state
    errorDiv.style.display = 'none';

    if (input.files && input.files[0]) {
      const file = input.files[0];

      if (file.size > MAX_SIZE) {
        // Blocé : afficher l'erreur, réinitialiser l'input
        input.value = '';
        errorDiv.style.display = 'flex';

        // Remettre la zone d'upload visible et cacher le display CV
        document.getElementById('upload-zone').style.display = '';
        document.getElementById('cv-display').style.display = 'none';
        return;
      }

      // Fichier valide : afficher le nom et cacher la zone d'upload
      document.getElementById('upload-zone').style.display = 'none';
      document.getElementById('cv-display').style.display = 'flex';
      document.getElementById('cv-filename').textContent = file.name;
    }
  }

  // Initialize character count on page load
  window.addEventListener('DOMContentLoaded', () => {
    updateCount();

    // ── Blocage à la soumission si fichier CV > 5 MB ──────────────────────
    const form = document.querySelector('form[enctype="multipart/form-data"]');
    if (form) {
      form.addEventListener('submit', function(e) {
        const cvInput = document.getElementById('cv-input');
        const errorDiv = document.getElementById('cv-error');
        const MAX_SIZE = 5 * 1024 * 1024; // 5 MB

        if (cvInput && cvInput.files && cvInput.files[0]) {
          if (cvInput.files[0].size > MAX_SIZE) {
            e.preventDefault();
            e.stopPropagation();

            // Afficher l'erreur
            errorDiv.style.display = 'flex';

            // Réinitialiser le champ
            cvInput.value = '';
            document.getElementById('upload-zone').style.display = '';
            document.getElementById('cv-display').style.display = 'none';

            // Scroll vers l'erreur
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
          }
        }
      });
    }
  });
</script>
</body>
</html>
