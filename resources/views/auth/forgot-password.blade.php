<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Mot de passe oublié</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f4f5fa;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .wrapper {
      display: flex;
      width: 100%;
      max-width: 980px;
      min-height: 600px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 40px rgba(60, 52, 137, 0.12);
    }

    /* ── LEFT PANEL ── */
    .panel-left {
      flex: 1;
      background: linear-gradient(145deg, #dde8ff 0%, #c8d8fa 40%, #bfcff7 70%, #d4e4fe 100%);
      padding: 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(40px);
      pointer-events: none;
    }
    .blob-1 { width: 240px; height: 240px; background: rgba(160, 190, 255, 0.5); top: 20px; left: 10px; }
    .blob-2 { width: 180px; height: 180px; background: rgba(130, 170, 255, 0.35); bottom: 80px; right: 10px; filter: blur(32px); }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 1;
      position: relative;
    }

    .logo-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: #5040e8;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Syne', sans-serif;
      font-weight: 600;
      font-size: 13px;
      color: #fff;
    }

    .logo-name {
      font-family: 'Syne', sans-serif;
      font-weight: 600;
      font-size: 16px;
      color: #2d2560;
    }

    .hero {
      z-index: 1;
      position: relative;
    }

    .hero h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 32px;
      line-height: 1.2;
      color: #1a1550;
      margin-bottom: 14px;
    }

    .hero p {
      font-size: 13.5px;
      color: #3d3870;
      line-height: 1.65;
      margin-bottom: 28px;
    }

    .features {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .features li {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 13.5px;
      color: #3a3575;
    }

    .feat-icon {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: rgba(80, 64, 232, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .feat-icon i {
      font-size: 12px;
      color: #4f40d8;
    }

    .footer-copy {
      font-size: 12px;
      color: #7070a0;
      z-index: 1;
      position: relative;
    }

    .footer-copy strong { color: #3a3575; }

    /* ── RIGHT PANEL ── */
    .panel-right {
      flex: 1.05;
      background: #fff;
      padding: 2.5rem 2.8rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      font-size: 13.5px;
      color: #7070a0;
      text-decoration: none;
      margin-bottom: 2.2rem;
      transition: color 0.15s;
    }

    .back-link:hover { color: #1a1550; }

    .card {
      background: #fff;
      border: 1px solid #e8e8f0;
      border-radius: 18px;
      padding: 2.2rem;
      max-width: 420px;
    }

    .key-icon {
      width: 56px;
      height: 56px;
      border-radius: 14px;
      background: #f0eeff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 1.4rem;
    }

    .card h2 {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 21px;
      color: #1a1550;
      margin-bottom: 7px;
    }

    .card .subtitle {
      font-size: 13.5px;
      color: #7070a0;
      line-height: 1.6;
      margin-bottom: 1.6rem;
    }

    label {
      display: block;
      font-size: 11px;
      font-weight: 500;
      letter-spacing: 0.07em;
      text-transform: uppercase;
      color: #7070a0;
      margin-bottom: 7px;
    }

    input[type="email"] {
      width: 100%;
      padding: 11px 15px;
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      border: 1px solid #e0e0ee;
      border-radius: 10px;
      background: #fafafe;
      color: #1a1550;
      outline: none;
      transition: border-color 0.15s, box-shadow 0.15s;
    }

    input[type="email"]::placeholder { color: #b0b0c8; }

    input[type="email"]:focus {
      border-color: #5040e8;
      box-shadow: 0 0 0 3px rgba(80, 64, 232, 0.12);
      background: #fff;
    }

    input[type="email"].error {
      border-color: #e24b4a;
      box-shadow: 0 0 0 3px rgba(226, 75, 74, 0.1);
    }

    .error-msg {
      display: none;
      font-size: 12px;
      color: #e24b4a;
      margin-top: 5px;
    }

    @if ($errors->has('email'))
      .error-msg { display: block; }
    @endif

    .btn-send {
      width: 100%;
      margin-top: 1.3rem;
      padding: 13px;
      font-size: 14.5px;
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      color: #fff;
      background: linear-gradient(135deg, #5040e8, #6c5ce7);
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: opacity 0.15s, transform 0.1s;
    }

    .btn-send:hover { opacity: 0.92; }
    .btn-send:active { transform: scale(0.985); }

    /* ── SUCCESS STATE ── */
    @if(session('status'))
      #form-view { display: none; }
      #success-view { display: flex; }
    @else
      #success-view { display: none; }
    @endif

    #success-view {
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 0.5rem 0;
    }

    .success-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: #eaf3de;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 1.2rem;
    }

    #success-view h3 {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 19px;
      color: #1a1550;
      margin-bottom: 8px;
    }

    #success-view p {
      font-size: 13.5px;
      color: #7070a0;
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }

    #success-view a {
      font-size: 13.5px;
      color: #5040e8;
      text-decoration: none;
      font-weight: 500;
    }

    #success-view a:hover { text-decoration: underline; }

    /* ── RESPONSIVE ── */
    @media (max-width: 700px) {
      .panel-left { display: none; }
      .panel-right { padding: 2rem 1.5rem; }
      .card { max-width: 100%; }
    }
  </style>
</head>
<body>

  <div class="wrapper">

    <!-- LEFT PANEL -->
    <div class="panel-left">
      <div class="blob blob-1"></div>
      <div class="blob blob-2"></div>

      <div class="logo">
        <div class="logo-avatar">JR</div>
        <span class="logo-name">Talentlink</span>
      </div>

      <div class="hero">
        <h1>Récupérez l'accès à votre compte.</h1>
        <p>Nous vous enverrons un lien sécurisé pour réinitialiser votre mot de passe.</p>
        <ul class="features">
          <li>
            <span class="feat-icon"><i class="ti ti-sparkles"></i></span>
            Matching IA avancé
          </li>
          <li>
            <span class="feat-icon"><i class="ti ti-briefcase"></i></span>
            12 000+ offres vérifiées
          </li>
          <li>
            <span class="feat-icon"><i class="ti ti-message-2"></i></span>
            Messagerie intégrée
          </li>
          <li>
            <span class="feat-icon"><i class="ti ti-eye"></i></span>
            Suivi en temps réel
          </li>
        </ul>
      </div>

      <div class="footer-copy">© 2026 <strong>Talentlink</strong></div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="panel-right">
      <a href="{{ route('login') }}" class="back-link">
        <i class="ti ti-arrow-left"></i> Retour à la connexion
      </a>

      <div class="card">

        <!-- FORM VIEW -->
        <div id="form-view">
          <div class="key-icon">🔑</div>
          <h2>Mot de passe oublié ?</h2>
          <p class="subtitle">Entrez votre email pour recevoir un lien de réinitialisation.</p>

          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email-input">Adresse email</label>
            <input type="email" id="email-input" name="email" placeholder="votre@email.com" value="{{ old('email') }}" />
            <span class="error-msg" id="error-msg">
              @error('email')
                {{ $message }}
              @enderror
            </span>

            <button type="submit" class="btn-send">Envoyer le lien</button>
          </form>
        </div>

        <!-- SUCCESS VIEW -->
        <div id="success-view">
          <div class="success-icon">✅</div>
          <h3>Email envoyé !</h3>
          <p>Un lien de réinitialisation a été envoyé à votre adresse email.<br>Vérifiez votre boîte mail (et les spams).</p>
          <a href="{{ route('login') }}">← Retour à la connexion</a>
        </div>

      </div>
    </div>

  </div>

</body>
</html>
