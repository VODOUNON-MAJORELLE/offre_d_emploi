<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Entreprise - Étape 2 - JobConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { margin: 0; padding: 0; min-height: 100vh; display: flex; }
        .left-panel {
            width: 45%;
            background: linear-gradient(135deg, #e8eaf6 0%, #c5cae9 50%, #b2ebf2 100%);
            display: flex; flex-direction: column;
            justify-content: center; padding: 3rem;
            position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute;
            top: -100px; left: -100px;
            width: 400px; height: 400px;
            background: rgba(99,102,241,0.15); border-radius: 50%;
        }
        .brand { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 3rem; position: relative; z-index: 1; }
        .brand-logo { width: 42px; height: 42px; background: #6366f1; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; }
        .brand-name { font-size: 1.2rem; font-weight: 700; color: #1A2340; }
        .hero-title { font-size: 2.2rem; font-weight: 700; color: #1A2340; line-height: 1.2; margin-bottom: 1rem; position: relative; z-index: 1; }
        .hero-sub { color: #475569; font-size: 0.95rem; margin-bottom: 2rem; position: relative; z-index: 1; }
        .feature-list { list-style: none; padding: 0; position: relative; z-index: 1; }
        .feature-list li { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; color: #475569; font-size: 0.9rem; }
        .feature-list li::before { content: '✓'; width: 22px; height: 22px; background: #6366f1; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0; }
        .footer-copyright { position: absolute; bottom: 1.5rem; left: 3rem; font-size: 0.8rem; color: #94a3b8; }

        .right-panel { width: 55%; display: flex; flex-direction: column; justify-content: center; padding: 3rem; background: #fff; overflow-y: auto; }
        .back-link { color: #64748b; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem; }
        .back-link:hover { color: #6366f1; }
        .form-title { font-size: 1.75rem; font-weight: 700; color: #1A2340; margin-bottom: 0.25rem; }
        .step-info { color: #64748b; font-size: 0.875rem; margin-bottom: 1.5rem; }
        .progress-steps { display: flex; gap: 0.5rem; margin-bottom: 2rem; }
        .step-bar { height: 4px; border-radius: 2px; flex: 1; }
        .step-bar.active { background: #6366f1; }

        .form-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.75rem; }

        /* Logo upload zone */
        .logo-upload {
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s;
            margin-bottom: 1.25rem;
            background: #fff;
        }
        .logo-upload:hover { border-color: #6366f1; }
        .logo-upload-icon {
            width: 48px; height: 48px;
            background: #ede9fe;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.2rem; color: #6366f1;
        }
        .logo-upload p { margin: 0; font-size: 0.875rem; font-weight: 600; color: #374151; }
        .logo-upload small { color: #9ca3af; font-size: 0.8rem; }

        .form-label { font-size: 0.78rem; font-weight: 600; color: #374151; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.4rem; }
        .form-control { border: 1px solid #d1d5db; border-radius: 8px; padding: 0.65rem 0.875rem; font-size: 0.9rem; transition: border-color 0.2s; }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }

        .input-group .form-control { border-radius: 8px !important; }
        .btn-eye { border: 1px solid #d1d5db; border-left: none; background: #fff; border-radius: 0 8px 8px 0 !important; color: #9ca3af; cursor: pointer; padding: 0 0.875rem; }

        .cgu-link { color: #6366f1; text-decoration: none; font-weight: 500; }

        .btn-creer {
            background: #6366f1; color: #fff; border: none;
            border-radius: 8px; padding: 0.75rem;
            font-size: 0.95rem; font-weight: 600;
            width: 100%; margin-top: 1.25rem; transition: background 0.2s;
        }
        .btn-creer:hover { background: #4f46e5; }

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
    <a href="{{ route('entreprise.inscription.etape1') }}" class="back-link">← Retour</a>
    <h2 class="form-title">Inscription entreprise</h2>
    <p class="step-info">Étape 2 sur 2</p>

    <div class="progress-steps">
        <div class="step-bar active"></div>
        <div class="step-bar active"></div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('entreprise.inscription.etape2.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Logo upload -->
            <div class="logo-upload" onclick="document.getElementById('logo').click()">
                <div class="logo-upload-icon">
                    <i class="fas fa-upload" style="font-size:1.2rem">↑</i>
                </div>
                <p>Logo de l'entreprise</p>
                <small>PNG transparent recommandé</small>
                <input type="file" id="logo" name="logo" accept="image/*" style="display:none"
                    onchange="document.querySelector('.logo-upload p').textContent = this.files[0]?.name || 'Logo de l\'entreprise'">
            </div>
            @error('logo') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

            <div class="mb-3">
                <label class="form-label">Email professionnel</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="rh@entreprise.com" value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                    placeholder="+229 XX XX XX XX" value="{{ old('telephone') }}">
                @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <div class="input-group">
                    <input type="password" name="mot_de_passe" id="mdp"
                        class="form-control @error('mot_de_passe') is-invalid @enderror"
                        placeholder="••••••••">
                    <button type="button" class="btn-eye" onclick="toggleMdp('mdp')">👁</button>
                </div>
                @error('mot_de_passe') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer</label>
                <div class="input-group">
                    <input type="password" name="mot_de_passe_confirmation" id="mdp2"
                        class="form-control" placeholder="••••••••">
                    <button type="button" class="btn-eye" onclick="toggleMdp('mdp2')">👁</button>
                </div>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="cgu" id="cgu" required>
                <label class="form-check-label" for="cgu" style="font-size:0.875rem; color:#374151">
                    J'accepte les <a href="#" class="cgu-link">CGU entreprise</a>.
                </label>
            </div>

            <button type="submit" class="btn-creer">Créer mon compte entreprise</button>

            <div class="text-center mt-3">
                <a href="{{ route('entreprise.inscription.etape1') }}" class="back-link" style="justify-content:center">← Retour</a>
            </div>
        </form>
    </div>

    <div class="footer-links">
        Déjà un compte ? <a href="{{ route('entreprise.login') }}">Se connecter</a>
    </div>
</div>

<script>
function toggleMdp(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>