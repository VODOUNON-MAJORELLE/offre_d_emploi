@extends('layouts.entreprise')
@section('title', 'Mon Profil')
@section('page_title', 'Profil entreprise')

@section('styles')
<style>
body { background: #f1f5f9; }
.card { border-radius:16px; border:1px solid #e8ecf0; box-shadow:0 1px 4px rgba(0,0,0,0.04); }
.logo-zone { width:80px; height:80px; border-radius:16px; background:linear-gradient(135deg,#6366f1,#8b5cf6); display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:700; color:#fff; margin:0 auto 0.5rem; cursor:pointer; position:relative; overflow:hidden; }
.logo-zone img { width:100%; height:100%; object-fit:cover; border-radius:16px; }
.logo-overlay { position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.4); color:#fff; font-size:0.65rem; text-align:center; padding:3px 0; opacity:0; transition:opacity 0.2s; }
.logo-zone:hover .logo-overlay { opacity:1; }
.form-label { font-size:0.78rem; font-weight:600; color:#374151; letter-spacing:0.5px; text-transform:uppercase; margin-bottom:0.4rem; }
.form-control, .form-select { border:1px solid #e2e8f0; border-radius:10px; padding:0.65rem 0.875rem; font-size:0.9rem; background:#f8fafc; }
.form-control:focus, .form-select:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); background:#fff; }
.info-item { display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#64748b; padding:0.4rem 0; }
.stat-mini { text-align:center; padding:1rem; background:#f8fafc; border-radius:12px; }
.stat-mini-val { font-size:1.4rem; font-weight:700; color:#6366f1; }
.stat-mini-lbl { font-size:0.75rem; color:#94a3b8; }
.btn-save { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; border-radius:10px; padding:0.65rem 1.5rem; font-size:0.9rem; font-weight:600; }
.btn-save:hover { opacity:0.9; color:#fff; }
.section-card-title { font-size:1rem; font-weight:600; color:#1A2340; margin-bottom:1.25rem; }
</style>
@endsection

@section('content')

<form method="POST" action="{{ route('entreprise.profil.update') }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 style="font-size:1.5rem;font-weight:700;color:#1A2340;margin:0">Profil entreprise</h1>
    <button type="submit" class="btn btn-save">✓ Enregistrer</button>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4" style="border-radius:10px;border:none;background:#f0fdf4;color:#15803d">
        ✓ {{ session('success') }}
    </div>
@endif

<div class="row g-4">

    {{-- Colonne gauche --}}
    <div class="col-md-4">

        {{-- Logo + infos rapides --}}
        <div class="card p-4 mb-4 text-center">
            <div class="logo-zone" onclick="document.getElementById('logo_input').click()">
                @if($entreprise->logo)
                    <img src="{{ asset('storage/'.$entreprise->logo) }}" alt="logo">
                @else
                    {{ strtoupper(substr($entreprise->nom_entreprise,0,2)) }}
                @endif
                <div class="logo-overlay">Modifier</div>
            </div>
            <input type="file" id="logo_input" name="logo" accept="image/*" style="display:none"
                onchange="previewLogo(this)">
            <div style="font-size:0.75rem;color:#94a3b8;margin-bottom:1rem">Cliquez sur le logo pour modifier</div>

            <div class="mb-3">
                <input type="text" name="nom_entreprise" class="form-control text-center fw-600"
                    value="{{ $entreprise->nom_entreprise }}"
                    style="font-size:1rem;font-weight:600;border:1px solid #e2e8f0">
            </div>
            <div style="font-size:0.85rem;color:#64748b;margin-bottom:1rem">{{ $entreprise->secteur_activite }}</div>

            <div class="info-item justify-content-center">
                📍 <span>{{ $entreprise->ville_entreprise ?? 'Ville non renseignée' }}</span>
            </div>
            <div class="info-item justify-content-center">
                📞 <span>{{ $entreprise->telephone ?? 'Téléphone non renseigné' }}</span>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="card p-4">
            <div class="section-card-title">Statistiques</div>
            <div class="row g-2">
                <div class="col-6">
                    <div class="stat-mini">
                        <div class="stat-mini-val">{{ $stats['offres'] }}</div>
                        <div class="stat-mini-lbl">Offres publiées</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-mini">
                        <div class="stat-mini-val">{{ $stats['candidatures'] }}</div>
                        <div class="stat-mini-lbl">Candidatures</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-mini">
                        <div class="stat-mini-val" style="color:#22c55e">{{ $stats['embauches'] }}</div>
                        <div class="stat-mini-lbl">Embauches</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-mini">
                        <div class="stat-mini-val" style="color:#f59e0b">{{ $entreprise->note_moyenne }}/5</div>
                        <div class="stat-mini-lbl">Score employeur</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Colonne droite --}}
    <div class="col-md-8">

        {{-- À propos --}}
        <div class="card p-4 mb-4">
            <div class="section-card-title">À propos de {{ $entreprise->nom_entreprise }}</div>
            <textarea name="description" class="form-control" rows="4"
                placeholder="Décrivez votre entreprise, votre culture, vos valeurs...">{{ $entreprise->description }}</textarea>
        </div>

        {{-- Informations --}}
        <div class="card p-4 mb-4">
            <div class="section-card-title">Informations générales</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Secteur d'activité</label>
                    <input type="text" name="secteur_activite" class="form-control"
                        value="{{ $entreprise->secteur_activite }}"
                        placeholder="Ex: Informatique, Finance...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ville / Adresse</label>
                    <input type="text" name="ville_entreprise" class="form-control"
                        value="{{ $entreprise->ville_entreprise }}"
                        placeholder="Ex: Cotonou, Bénin">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control"
                        value="{{ $entreprise->telephone }}"
                        placeholder="+229 XX XX XX XX">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email professionnel</label>
                    <input type="email" class="form-control"
                        value="{{ $entreprise->email }}" disabled
                        style="background:#f1f5f9;color:#94a3b8">
                    <small style="color:#94a3b8;font-size:0.75rem">L'email ne peut pas être modifié</small>
                </div>
            </div>
        </div>

        {{-- Offres publiées --}}
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="section-card-title mb-0">Offres publiées</div>
                <a href="{{ route('entreprise.offres.create') }}"
                   style="font-size:0.82rem;color:#6366f1;text-decoration:none;font-weight:500">+ Nouvelle offre</a>
            </div>
            @forelse($offres as $offre)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 0;border-bottom:1px solid #f1f5f9">
                <div>
                    <div style="font-size:0.875rem;font-weight:600;color:#1A2340">{{ $offre->titre_offre }}</div>
                    <div style="font-size:0.78rem;color:#94a3b8">{{ $offre->nb_candidatures }} candidats · {{ $offre->created_at->diffForHumans() }}</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size:0.75rem;padding:3px 10px;border-radius:20px;
                        background:{{ $offre->statut_offre === 'active' ? '#f0fdf4' : '#fef2f2' }};
                        color:{{ $offre->statut_offre === 'active' ? '#16a34a' : '#dc2626' }}">
                        {{ ucfirst($offre->statut_offre) }}
                    </span>
                    <a href="{{ route('entreprise.offres.show', $offre->id_offre) }}"
                       style="font-size:0.82rem;color:#6366f1;text-decoration:none;font-weight:500">Voir</a>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:1.5rem;color:#94a3b8;font-size:0.875rem">
                Aucune offre publiée pour l'instant.
            </div>
            @endforelse
        </div>

    </div>
</div>

</form>
@endsection

@section('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const zone = input.closest('form').querySelector('.logo-zone');
            zone.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:16px">
                <div class="logo-overlay">Modifier</div>`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection