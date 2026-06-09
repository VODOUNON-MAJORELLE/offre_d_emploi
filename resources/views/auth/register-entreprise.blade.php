<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Inscription entreprise</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: #f4f5fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .wrapper { display: flex; width: 100%; max-width: 980px; min-height: 620px; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 40px rgba(60,52,137,0.12); }
    .panel-left { flex: 1; background: linear-gradient(145deg,#dde8ff 0%,#c8d8fa 40%,#bfcff7 70%,#d4e4fe 100%); padding: 2.5rem; display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; }
    .blob { position: absolute; border-radius: 50%; filter: blur(40px); pointer-events: none; }
    .blob-1 { width: 240px; height: 240px; background: rgba(160,190,255,0.5); top: 20px; left: 10px; }
    .blob-2 { width: 180px; height: 180px; background: rgba(130,170,255,0.35); bottom: 80px; right: 10px; filter: blur(32px); }
    .logo { display: flex; align-items: center; gap: 10px; z-index: 1; position: relative; }
    .logo-avatar { width: 38px; height: 38px; border-radius: 50%; background: #5040e8; display: flex; align-items: center; justify-content: center; font-family: 'Syne',sans-serif; font-weight: 600; font-size: 13px; color: #fff; }
    .logo-name { font-family: 'Syne',sans-serif; font-weight: 600; font-size: 16px; color: #2d2560; }
    .hero { z-index: 1; position: relative; }
    .hero h1 { font-family: 'Syne',sans-serif; font-weight: 700; font-size: 32px; line-height: 1.2; color: #1a1550; margin-bottom: 14px; }
    .hero p { font-size: 13.5px; color: #3d3870; line-height: 1.65; margin-bottom: 28px; }
    .features { list-style: none; display: flex; flex-direction: column; gap: 12px; }
    .features li { display: flex; align-items: center; gap: 12px; font-size: 13.5px; color: #3a3575; }
    .feat-icon { width: 22px; height: 22px; border-radius: 50%; background: rgba(80,64,232,0.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .feat-icon i { font-size: 12px; color: #4f40d8; }
    .footer-copy { font-size: 12px; color: #7070a0; z-index: 1; position: relative; }
    .footer-copy strong { color: #3a3575; }
    .panel-right { flex: 1.05; background: #f4f5fa; padding: 2.2rem 2.8rem; display: flex; flex-direction: column; }
    .back-link { display: inline-flex; align-items: center; gap: 7px; font-size: 13px; color: #7070a0; text-decoration: none; margin-bottom: 1.4rem; cursor: pointer; transition: color 0.15s; }
    .back-link:hover { color: #1a1550; }
    .step-header { margin-bottom: 1.2rem; }
    .step-header h2 { font-family: 'Syne',sans-serif; font-weight: 700; font-size: 22px; color: #1a1550; margin-bottom: 3px; }
    .step-header span { font-size: 13px; color: #7070a0; }
    .progress { display: flex; gap: 6px; margin-bottom: 1.6rem; }
    .progress-bar { height: 4px; flex: 1; border-radius: 4px; background: #e0e0f0; overflow: hidden; }
    .progress-bar .fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg,#5040e8,#6c5ce7); transition: width 0.4s; }
    .card { background: #fff; border: 1px solid #e8e8f0; border-radius: 18px; padding: 1.8rem; }
    .field { margin-bottom: 1rem; }
    .field:last-child { margin-bottom: 0; }
    label { display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.07em; text-transform: uppercase; color: #7070a0; margin-bottom: 6px; }
    input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
      width: 100%; padding: 11px 15px; font-size: 14px; font-family: 'DM Sans',sans-serif;
      border: 1px solid #e0e0ee; border-radius: 10px; background: #fafafe;
      color: #1a1550; outline: none; transition: border-color 0.15s, box-shadow 0.15s;
    }
    textarea { width: 100%; padding: 11px 15px; font-size: 14px; font-family: 'DM Sans',sans-serif; border: 1px solid #e0e0ee; border-radius: 10px; background: #fafafe; color: #1a1550; outline: none; resize: vertical; min-height: 90px; transition: border-color 0.15s, box-shadow 0.15s; }
    input::placeholder, textarea::placeholder { color: #b0b0c8; }
    input:focus, textarea:focus { border-color: #5040e8; box-shadow: 0 0 0 3px rgba(80,64,232,0.12); background: #fff; }
    input.error { border-color: #e24b4a; }
    .input-wrap { position: relative; }
    .input-wrap input { padding-right: 42px; }
    .toggle-eye { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #b0b0c8; font-size: 17px; transition: color 0.15s; }
    .toggle-eye:hover { color: #5040e8; }
    .upload-zone { border: 1.5px dashed #c8c8e0; border-radius: 14px; padding: 1.6rem 1rem; display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: pointer; transition: border-color 0.15s, background 0.15s; margin-bottom: 1.2rem; }
    .upload-zone:hover { border-color: #5040e8; background: #f5f4ff; }
    .upload-zone .up-icon { width: 44px; height: 44px; border-radius: 12px; background: #eeeeff; display: flex; align-items: center; justify-content: center; }
    .upload-zone .up-icon i { font-size: 20px; color: #5040e8; }
    .upload-zone p { font-size: 13.5px; font-weight: 500; color: #1a1550; }
    .upload-zone span { font-size: 12px; color: #9090b0; }
    .upload-zone input[type="file"] { display: none; }
    .cgu-line { display: flex; align-items: center; gap: 9px; font-size: 13px; color: #7070a0; margin: 1rem 0 1.3rem; }
    .cgu-line input[type="checkbox"] { width: 15px; height: 15px; accent-color: #5040e8; cursor: pointer; flex-shrink: 0; }
    .cgu-line a { color: #5040e8; text-decoration: none; }
    .cgu-line a:hover { text-decoration: underline; }
    .btn { width: 100%; padding: 13px; font-size: 14.5px; font-family: 'DM Sans',sans-serif; font-weight: 500; color: #fff; background: linear-gradient(135deg,#5040e8,#6c5ce7); border: none; border-radius: 10px; cursor: pointer; transition: opacity 0.15s, transform 0.1s; margin-top: 0.2rem; }
    .btn:hover { opacity: 0.92; }
    .btn:active { transform: scale(0.985); }
    .btn-ghost { background: none; color: #7070a0; border: none; font-size: 13.5px; cursor: pointer; font-family: 'DM Sans',sans-serif; display: flex; align-items: center; gap: 6px; margin: 0.9rem auto 0; }
    .btn-ghost:hover { color: #1a1550; }
    .bottom-links { text-align: center; font-size: 13px; color: #9090b0; margin-top: 1.2rem; }
    .bottom-links a { color: #5040e8; text-decoration: none; font-weight: 500; }
    .bottom-links a:hover { text-decoration: underline; }
    @media (max-width: 700px) { .panel-left { display: none; } .panel-right { padding: 2rem 1.5rem; } }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="panel-left">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="logo">
      <div class="logo-avatar">JR</div>
      <span class="logo-name">Talentlink</span>
    </div>
    <div class="hero">
      <h1>Recrutez les meilleurs talents.</h1>
      <p>Publiez vos offres et accédez à 320 000+ candidats qualifiés.</p>
      <ul class="features">
        <li><span class="feat-icon"><i class="ti ti-sparkles"></i></span>Matching IA avancé</li>
        <li><span class="feat-icon"><i class="ti ti-briefcase"></i></span>12 000+ offres vérifiées</li>
        <li><span class="feat-icon"><i class="ti ti-message-2"></i></span>Messagerie intégrée</li>
        <li><span class="feat-icon"><i class="ti ti-eye"></i></span>Suivi en temps réel</li>
      </ul>
    </div>
    <div class="footer-copy">© 2026 <strong>Talentlink</strong></div>
  </div>

  <div class="panel-right">
    <a class="back-link" href="{{ route('login') }}"><i class="ti ti-arrow-left"></i> Retour</a>

    <div class="step-header">
      <h2>Inscription entreprise</h2>
      <span id="step-label">Étape 1 sur 2</span>
    </div>

    <div class="progress">
      <div class="progress-bar"><div class="fill" id="bar1" style="width:100%"></div></div>
      <div class="progress-bar"><div class="fill" id="bar2" style="width:0%"></div></div>
    </div>

    <!-- STEP 1 -->
    <div id="step1">
      <div class="card">
        <form id="step1-form">
          <div class="field">
            <label for="nom_entreprise">Nom de l'entreprise</label>
            <input type="text" id="nom_entreprise" name="nom_entreprise" placeholder="TechVision" value="{{ old('nom_entreprise') }}" />
            @error('nom_entreprise')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="secteur">Secteur d'activité</label>
            <input type="text" id="secteur" name="secteur" placeholder="Technologie, Finance, Santé…" value="{{ old('secteur') }}" />
            @error('secteur')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="ville_entreprise" placeholder="Cotonou, Calavi" value="{{ old('ville_entreprise') }}" />
            @error('ville_entreprise')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="pays">Pays</label>
            <select id="pays" name="pays" style="width: 100%; padding: 11px 15px; font-size: 14px; font-family: 'DM Sans',sans-serif; border: 1px solid #e0e0ee; border-radius: 10px; background: #fafafe; color: #1a1550; outline: none;">
              <option value="Bénin" selected>Bénin</option>
              <option value="France">France</option>
              <option value="Côte d'Ivoire">Côte d'Ivoire</option>
              <option value="Sénégal">Sénégal</option>
              <option value="Cameroun">Cameroun</option>
              <option value="Autre">Autre</option>
            </select>
            @error('pays')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="devise">Devise</label>
            <select id="devise" name="devise" style="width: 100%; padding: 11px 15px; font-size: 14px; font-family: 'DM Sans',sans-serif; border: 1px solid #e0e0ee; border-radius: 10px; background: #fafafe; color: #1a1550; outline: none;">
              <option value="FCFA" selected>FCFA</option>
              <option value="EUR">EUR</option>
              <option value="USD">USD</option>
              <option value="CAD">CAD</option>
              <option value="GBP">GBP</option>
            </select>
            @error('devise')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Décrivez votre entreprise…">{{ old('description') }}</textarea>
            @error('description')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <button type="button" class="btn" style="margin-top:1.2rem" onclick="goStep2()">Continuer →</button>
        </form>
      </div>
    </div>

    <!-- STEP 2 -->
    <div id="step2" style="display:none">
      <div class="card">
        <form method="POST" action="{{ route('register.entreprise.submit') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="step1-nom_entreprise" name="nom_entreprise" value="{{ old('nom_entreprise') }}">
          <input type="hidden" id="step1-secteur" name="secteur" value="{{ old('secteur') }}">
          <input type="hidden" id="step1-adresse" name="ville_entreprise" value="{{ old('ville_entreprise') }}">
          <input type="hidden" id="step1-pays" name="pays" value="{{ old('pays') }}">
          <input type="hidden" id="step1-devise" name="devise" value="{{ old('devise') }}">
          <input type="hidden" id="step1-description" name="description" value="{{ old('description') }}">
          
          <div class="upload-zone" onclick="document.getElementById('logo-input').click()">
            <div class="up-icon"><i class="ti ti-upload"></i></div>
            <p id="logo-label">Logo de l'entreprise</p>
            <span>PNG transparent recommandé</span>
            <input type="file" id="logo-input" name="logo" accept="image/*" onchange="updateLogoLabel(this)" />
          </div>
          <div id="logo-error" style="color: #e24b4a; font-size: 12px; margin-bottom: 1.2rem; display: none; font-weight: 500;"></div>
          @error('logo')
            <div style="color: #e24b4a; font-size: 12px; margin-bottom: 1.2rem;">{{ $message }}</div>
          @enderror
          
          <div class="field">
            <label for="email">Email professionnel</label>
            <input type="email" id="email" name="email" placeholder="rh@entreprise.com" value="{{ old('email') }}" />
            @error('email')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" placeholder="01 23 45 67 89" value="{{ old('telephone') }}" />
            @error('telephone')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="password">Mot de passe</label>
            <div class="input-wrap">
              <input type="password" id="password" name="password" placeholder="••••••••" />
              <span class="toggle-eye" onclick="togglePwd('password',this)"><i class="ti ti-eye"></i></span>
            </div>
            @error('password')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="field">
            <label for="password_confirmation">Confirmer</label>
            <div class="input-wrap">
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" />
              <span class="toggle-eye" onclick="togglePwd('password_confirmation',this)"><i class="ti ti-eye"></i></span>
            </div>
            @error('password_confirmation')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>
          <div class="cgu-line">
            <input type="checkbox" id="cgu" name="cgu" />
            <label for="cgu" style="text-transform:none;letter-spacing:0;font-size:13px;color:#7070a0;margin:0">
              J'accepte les <a href="#">CGU entreprise</a>.
            </label>
          </div>
          @error('cgu')
            <div style="color: #e24b4a; font-size: 12px;">{{ $message }}</div>
          @endif
          
          <button type="submit" class="btn">Créer mon compte entreprise</button>
          <button type="button" class="btn-ghost" onclick="goStep1()"><i class="ti ti-arrow-left"></i> Retour</button>
        </form>
      </div>
    </div>

    <div class="bottom-links">
      Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a> · <a href="{{ route('register.candidat') }}">Inscription candidat</a>
    </div>
  </div>
</div>

<script>
  function goStep2() {
    const nom = document.getElementById('nom_entreprise').value.trim();
    if (!nom) { document.getElementById('nom_entreprise').classList.add('error'); return; }
    
    // Transfer values to step 2 hidden inputs
    document.getElementById('step1-nom_entreprise').value = document.getElementById('nom_entreprise').value;
    document.getElementById('step1-secteur').value = document.getElementById('secteur').value;
    document.getElementById('step1-adresse').value = document.getElementById('adresse').value;
    document.getElementById('step1-pays').value = document.getElementById('pays').value;
    document.getElementById('step1-devise').value = document.getElementById('devise').value;
    document.getElementById('step1-description').value = document.getElementById('description').value;
    
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'block';
    document.getElementById('step-label').textContent = 'Étape 2 sur 2';
    document.getElementById('bar2').style.width = '100%';
  }

  function goStep1() {
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step1').style.display = 'block';
    document.getElementById('step-label').textContent = 'Étape 1 sur 2';
    document.getElementById('bar2').style.width = '0%';
  }

  function togglePwd(id, el) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    el.innerHTML = isText ? '<i class="ti ti-eye"></i>' : '<i class="ti ti-eye-off"></i>';
  }

  function updateLogoLabel(input) {
    const errorDiv = document.getElementById('logo-error');
    if (errorDiv) errorDiv.style.display = 'none';
    
    if (input.files.length > 0) {
      const file = input.files[0];
      const maxSize = 5 * 1024 * 1024; // 5 Mo
      
      if (file.size > maxSize) {
        if (errorDiv) {
          errorDiv.textContent = "Le fichier sélectionné dépasse la limite autorisée de 5 Mo.";
          errorDiv.style.display = 'block';
        }
        input.value = ""; // Réinitialiser le champ de fichier
        document.getElementById('logo-label').textContent = "Logo de l'entreprise";
        return;
      }
      
      document.getElementById('logo-label').textContent = file.name;
    }
  }

  ['nom_entreprise','secteur','adresse','email','telephone','password','password_confirmation'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', () => el.classList.remove('error'));
  });

  // Si des erreurs d'étape 2 sont présentes, aller directement à l'étape 2
  @if($errors->has('email') || $errors->has('telephone') || $errors->has('password') || $errors->has('password_confirmation') || $errors->has('cgu') || $errors->has('logo'))
    document.addEventListener("DOMContentLoaded", function() {
      // S'assurer que les valeurs saisies à l'étape 1 sont bien transférées
      document.getElementById('step1-nom_entreprise').value = document.getElementById('nom_entreprise').value;
      document.getElementById('step1-secteur').value = document.getElementById('secteur').value;
      document.getElementById('step1-adresse').value = document.getElementById('adresse').value;
      document.getElementById('step1-pays').value = document.getElementById('pays').value;
      document.getElementById('step1-devise').value = document.getElementById('devise').value;
      document.getElementById('step1-description').value = document.getElementById('description').value;
      
      document.getElementById('step1').style.display = 'none';
      document.getElementById('step2').style.display = 'block';
      document.getElementById('step-label').textContent = 'Étape 2 sur 2';
      document.getElementById('bar2').style.width = '100%';
    });
  @endif
</script>
</body>
</html>
