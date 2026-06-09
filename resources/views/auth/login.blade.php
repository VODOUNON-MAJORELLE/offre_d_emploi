<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion — Talentlink</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --accent:#5b4be8;--accent2:#7c6ff0;
  --t1:#1a1a2e;--t2:#6b7280;--t3:#9ca3af;
  --border:rgba(0,0,0,0.09);--card:#fff;
  --r:12px;--rs:10px;
}
html,body{height:100%;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif}
body{display:flex;min-height:100vh}

/* ---- LEFT PANEL ---- */
.left{
  flex:0 0 50%;
  background:linear-gradient(145deg,#c7d8f8 0%,#b8d4f5 20%,#a5c8f0 40%,#9ec4ee 60%,#d4e8f9 80%,#e8f4ff 100%);
  display:flex;flex-direction:column;justify-content:space-between;
  padding:28px 40px 28px;position:relative;overflow:hidden;
}
/* blobs */
.blob{position:absolute;border-radius:50%;filter:blur(60px);opacity:.45;pointer-events:none}
.blob1{width:320px;height:320px;background:rgba(124,111,240,.35);top:-60px;left:-60px}
.blob2{width:220px;height:220px;background:rgba(56,189,248,.3);top:140px;left:160px}
.blob3{width:180px;height:180px;background:rgba(167,139,250,.25);bottom:120px;right:-40px}

.left-logo{display:flex;align-items:center;gap:10px;z-index:1;position:relative}
.logo-av{width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#7c6ff0,#5b4be8);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff}
.logo-name{font-size:17px;font-weight:700;color:var(--t1)}

.left-body{z-index:1;position:relative}
.left-title{font-size:38px;font-weight:800;color:var(--t1);line-height:1.2;margin-bottom:16px;max-width:400px}
.left-sub{font-size:14px;color:#4b5563;margin-bottom:32px}
.features{list-style:none;display:flex;flex-direction:column;gap:12px}
.features li{display:flex;align-items:center;gap:10px;font-size:14px;color:#374151;font-weight:500}
.feat-check{width:22px;height:22px;border-radius:6px;background:rgba(91,75,232,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.feat-check i{font-size:13px;color:var(--accent)}

.left-footer{font-size:12px;color:#6b7280;z-index:1;position:relative}
.left-footer strong{font-weight:600;color:#374151}

/* ---- RIGHT PANEL ---- */
.right{
  flex:1;background:#f2f4f8;
  display:flex;flex-direction:column;justify-content:center;
  padding:40px 60px;
}
.back-link{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--t2);text-decoration:none;margin-bottom:32px;transition:color .12s;width:fit-content}
.back-link:hover{color:var(--t1)}

.form-title{font-size:26px;font-weight:800;color:var(--t1);margin-bottom:6px}
.form-sub{font-size:14px;color:var(--t2);margin-bottom:24px}
.form-sub strong{color:var(--accent);font-weight:700}

/* Mode toggle */
.mode-toggle{display:flex;gap:4px;background:#e5e7eb;border-radius:var(--rs);padding:3px;margin-bottom:28px}
.mode-btn{flex:1;padding:10px 16px;border:none;border-radius:8px;font-size:13px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:7px;background:transparent;color:var(--t2)}
.mode-btn.active{background:#fff;color:var(--accent);box-shadow:0 1px 4px rgba(0,0,0,.08)}
.mode-btn i{font-size:16px}

/* Fields */
.field{margin-bottom:18px}
.field-label{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--t2);margin-bottom:7px}
.input-wrap{position:relative}
.f-input{
  width:100%;
  border:0.5px solid var(--border);
  border-radius:var(--rs);
  padding:14px 16px;
  font-size:14px;font-family:inherit;
  color:var(--t1);
  background:#fff;
  outline:none;
  transition:border-color .15s,box-shadow .15s;
  box-shadow:0 1px 3px rgba(0,0,0,.04);
}
.f-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(91,75,232,.1)}
.f-input::placeholder{color:var(--t3)}
.f-input.is-invalid{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1)}
.toggle-pw{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:17px;color:var(--t3);transition:color .12s}
.toggle-pw:hover{color:var(--t1)}

.row-remember{display:flex;align-items:center;justify-content:space-between;margin-bottom:26px}
.remember{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--t2);user-select:none}
.remember input{width:15px;height:15px;accent-color:var(--accent);cursor:pointer}
.forgot{font-size:13px;color:var(--accent);font-weight:500;text-decoration:none;transition:opacity .12s}
.forgot:hover{opacity:.75}

.submit-btn{
  width:100%;padding:15px;
  border:none;border-radius:var(--rs);
  background:linear-gradient(135deg,#7c6ff0,#5b4be8);
  color:#fff;font-size:15px;font-weight:600;font-family:inherit;
  cursor:pointer;transition:opacity .15s,transform .1s;
  margin-bottom:22px;letter-spacing:.01em;
  box-shadow:0 4px 16px rgba(91,75,232,.3);
}
.submit-btn:hover{opacity:.9}
.submit-btn:active{transform:scale(.99)}

.links{text-align:center;display:flex;flex-direction:column;gap:8px}
.link-row{font-size:13px;color:var(--t2)}
.link-row a{color:var(--accent);font-weight:600;text-decoration:none;transition:opacity .12s}
.link-row a:hover{opacity:.75}

/* Error alert */
.alert-error{background:#fee2e2;border:0.5px solid #fca5a5;border-radius:var(--rs);padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:13px;color:#991b1b}
.alert-error i{font-size:17px;color:#ef4444;flex-shrink:0}
.alert-success{background:#d1fae5;border:0.5px solid #6ee7b7;border-radius:var(--rs);padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:13px;color:#065f46}
.alert-success i{font-size:17px;color:#10b981;flex-shrink:0}

/* max width for form */
.form-inner{max-width:440px;width:100%}

@media(max-width:768px){
  body{flex-direction:column}
  .left{flex:0 0 auto;padding:24px;min-height:280px}
  .left-title{font-size:26px}
  .right{padding:32px 24px}
}
</style>
</head>
<body>

<!-- LEFT -->
<div class="left">
  <div class="blob blob1"></div>
  <div class="blob blob2"></div>
  <div class="blob blob3"></div>

  <div class="left-logo">
    <div class="logo-av">JR</div>
    <span class="logo-name">Talentlink</span>
  </div>

  <div class="left-body">
    <div class="left-title">Trouvez votre place dans le monde professionnel.</div>
    <div class="left-sub">Matchés avec le job fait pour vous grâce à notre IA.</div>
    <ul class="features">
      <li>
        <div class="feat-check"><i class="ti ti-check"></i></div>
        Matching IA avancé
      </li>
      <li>
        <div class="feat-check"><i class="ti ti-check"></i></div>
        12 000+ offres vérifiées
      </li>
      <li>
        <div class="feat-check"><i class="ti ti-check"></i></div>
        Messagerie intégrée
      </li>
      <li>
        <div class="feat-check"><i class="ti ti-check"></i></div>
        Suivi en temps réel
      </li>
    </ul>
  </div>

  <div class="left-footer">© 2026 <strong>Talentlink</strong></div>
</div>

<!-- RIGHT -->
<div class="right">
  <div class="form-inner">
    <a href="/" class="back-link"><i class="ti ti-arrow-left"></i> Retour à l'accueil</a>

    <div class="form-title">Connexion</div>
    <div class="form-sub">Bon retour sur <strong>Talentlink</strong> !</div>

    {{-- Error messages --}}
    @if($errors->any())
      <div class="alert-error">
        <i class="ti ti-alert-circle"></i>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    @if(session('success'))
      <div class="alert-success">
        <i class="ti ti-circle-check"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if(isset($error))
      <div class="alert-error">
        <i class="ti ti-alert-circle"></i>
        <span>{{ $error }}</span>
      </div>
    @endif

    <form id="login-form" method="POST" action="{{ route('login.submit') }}">
      @csrf
      <input type="hidden" name="mode" id="login-mode" value="candidat">

      <div class="field">
        <div class="field-label">Email</div>
        <div class="input-wrap">
          <input class="f-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" autocomplete="email" required>
        </div>
      </div>

      <div class="field">
        <div class="field-label">Mot de passe</div>
        <div class="input-wrap">
          <input class="f-input @error('password') is-invalid @enderror" id="pw-input" type="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
          <button class="toggle-pw" onclick="togglePw()" type="button" id="pw-toggle">
            <i class="ti ti-eye" id="pw-icon"></i>
          </button>
        </div>
      </div>

      <div class="row-remember">
        <label class="remember">
          <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
        <a href="{{ route('password.request') }}" class="forgot">Mot de passe oublié ?</a>
      </div>

      <button type="submit" class="submit-btn" id="submit-btn">Se connecter</button>
    </form>

    <div class="links">
      <div class="link-row">Pas encore de compte ? <a href="{{ route('register.candidat') }}">Inscrivez-vous</a></div>
      <div class="link-row">Vous recrutez ? <a href="{{ route('register.entreprise') }}">Compte entreprise</a></div>
      <div class="link-row"><a href="{{ route('login.admin') }}" style="color: var(--t2);">Connexion Admin</a></div>
    </div>
  </div>
</div>

<script>
let currentMode = 'candidat';

function switchMode(mode) {
  currentMode = mode;
  document.getElementById('login-mode').value = mode;

  const btnC = document.getElementById('btn-candidat');
  const btnE = document.getElementById('btn-entreprise');
  const switchLink = document.getElementById('switch-link');

  if (mode === 'candidat') {
    btnC.classList.add('active');
    btnE.classList.remove('active');
    switchLink.innerHTML = 'Vous recrutez ? <a href="#" onclick="switchMode(\'entreprise\');return false;">Compte entreprise</a>';
  } else {
    btnE.classList.add('active');
    btnC.classList.remove('active');
    switchLink.innerHTML = 'Vous êtes candidat ? <a href="#" onclick="switchMode(\'candidat\');return false;">Compte candidat</a>';
  }
}

function togglePw() {
  const inp = document.getElementById('pw-input');
  const icon = document.getElementById('pw-icon');
  if (inp.type === 'password') {
    inp.type = 'text';
    icon.className = 'ti ti-eye-off';
  } else {
    inp.type = 'password';
    icon.className = 'ti ti-eye';
  }
}

// Animate button on submit
document.getElementById('login-form').addEventListener('submit', function() {
  const btn = document.getElementById('submit-btn');
  btn.textContent = 'Connexion en cours…';
  btn.style.opacity = '.7';
  btn.style.pointerEvents = 'none';
});

// If returning with old mode value
@if(old('mode') === 'entreprise')
  switchMode('entreprise');
@endif
</script>
</body>
</html>
