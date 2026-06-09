<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Entreprise - JobConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; padding: 0; min-height: 100vh; display: flex; }
        .left-panel {
            width: 45%;
            background: linear-gradient(135deg, #e8eaf6 0%, #c5cae9 50%, #b2ebf2 100%);
            display: flex; flex-direction: column; justify-content: center;
            padding: 3rem; position: relative; overflow: hidden;
        }
        .left-panel::before { content: ''; position: absolute; top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(99,102,241,0.15); border-radius: 50%; }
        .brand { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 3rem; position: relative; z-index: 1; }
        .brand-logo { width: 42px; height: 42px; background: #6366f1; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; }
        .brand-name { font-size: 1.2rem; font-weight: 700; color: #1A2340; }
        .hero-title { font-size: 2.2rem; font-weight: 700; color: #1A2340; line-height: 1.2; margin-bottom: 1rem; position: relative; z-index: 1; }
        .hero-sub { color: #475569; font-size: 0.95rem; margin-bottom: 2rem; position: relative; z-index: 1; }
        .feature-list { list-style: none; padding: 0; position: relative; z-index: 1; }
        .feature-list li { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: #475569; font-size: 0.9rem; }
        .feature-list li::before { content: '✓'; width: 22px; height: 22px; background: #6366f1; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0; }
        .footer-copyright { position: absolute; bottom: 1.5rem; left: 3rem; font-size: 0.8rem; color: #94a3b8; }

        .right-panel { width: 55%; display: flex; flex-direction: column; justify-content: center; padding: 3rem; background: #fff; }
        .form-title { font-size: 1.75rem; font-weight: 700; color: #1A2340; margin-bottom: 0.25rem; }
        .form-sub { color: #64748b; font-size: 0.875rem; margin-bottom: 2rem; }
        .form-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.75rem; }
        .form-label { font-size: 0.78rem; font-weight: 600; color: #374151; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.4rem; }
        .form-control { border: 1px solid #d1d5db; border-radius: 8px; padding: 0.65rem 0.875rem; font-size: 0.9rem; }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .btn-eye { border: 1px solid #d1d5db; border-left: none; background: #fff; border-radius: 0 8px 8px 0 !important; color: #9ca3af; cursor: pointer; padding: 0 0.875rem; }
        .forgot-link { color: #6366f1; text-decoration: none; font-size: 0.82rem; float: right; }
        .forgot-link:hover { text-decoration: underline; }
        .btn-login { background: #6366f1; color: #fff; border: none; border-radius: 8px; padding: 0.75rem; font-size: 0.95rem; font-weight: 600; width: 100%; margin-top: 1.25rem; transition: background 0.2s; }
        .btn-login:hover { background: #4f46e5; }
        .footer-links { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #64748b; }
        .footer-links a { color: #6366f1; text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>

<div class="left-panel">
    <div class="brand">
        <div class="brand-logo">JC</div>
        <span class="brand-name">JobConnect</span>
    </div>
    <h1 class="hero-title">Recrutez les meilleurs talents.</h1>
    <p class="hero-sub">Publiez vos offres et accédez à des milliers de candidats qualifiés au Bénin.</p>
    <ul class="feature-list">
        <li>Score de compatibilité automatique</li>
        <li>Questionnaire de préqualification</li>
        <li>Messagerie intégrée</li>
        <li>Suivi en temps réel</li>
    </ul>
    <div class="footer-copyright">© {{ date('Y') }} JobConnect Bénin</div>
</div>

<div class="right-panel">
    <h2 class="form-title">Connexion entreprise</h2>
    <p class="form-sub">Accédez à votre espace recruteur</p>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('entreprise.login.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email professionnel</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="rh@entreprise.com" value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0">Mot de passe</label>
                    <a href="{{ route('entreprise.reset.password') }}" class="forgot-link">Mot de passe oublié ?</a>
                </div>
                <div class="input-group">
                    <input type="password" name="mot_de_passe" id="mdp"
                        class="form-control @error('mot_de_passe') is-invalid @enderror"
                        placeholder="••••••••">
                    <button type="button" class="btn-eye" onclick="toggleMdp()">👁</button>
                </div>
                @error('mot_de_passe') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-login">Se connecter</button>
        </form>
    </div>

    <div class="footer-links">
        Pas encore de compte ? <a href="{{ route('entreprise.inscription.etape1') }}">Inscription entreprise</a>
    </div>
</div>

<script>
function toggleMdp() {
    const input = document.getElementById('mdp');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>