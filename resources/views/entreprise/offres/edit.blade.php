@extends('layouts.entreprise')
@section('title', 'Modifier offre')
@section('page_title', 'Modifier une offre')

@section('styles')
<style>
body { background:#f1f5f9; }
.wizard-steps { background:#fff; border-radius:14px; border:1px solid #e8ecf0; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:0.5rem; }
.step-btn { flex:1; padding:0.6rem; border-radius:10px; border:none; font-size:0.82rem; font-weight:500; cursor:pointer; }
.step-btn.active { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; }
.step-btn.inactive { background:#f1f5f9; color:#94a3b8; }
.form-card { background:#fff; border-radius:14px; border:1px solid #e8ecf0; padding:1.75rem; margin-bottom:1.25rem; }
.form-label { font-size:0.78rem; font-weight:600; color:#374151; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:0.4rem; }
.form-control, .form-select { border:1px solid #e2e8f0; border-radius:10px; padding:0.65rem 0.875rem; font-size:0.9rem; }
.form-control:focus, .form-select:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
.etape-item { display:flex; align-items:center; gap:0.75rem; margin-bottom:0.75rem; }
.etape-num { width:32px; height:32px; background:#6366f1; border-radius:50%; color:#fff; display:flex; align-items:center; justify-content:center; font-size:0.85rem; font-weight:700; flex-shrink:0; }
.btn-save { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; padding:0.75rem 2rem; font-size:0.95rem; font-weight:600; }
.question-card { background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0; padding:1.25rem; margin-bottom:1rem; }
.q-num { background:#ede9fe; color:#6366f1; font-size:0.8rem; font-weight:700; padding:3px 10px; border-radius:20px; }
.option-row { display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem; }
.btn-remove { background:#fef2f2; border:none; color:#dc2626; border-radius:8px; padding:4px 10px; font-size:0.8rem; cursor:pointer; }
</style>
@endsection

@section('content')

<a href="{{ route('entreprise.offres.index') }}"
   style="color:#64748b;text-decoration:none;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem">
    ← Retour au dashboard
</a>

<h1 style="font-size:1.5rem;font-weight:700;color:#1A2340;margin-bottom:1.5rem">Modifier l'offre</h1>

{{-- Tabs --}}
<div class="wizard-steps">
    <button class="step-btn {{ !request('tab') || request('tab')=='infos' ? 'active' : 'inactive' }}"
        onclick="window.location='?tab=infos'">📋 1. Informations</button>
    <button class="step-btn {{ request('tab')=='questionnaire' ? 'active' : 'inactive' }}"
        onclick="window.location='?tab=questionnaire'">📝 2. Questionnaire</button>
    <button class="step-btn {{ request('tab')=='processus' ? 'active' : 'inactive' }}"
        onclick="window.location='?tab=processus'">🔀 3. Processus</button>
    <button class="step-btn {{ request('tab')=='apercu' ? 'active' : 'inactive' }}"
        onclick="window.location='?tab=apercu'">👁 4. Aperçu</button>
</div>

@if(session('success'))
<div class="alert mb-3" style="background:#f0fdf4;color:#15803d;border:none;border-radius:10px">✓ {{ session('success') }}</div>
@endif

{{-- ===== ONGLET 1 : INFORMATIONS ===== --}}
@if(!request('tab') || request('tab')=='infos')
<form method="POST" action="{{ route('entreprise.offres.update', $offre->id_offre) }}">
@csrf @method('PUT')
<div class="form-card">
    <h5 style="font-weight:600;color:#1A2340;margin-bottom:1.5rem">Détails du poste</h5>
    <div class="mb-3">
        <label class="form-label">Titre du poste *</label>
        <input type="text" name="titre_offre" class="form-control" value="{{ $offre->titre_offre }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Localisation</label>
        <input type="text" name="ville_poste" class="form-control" value="{{ $offre->ville_poste }}">
    </div>
    <div class="row g-2 mb-3">
        <div class="col-6">
            <label class="form-label">Salaire min (FCFA)</label>
            <input type="number" name="salaire_min" class="form-control" value="{{ $offre->salaire_min }}">
        </div>
        <div class="col-6">
            <label class="form-label">Salaire max (FCFA)</label>
            <input type="number" name="salaire_max" class="form-control" value="{{ $offre->salaire_max }}">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Date limite</label>
        <input type="date" name="date_limite" class="form-control"
            value="{{ $offre->date_limite ? \Carbon\Carbon::parse($offre->date_limite)->format('Y-m-d') : '' }}">
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label">Contrat</label>
            <select name="type_contrat" class="form-select">
                @foreach(['CDI','CDD','stage','freelance'] as $c)
                <option value="{{ $c }}" {{ $offre->type_contrat==$c?'selected':'' }}>{{ ucfirst($c) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Expérience (ans)</label>
            <input type="number" name="experience_requise" class="form-control" value="{{ $offre->experience_requise }}" min="0">
        </div>
        <div class="col-md-4">
            <label class="form-label">Niveau d'études</label>
            <select name="niveau_etudes_requis" class="form-select">
                @foreach(['','Bac','Bac+2','Bac+3','Bac+5','Doctorat'] as $n)
                <option value="{{ $n }}" {{ $offre->niveau_etudes_requis==$n?'selected':'' }}>{{ $n ?: 'Non précisé' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Description du poste *</label>
        <textarea name="description_offre" class="form-control" rows="5">{{ $offre->description_offre }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Compétences requises</label>
        <input type="text" name="competences_requises" class="form-control"
            value="{{ $offre->competences_requises }}"
            placeholder="Ex: React, Node.js, MySQL...">
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('entreprise.offres.index') }}" class="btn btn-outline-secondary" style="border-radius:10px;flex:1;text-align:center;padding:0.75rem">← Retour</a>
    <button type="submit" class="btn-save" style="flex:2">Enregistrer les modifications</button>
</div>
</form>
@endif

{{-- ===== ONGLET 2 : QUESTIONNAIRE ===== --}}
@if(request('tab')=='questionnaire')
<div class="form-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 style="font-weight:600;color:#1A2340;margin:0">Questionnaire de candidature</h5>
            <small style="color:#94a3b8">Ajoutez des questions pour mieux évaluer les candidats.</small>
        </div>
        <button onclick="ajouterQuestion()" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;border-radius:10px;padding:0.5rem 1.25rem;font-weight:600;cursor:pointer">
            + Ajouter
        </button>
    </div>

    @if($questionnaire)
        @foreach($questionnaire->questions as $qi => $question)
        <div class="question-card" id="q-{{ $question->id_question }}">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="q-num">Q{{ $qi+1 }}</span>
                <form method="POST" action="{{ route('entreprise.question.destroy', $question->id_question) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-remove">✕</button>
                </form>
            </div>
            <p style="font-size:0.9rem;font-weight:500;color:#1A2340">{{ $question->enonce_question }}</p>
            <p style="font-size:0.78rem;color:#94a3b8">Type : {{ $question->type_question }} · {{ $question->points_question }} pts</p>
            @if($question->options->count() > 0)
                @foreach($question->options as $opt)
                <div class="option-row">
                    <span style="color:{{ $opt->est_bonne_reponse ? '#16a34a' : '#94a3b8' }}">
                        {{ $opt->est_bonne_reponse ? '✅' : '○' }}
                    </span>
                    <span style="font-size:0.875rem">{{ $opt->contenu_option }}</span>
                </div>
                @endforeach
            @endif
        </div>
        @endforeach
    @endif

    {{-- Formulaire ajouter question --}}
    <div id="new-question-form" style="display:none">
        <form method="POST" action="{{ route('entreprise.questionnaire.store', $offre->id_offre) }}">
        @csrf
        <div class="question-card" style="border:2px dashed #6366f1">
            <div class="mb-3">
                <label class="form-label">Type de question</label>
                <select name="type_question" id="type_select" class="form-select" onchange="toggleOptions()">
                    <option value="qcm">QCM</option>
                    <option value="reponse_courte">Réponse courte</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Énoncé de la question</label>
                <input type="text" name="enonce_question" class="form-control" placeholder="Posez votre question...">
            </div>
            <div class="mb-3">
                <label class="form-label">Points</label>
                <input type="number" name="points_question" class="form-control" value="1" min="1" style="width:120px">
            </div>
            <div id="options-section">
                <label class="form-label">Options de réponse</label>
                <div id="options-list">
                    <div class="option-row">
                        <input type="checkbox" name="bonne_reponse[]" value="0">
                        <input type="text" name="options[]" class="form-control" placeholder="Option 1">
                    </div>
                    <div class="option-row">
                        <input type="checkbox" name="bonne_reponse[]" value="1">
                        <input type="text" name="options[]" class="form-control" placeholder="Option 2">
                    </div>
                </div>
                <button type="button" onclick="ajouterOption()"
                    style="background:none;border:none;color:#6366f1;font-size:0.875rem;font-weight:500;cursor:pointer;margin-top:0.5rem">
                    + Ajouter une option
                </button>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="button" onclick="document.getElementById('new-question-form').style.display='none'"
                    class="btn btn-outline-secondary" style="border-radius:8px;flex:1">Annuler</button>
                <button type="submit" style="background:#6366f1;color:#fff;border:none;border-radius:8px;padding:0.5rem 1.5rem;font-weight:600;flex:2;cursor:pointer">
                    Enregistrer la question
                </button>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="d-flex gap-2 mt-3">
    <a href="?tab=infos" class="btn btn-outline-secondary" style="border-radius:10px;flex:1;text-align:center;padding:0.75rem">← Retour</a>
    <a href="?tab=processus" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:10px;padding:0.75rem;text-align:center;text-decoration:none;font-weight:600;flex:2">Continuer →</a>
</div>
@endif

{{-- ===== ONGLET 3 : PROCESSUS ===== --}}
@if(request('tab')=='processus')
<div class="form-card">
    <h5 style="font-weight:600;color:#1A2340;margin-bottom:0.5rem">Étapes du processus de recrutement</h5>
    <p style="color:#94a3b8;font-size:0.875rem;margin-bottom:1.5rem">Personnalisez les étapes que verront les candidats dans leur suivi.</p>

    @foreach($etapes as $i => $etape)
    <div class="etape-item">
        <div class="etape-num">{{ $i+1 }}</div>
        <input type="text" class="form-control" value="{{ $etape->nom_etape }}" readonly style="background:#f8fafc">
        <form method="POST" action="{{ route('entreprise.etapes.destroy', $etape->id_etape_offre) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn-remove">✕</button>
        </form>
    </div>
    @endforeach

    {{-- Ajouter étape --}}
    <form method="POST" action="{{ route('entreprise.etapes.store', $offre->id_offre) }}" class="d-flex gap-2 mt-3">
        @csrf
        <input type="text" name="nom_etape" class="form-control" placeholder="Ajouter une étape..." required>
        <button type="submit" style="background:#6366f1;color:#fff;border:none;border-radius:10px;padding:0 1rem;font-size:1.2rem;cursor:pointer;flex-shrink:0">+</button>
    </form>
</div>
<div class="d-flex gap-2 mt-3">
    <a href="?tab=questionnaire" class="btn btn-outline-secondary" style="border-radius:10px;flex:1;text-align:center;padding:0.75rem">← Retour</a>
    <a href="?tab=apercu" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:10px;padding:0.75rem;text-align:center;text-decoration:none;font-weight:600;flex:2">Aperçu →</a>
</div>
@endif

{{-- ===== ONGLET 4 : APERCU ===== --}}
@if(request('tab')=='apercu')
<div class="form-card">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 style="font-weight:700;color:#1A2340">{{ $offre->titre_offre }}</h4>
            <div style="display:flex;gap:1rem;font-size:0.875rem;color:#64748b;flex-wrap:wrap;margin-top:0.5rem">
                <span>📍 {{ $offre->ville_poste ?? 'Non précisé' }}</span>
                <span>📋 {{ $offre->type_contrat }}</span>
                <span>💰 {{ $offre->salaire_min ? number_format($offre->salaire_min).' - '.number_format($offre->salaire_max).' FCFA' : 'Non précisé' }}</span>
                <span>⏰ {{ $offre->date_limite ? \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') : 'Pas de limite' }}</span>
            </div>
        </div>
        <span style="background:#fef3c7;color:#d97706;padding:4px 14px;border-radius:20px;font-size:0.82rem;font-weight:500">
            {{ ucfirst($offre->statut_offre) }}
        </span>
    </div>
    <hr>
    <h6 style="font-weight:600;color:#1A2340">Description</h6>
    <p style="color:#374151;font-size:0.9rem;white-space:pre-line">{{ $offre->description_offre }}</p>
    @if($offre->competences_requises)
    <h6 style="font-weight:600;color:#1A2340">Compétences requises</h6>
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem">
        @foreach(explode(',', $offre->competences_requises) as $comp)
        <span style="background:#ede9fe;color:#6366f1;padding:4px 12px;border-radius:20px;font-size:0.82rem">{{ trim($comp) }}</span>
        @endforeach
    </div>
    @endif
    @if($etapes->count() > 0)
    <h6 style="font-weight:600;color:#1A2340">Étapes du recrutement</h6>
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:1rem">
        @foreach($etapes as $i => $e)
        <div style="display:flex;align-items:center;gap:0.5rem">
            <div style="width:28px;height:28px;background:#6366f1;border-radius:50%;color:#fff;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700">{{ $i+1 }}</div>
            <span style="font-size:0.875rem;color:#374151">{{ $e->nom_etape }}</span>
            @if(!$loop->last) <span style="color:#cbd5e1">→</span> @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
<div class="d-flex gap-2 mt-3">
    <a href="?tab=processus" class="btn btn-outline-secondary" style="border-radius:10px;flex:1;text-align:center;padding:0.75rem">← Retour</a>
    <form method="POST" action="{{ route('entreprise.offres.statut', $offre->id_offre) }}" style="flex:2">
        @csrf @method('PATCH')
        <input type="hidden" name="statut" value="active">
        <button type="submit" style="background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;border:none;border-radius:10px;padding:0.75rem;width:100%;font-weight:600;cursor:pointer">
            ✅ Publier l'offre
        </button>
    </form>
</div>
@endif

@endsection

@section('scripts')
<script>
function ajouterQuestion() {
    document.getElementById('new-question-form').style.display = 'block';
}
function toggleOptions() {
    const t = document.getElementById('type_select').value;
    document.getElementById('options-section').style.display = t==='qcm' ? 'block' : 'none';
}
let optCount = 2;
function ajouterOption() {
    optCount++;
    const div = document.createElement('div');
    div.className = 'option-row';
    div.innerHTML = `<input type="checkbox" name="bonne_reponse[]" value="${optCount-1}">
        <input type="text" name="options[]" class="form-control" placeholder="Option ${optCount}">`;
    document.getElementById('options-list').appendChild(div);
}
</script>
@endsection