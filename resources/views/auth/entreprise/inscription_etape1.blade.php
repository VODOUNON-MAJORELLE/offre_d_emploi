<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Entreprise - JobConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; padding: 0; min-height: 100vh; display: flex; }

        .left-panel {
            width: 45%;
            background: linear-gradient(135deg, #e8eaf6 0%, #c5cae9 50%, #b2ebf2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px; left: -100px;
            width: 400px; height: 400px;
            background: rgba(99,102,241,0.15);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 300px; height: 300px;
            background: rgba(99,102,241,0.1);
            border-radius: 50%;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            position: relative; z-index: 1;
        }
        .brand-logo {
            width: 42px; height: 42px;
            background: #6366f1;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
        }
        .brand-name { font-size: 1.2rem; font-weight: 700; color: #1A2340; }
        .hero-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1A2340;
            line-height: 1.2;
            margin-bottom: 1rem;
            position: relative; z-index: 1;
        }
        .hero-sub {
            color: #475569;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            position: relative; z-index: 1;
        }
        .feature-list { list-style: none; padding: 0; position: relative; z-index: 1; }
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            color: #475569;
            font-size: 0.9rem;
        }
        .feature-list li::before {
            content: '✓';
            width: 22px; height: 22px;
            background: #6366f1;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            flex-shrink: 0;
        }

        .right-panel {
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem;
            background: #fff;
        }
        .back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .back-link:hover { color: #6366f1; }
        .form-title { font-size: 1.75rem; font-weight: 700; color: #1A2340; margin-bottom: 0.25rem; }
        .step-info { color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem; }

        /* Progress bar */
        .progress-steps { display: flex; gap: 0.5rem; margin-bottom: 2rem; }
        .step-bar {
            height: 4px;
            border-radius: 2px;
            flex: 1;
        }
        .step-bar.active { background: #6366f1; }
        .step-bar.inactive { background: #e2e8f0; }

        .form-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.75rem;
        }
        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #374151;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }
        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0.65rem 0.875rem;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .btn-continuer {
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1.25rem;
            transition: background 0.2s;
        }
        .btn-continuer:hover { background: #4f46e5; }
        .footer-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #64748b;
        }
        .footer-links a { color: #6366f1; text-decoration: none; font-weight: 500; }
        .footer-copyright {
            position: absolute;
            bottom: 1.5rem;
            left: 3rem;
            font-size: 0.8rem;
            color: #94a3b8;
        }
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
    <a href="/" class="back-link">← Retour</a>
    <h2 class="form-title">Inscription entreprise</h2>
    <p class="step-info">Étape 1 sur 2</p>

    <div class="progress-steps">
        <div class="step-bar active"></div>
        <div class="step-bar inactive"></div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('entreprise.inscription.etape1.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom de l'entreprise</label>
                <input type="text" name="nom_entreprise" class="form-control @error('nom_entreprise') is-invalid @enderror"
                    placeholder="TechVision" value="{{ old('nom_entreprise') }}">
                @error('nom_entreprise') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Secteur d'activité</label>
                <input type="text" name="secteur_activite" class="form-control @error('secteur_activite') is-invalid @enderror"
                    placeholder="Informatique, Finance, Santé..." value="{{ old('secteur_activite') }}">
                @error('secteur_activite') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" name="ville_entreprise" class="form-control @error('ville_entreprise') is-invalid @enderror"
                    placeholder="Cotonou, Bénin" value="{{ old('ville_entreprise') }}">
                @error('ville_entreprise') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    rows="3" placeholder="Décrivez votre entreprise...">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-continuer">Continuer →</button>
        </form>
    </div>

    <div class="footer-links">
        Déjà un compte ? <a href="{{ route('entreprise.login') }}">Se connecter</a>
    </div>
</div>

</body>
</html>