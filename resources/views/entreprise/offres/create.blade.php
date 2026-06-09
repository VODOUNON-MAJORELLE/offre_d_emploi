@extends('layouts.entreprise')
@section('title', 'Créer une offre')
@section('page_title', 'Créer une offre')

@section('styles')
<style>
body { background:#f1f5f9; }
.wizard-steps { background:#fff; border-radius:14px; border:1px solid #e8ecf0; padding:1rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:0.5rem; }
.step-btn { flex:1; padding:0.6rem 1rem; border-radius:10px; border:none; font-size:0.875rem; font-weight:500; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:0.5rem; }
.step-btn.active { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; }
.step-btn.inactive { background:#f1f5f9; color:#94a3b8; }
.form-card { background:#fff; border-radius:14px; border:1px solid #e8ecf0; padding:1.75rem; }
.form-label { font-size:0.78rem; font-weight:600; color:#374151; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:0.4rem; }
.form-control, .form-select { border:1px solid #e2e8f0; border-radius:10px; padding:0.65rem 0.875rem; font-size:0.9rem; background:#f8fafc; }
.form-control:focus, .form-select:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); background:#fff; }
.btn-continuer { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; padding:0.85rem; font-size:0.95rem; font-weight:600; width:100%; margin-top:1.25rem; }
.competence-tag { display:inline-flex; align-items:center; gap:0.4rem; background:#ede9fe; color:#6366f1; padding:4px 12px; border-radius:20px; font-size:0.82rem; margin:3px; }
.competence-tag button { background:none; border:none; color:#6366f1; cursor:pointer; padding:0; font-size:0.9rem; }
</style>
@endsection

@section('content')

<a href="{{ route('entreprise.offres.index') }}"
   style="color:#64748b;text-decoration:none;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem">
    ← Retour au dashboard
</a>

<h1 style="font-size:1.5rem;font-weight:700;color:#1A2340;margin-bottom:1.5rem">Créer une nouvelle offre</h1>

{{-- Étapes wizard --}}
<div class="wizard-steps">
    <button class="step-btn active">📋 1. Informations</button>
    <button class="step-btn inactive">📝 2. Questionnaire</button>
    <button class="step-btn inactive">🔀 3. Processus</button>
    <button class="step-btn inactive">👁 4. Aperçu</button>
</div>

@if($errors->any())
<div class="alert alert-danger mb-3" style="border-radius:10px;border:none;background:#fef2f2;color:#dc2626">
    @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
</div>
@endif

<form method="POST" action="{{ route('entreprise.offres.store') }}">
@csrf

<div class="form-card">
    <h5 style="font-weight:600;color:#1A2340;margin-bottom:1.5rem">Détails du poste</h5>

    <div class="mb-3">
        <label class="form-label">Titre du poste *</label>
        <input type="text" name="titre_offre" class="form-control @error('titre_offre') is-invalid @enderror"
            placeholder="Ex: Développeur Full Stack React/Node.js" value="{{ old('titre_offre') }}">
        @error('titre_offre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Localisation *</label>
        <input type="text" name="ville_poste" class="form-control"
            placeholder="Ex: Cotonou, Bénin" value="{{ old('ville_poste') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Fourchette salariale</label>
        <div class="row g-2">
            <div class="col-6">
                <input type="number" name="salaire_min" class="form-control"
                    placeholder="Min (FCFA)" value="{{ old('salaire_min') }}">
            </div>
            <div class="col-6">
                <input type="number" name="salaire_max" class="form-control"
                    placeholder="Max (FCFA)" value="{{ old('salaire_max') }}">
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Date limite de candidature</label>
        <input type="date" name="date_limite" class="form-control" value="{{ old('date_limite') }}">
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label class="form-label">Contrat</label>
            <select name="type_contrat" class="form-select">
                <option value="CDI" {{ old('type_contrat')=='CDI'?'selected':'' }}>CDI</option>
                <option value="CDD" {{ old('type_contrat')=='CDD'?'selected':'' }}>CDD</option>
                <option value="stage" {{ old('type_contrat')=='stage'?'selected':'' }}>Stage</option>
                <option value="freelance" {{ old('type_contrat')=='freelance'?'selected':'' }}>Freelance</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Expérience (années)</label>
            <input type="number" name="experience_requise" class="form-control"
                placeholder="Ex: 2" value="{{ old('experience_requise', 0) }}" min="0">
        </div>
        <div class="col-md-4">
            <label class="form-label">Niveau d'études</label>
            <select name="niveau_etudes_requis" class="form-select">
                <option value="">Non précisé</option>
                <option value="Bac">Bac</option>
                <option value="Bac+2">Bac+2</option>
                <option value="Bac+3">Bac+3 (Licence)</option>
                <option value="Bac+5">Bac+5 (Master)</option>
                <option value="Doctorat">Doctorat</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Description du poste *</label>
        <textarea name="description_offre" class="form-control @error('description_offre') is-invalid @enderror"
            rows="5" placeholder="Décrivez le poste, les missions, l'environnement de travail...">{{ old('description_offre') }}</textarea>
        @error('description_offre') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Compétences requises</label>
        <div id="tags-container" style="min-height:42px;border:1px solid #e2e8f0;border-radius:10px;padding:6px;background:#f8fafc;display:flex;flex-wrap:wrap;align-items:center;gap:4px;cursor:text"
             onclick="document.getElementById('tag-input').focus()">
        </div>
        <input type="text" id="tag-input" placeholder="Ajouter une compétence..." class="form-control mt-2"
               onkeydown="addTag(event)">
        <input type="hidden" name="competences_requises" id="competences_hidden">
        <small style="color:#94a3b8;font-size:0.78rem">Appuyez sur Entrée pour ajouter</small>
    </div>
</div>

<button type="submit" class="btn-continuer">Continuer →</button>
</form>

@endsection

@section('scripts')
<script>
let tags = [];

function addTag(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const val = document.getElementById('tag-input').value.trim();
        if (val && !tags.includes(val)) {
            tags.push(val);
            renderTags();
            document.getElementById('tag-input').value = '';
        }
    }
}

function removeTag(tag) {
    tags = tags.filter(t => t !== tag);
    renderTags();
}

function renderTags() {
    const container = document.getElementById('tags-container');
    container.innerHTML = tags.map(t =>
        `<span class="competence-tag">${t} <button type="button" onclick="removeTag('${t}')">×</button></span>`
    ).join('');
    document.getElementById('competences_hidden').value = tags.join(', ');
}
</script>
@endsection