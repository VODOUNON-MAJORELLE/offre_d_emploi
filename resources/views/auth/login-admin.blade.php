<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion Admin — Talentlink</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f0f2f7; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
    .container { width: 100%; max-width: 400px; background: #fff; border-radius: 16px; padding: 2.5rem; box-shadow: 0 8px 40px rgba(0,0,0,0.08); }
    .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 2rem; }
    .logo-av { width: 40px; height: 40px; border-radius: 8px; background: #5b4be8; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; color: #fff; }
    .logo-name { font-weight: 700; font-size: 18px; color: #1a1a2e; }
    .title { font-size: 24px; font-weight: 700; margin-bottom: 0.5rem; color: #1a1a2e; }
    .subtitle { font-size: 14px; color: #6b7280; margin-bottom: 2rem; }
    .field { margin-bottom: 1.25rem; }
    .label { display: block; font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .input { width: 100%; padding: 12px 16px; font-size: 14px; border: 1px solid #e0e0ee; border-radius: 8px; background: #fafafe; color: #1a1a2e; outline: none; transition: all 0.15s; }
    .input:focus { border-color: #5b4be8; background: #fff; box-shadow: 0 0 0 3px rgba(91, 75, 232, 0.1); }
    .input::placeholder { color: #9ca3af; }
    .input.error { border-color: #ef4444; }
    .btn { width: 100%; padding: 14px; font-size: 15px; font-weight: 600; color: #fff; background: linear-gradient(135deg, #5b4be8, #7c6ff0); border: none; border-radius: 8px; cursor: pointer; transition: opacity 0.15s; margin-top: 0.5rem; }
    .btn:hover { opacity: 0.92; }
    .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; color: #6b7280; text-decoration: none; margin-top: 1.5rem; transition: color 0.15s; }
    .back-link:hover { color: #1a1a2e; }
    .error { color: #ef4444; font-size: 13px; margin-top: 5px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <div class="logo-av">AD</div>
      <span class="logo-name">Talentlink Admin</span>
    </div>
    <h1 class="title">Connexion Admin</h1>
    <p class="subtitle">Accédez au panneau d'administration</p>

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf
      <input type="hidden" name="user_type" value="admin">
      
      <div class="field">
        <label class="label" for="email">Email</label>
        <input type="email" id="email" name="email" class="input" placeholder="admin@talentlink.com" value="{{ old('email') }}" required>
        @error('email')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="field">
        <label class="label" for="password">Mot de passe</label>
        <input type="password" id="password" name="password" class="input" placeholder="••••••••" required>
        @error('password')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn">Se connecter</button>
    </form>

    <a href="{{ route('login') }}" class="back-link">
      <i class="ti ti-arrow-left"></i> Retour à la connexion
    </a>
  </div>
</body>
</html>
