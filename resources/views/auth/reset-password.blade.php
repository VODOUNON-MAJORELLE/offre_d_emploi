<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Nouveau mot de passe</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; background: #f4f5fa; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .wrapper { display: flex; width: 100%; max-width: 980px; min-height: 600px; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 40px rgba(60,52,137,0.12); }
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
    .panel-right { flex: 1.05; background: #fff; padding: 2.5rem 2.8rem; display: flex; flex-direction: column; justify-content: center; }
    .card { background: #fff; border: 1px solid #e8e8f0; border-radius: 18px; padding: 2.2rem; max-width: 440px; }
    .lock-icon { width: 56px; height: 56px; border-radius: 14px; background: #f0eeff; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 1.4rem; }
    .card h2 { font-family: 'Syne',sans-serif; font-weight: 700; font-size: 21px; color: #1a1550; margin-bottom: 7px; }
    .card .subtitle { font-size: 13.5px; color: #7070a0; line-height: 1.6; margin-bottom: 1.6rem; }
    .field { margin-bottom: 1.1rem; }
    label { display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.07em; text-transform: uppercase; color: #7070a0; margin-bottom: 7px; }
    .input-wrap { position: relative; }
    .input-wrap input { width: 100%; padding: 11px 42px 11px 15px; font-size: 14px; font-family: 'DM Sans',sans-serif; border: 1px solid #e0e0ee; border-radius: 10px; background: #fafafe; color: #1a1550; outline: none; transition: border-color 0.15s, box-shadow 0.15s; }
    .input-wrap input::placeholder { color: #b0b0c8; }
    .input-wrap input:focus { border-color: #5040e8; box-shadow: 0 0 0 3px rgba(80,64,232,0.12); background: #fff; }
    .input-wrap input.error { border-color: #e24b4a; box-shadow: 0 0 0 3px rgba(226,75,74,0.1); }
    .toggle-eye { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #b0b0c8; font-size: 17px; transition: color 0.15s; }
    .toggle-eye:hover { color: #5040e8; }
    .rules { list-style: none; display: flex; flex-direction: column; gap: 7px; margin: 1rem 0 1.4rem; }
    .rules li { display: flex; align-items: center; gap: 9px; font-size: 12.5px; color: #b0b0c8; transition: color 0.2s; }
    .rules li.ok { color: #3b6d11; }
    .rules li.ok .dot { background: #639922; }
    .rules li .dot { width: 8px; height: 8px; border-radius: 50%; background: #d0d0e0; flex-shrink: 0; transition: background 0.2s; }
    .btn { width: 100%; padding: 13px; font-size: 14.5px; font-family: 'DM Sans',sans-serif; font-weight: 500; color: #fff; background: linear-gradient(135deg,#5040e8,#6c5ce7); border: none; border-radius: 10px; cursor: pointer; transition: opacity 0.15s, transform 0.1s; }
    .btn:hover { opacity: 0.92; }
    .btn:active { transform: scale(0.985); }
    @if(session('status'))
      #form-view { display: none; }
      #success-view { display: flex; }
    @else
      #success-view { display: none; }
    @endif
    .success-view { flex-direction: column; align-items: center; text-align: center; padding: 0.5rem 0; }
    .success-icon { width: 60px; height: 60px; border-radius: 50%; background: #eaf3de; display: flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 1.2rem; }
    .success-view h3 { font-family: 'Syne',sans-serif; font-weight: 700; font-size: 19px; color: #1a1550; margin-bottom: 8px; }
    .success-view p { font-size: 13.5px; color: #7070a0; line-height: 1.6; margin-bottom: 1.5rem; }
    .success-view a { font-size: 13.5px; color: #5040e8; text-decoration: none; font-weight: 500; }
    @media (max-width: 700px) { .panel-left { display: none; } .panel-right { padding: 2rem 1.5rem; } .card { max-width: 100%; } }
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
      <h1>Sécurisez votre compte.</h1>
      <p>Choisissez un mot de passe fort pour protéger votre compte.</p>
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
    <div class="card">
      <div id="form-view">
        <div class="lock-icon">🔒</div>
        <h2>Nouveau mot de passe</h2>
        <p class="subtitle">Choisissez un mot de passe sécurisé.</p>

        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ request('token') }}">
          <input type="hidden" name="email" value="{{ request('email') }}">

          <div class="field">
            <label for="password">Nouveau mot de passe</label>
            <div class="input-wrap">
              <input type="password" id="password" name="password" placeholder="••••••••" oninput="checkRules()" />
              <span class="toggle-eye" onclick="togglePwd('password',this)"><i class="ti ti-eye"></i></span>
            </div>
            @error('password')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>

          <div class="field">
            <label for="password_confirmation">Confirmer</label>
            <div class="input-wrap">
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" oninput="checkRules()" />
              <span class="toggle-eye" onclick="togglePwd('password_confirmation',this)"><i class="ti ti-eye"></i></span>
            </div>
            @error('password_confirmation')
              <div style="color: #e24b4a; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
          </div>

          <ul class="rules">
            <li id="r-len"><span class="dot"></span>Au moins 8 caractères</li>
            <li id="r-maj"><span class="dot"></span>Une majuscule</li>
            <li id="r-num"><span class="dot"></span>Un chiffre</li>
            <li id="r-match"><span class="dot"></span>Les mots de passe correspondent</li>
          </ul>

          <button type="submit" class="btn">Enregistrer le mot de passe</button>
        </form>
      </div>

      <div class="success-view" id="success-view">
        <div class="success-icon">✅</div>
        <h3>Mot de passe mis à jour !</h3>
        <p>Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.</p>
        <a href="{{ route('login') }}">Se connecter →</a>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePwd(id, el) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    el.innerHTML = isText ? '<i class="ti ti-eye"></i>' : '<i class="ti ti-eye-off"></i>';
  }

  function checkRules() {
    const p = document.getElementById('password').value;
    const p2 = document.getElementById('password_confirmation').value;
    setRule('r-len', p.length >= 8);
    setRule('r-maj', /[A-Z]/.test(p));
    setRule('r-num', /[0-9]/.test(p));
    setRule('r-match', p.length > 0 && p === p2);
  }

  function setRule(id, ok) {
    const el = document.getElementById(id);
    el.classList.toggle('ok', ok);
  }
</script>
</body>
</html>
