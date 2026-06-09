<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation mot de passe - JobConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; padding: 0; min-height: 100vh; display: flex; }
        .left-panel { width: 45%; background: linear-gradient(135deg, #e8eaf6 0%, #c5cae9 50%, #b2ebf2 100%); display: flex; flex-direction: column; justify-content: center; padding: 3rem; position: relative; overflow: hidden; }
        .left-panel::before { content: ''; position: absolute; top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(99,102,241,0.15); border-radius: 50%; }
        .brand { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 3rem; position: relative; z-index: 1; }
        .brand-logo { width: 42px; height: 42px; background: #6366f1; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; }
        .brand-name { font-size: 1.2rem; font-weight: 700; color: #1A2340; }
        .hero-title { font-size: 2rem; font-weight: 700; color: #1A2340; line-height: 1.2; margin-bottom: 1rem; position: relative; z-index: 1; }
        .hero-sub { color: #475569; font-size: 0.95rem; position: relative; z-index: 1; }
        .feature-list { list-style: none; padding: 0; position: relative; z-index: 1; margin-top: 2rem; }
        .feature-list li { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: #475569; font-size: 0.9rem; }
        .feature-list li::before { content: '✓'; width: 22px; height: 22px; background: #6366f1; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0; }

        .right-panel { width: 55%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 3rem; background: #fff; }
        .reset-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 420px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .reset-icon { width: 64px; height: 64px; background: #ede9fe; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1.25rem; }
        .reset-title { font-size: 1.5rem; font-weight: 700; color: #1A2340; text-align: center; margin-bottom: 0.4rem; }
        .reset-sub { color: #64748b; font-size: 0.875rem; text-align: center; margin-bottom: 1.75rem; }
        .form-label { font-size: 0.78rem; font-weight: 600; color: #374151; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.4rem; }
        .form-control { border: 1px solid #d1d5db; border-radius: 8px; padding: 0.65rem 0.875rem; font-size: 0.9rem; }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .btn-send { background: #6366f1; color: #fff; border: none; border-radius: 8px; padding: 0.75rem; font-size: 0.95rem; font-weight: 600; width: 100%; margin-top: 1rem; }
        .btn-send:hover { background: #4f46e5; }
        .back-link { color: #6366f1; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1.25rem; }
    </style>
</head>
<body>
<div class="left-panel">
    <div class="brand">
        <div class="brand-logo">JC</div>
        <span class="brand-name">JobConnect</span>
    </div>
    <h1 class="hero-title">Sécurisez votre compte.</h1>
    <p class="hero-sub">Choisissez un mot de passe fort pour protéger votre compte.</p>
    <ul class="feature-list">
        <li>Score de compatibilité automatique</li>
        <li>Questionnaire de préqualification</li>
        <li>Messagerie intégrée</li>
        <li>Suivi en temps réel</li>
    </ul>
</div>

<div class="right-panel">
    <div class="reset-card">
        <div class="reset-icon">🔒</div>
        <h2 class="reset-title">Mot de passe oublié ?</h2>
        <p class="reset-sub">Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>

        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('entreprise.reset.password.send') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="rh@entreprise.com" value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn-send">Envoyer le lien</button>
        </form>

        <a href="{{ route('entreprise.login') }}" class="back-link">← Retour à la connexion</a>
    </div>
</div>
</body>
</html>