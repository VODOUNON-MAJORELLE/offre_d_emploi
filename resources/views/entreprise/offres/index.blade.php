@extends('layouts.entreprise')
@section('title', 'Mes offres')
@section('page_title', 'Mes offres')

@section('styles')
<style>
body { background:#f1f5f9; }
.offre-card { background:#fff; border-radius:14px; border:1px solid #e8ecf0; padding:1.25rem; margin-bottom:1rem; display:flex; align-items:center; gap:1rem; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
.offre-avatar { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:700; color:#fff; flex-shrink:0; }
.offre-title { font-size:0.95rem; font-weight:600; color:#1A2340; margin-bottom:0.2rem; }
.offre-meta { font-size:0.8rem; color:#94a3b8; display:flex; gap:1rem; flex-wrap:wrap; }
.badge-statut { font-size:0.75rem; padding:3px 12px; border-radius:20px; font-weight:500; }
.badge-active { background:#f0fdf4; color:#16a34a; }
.badge-en_attente { background:#fef3c7; color:#d97706; }
.badge-suspendue { background:#fef2f2; color:#dc2626; }
.badge-cloturee { background:#f1f5f9; color:#64748b; }
.btn-action { width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#fff; display:flex; align-items:center; justify-content:center; text-decoration:none; color:#64748b; font-size:0.85rem; }
.btn-action:hover { background:#f8fafc; color:#6366f1; }
.empty-state { text-align:center; padding:4rem 2rem; background:#fff; border-radius:14px; border:1px solid #e8ecf0; }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;color:#1A2340;margin:0">Mes offres</h1>
        <p style="color:#64748b;font-size:0.875rem;margin:0">Gérez vos offres d'emploi publiées</p>
    </div>
    <a href="{{ route('entreprise.offres.create') }}"
       style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:10px;padding:0.65rem 1.25rem;font-size:0.9rem;font-weight:600;text-decoration:none">
        + Nouvelle offre
    </a>
</div>

@if(session('success'))
<div class="alert alert-success mb-3" style="border-radius:10px;border:none;background:#f0fdf4;color:#15803d">
    ✓ {{ session('success') }}
</div>
@endif

{{-- Filtres rapides --}}
<div class="d-flex gap-2 mb-4 flex-wrap">
    @foreach(['Toutes','active','en_attente','suspendue','cloturee'] as $f)
    <a href="{{ request('statut') == ($f=='Toutes'?'':$f) ? route('entreprise.offres.index') : route('entreprise.offres.index').'?statut='.$f }}"
       style="padding:0.4rem 1rem;border-radius:20px;font-size:0.82rem;text-decoration:none;
              background:{{ request('statut')==$f ? '#6366f1' : '#fff' }};
              color:{{ request('statut')==$f ? '#fff' : '#64748b' }};
              border:1px solid {{ request('statut')==$f ? '#6366f1' : '#e2e8f0' }}">
        {{ $f=='Toutes'?'Toutes' : ucfirst($f) }}
    </a>
    @endforeach
</div>

@forelse($offres as $i => $offre)
@php $colors = ['#6366f1','#ec4899','#22c55e','#f59e0b','#06b6d4','#8b5cf6']; @endphp
<div class="offre-card">
    <div class="offre-avatar" style="background:{{ $colors[$i % count($colors)] }}">
        {{ strtoupper(substr($offre->titre_offre,0,2)) }}
    </div>
    <div style="flex:1;min-width:0">
        <div class="offre-title">{{ $offre->titre_offre }}</div>
        <div class="offre-meta">
            <span>📍 {{ $offre->ville_poste ?? 'Non précisé' }}</span>
            <span>📋 {{ $offre->type_contrat }}</span>
            <span>👥 {{ $offre->nb_candidatures }} candidature(s)</span>
            @if($offre->date_limite)
            <span>⏰ Limite : {{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}</span>
            @endif
        </div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge-statut badge-{{ $offre->statut_offre }}">
            {{ ucfirst($offre->statut_offre) }}
        </span>
        <a href="{{ route('entreprise.offres.edit', $offre->id_offre) }}" class="btn-action">✏️</a>
        <a href="{{ route('entreprise.offres.show', $offre->id_offre) }}" class="btn-action">👁</a>

        {{-- Changer statut --}}
        <div class="dropdown">
            <button class="btn-action" data-bs-toggle="dropdown">⋯</button>
            <ul class="dropdown-menu dropdown-menu-end">
                @if($offre->statut_offre != 'active')
                <li>
                    <form method="POST" action="{{ route('entreprise.offres.statut', $offre->id_offre) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="statut" value="active">
                        <button type="submit" class="dropdown-item text-success">✅ Activer</button>
                    </form>
                </li>
                @endif
                @if($offre->statut_offre != 'suspendue')
                <li>
                    <form method="POST" action="{{ route('entreprise.offres.statut', $offre->id_offre) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="statut" value="suspendue">
                        <button type="submit" class="dropdown-item text-warning">⏸ Suspendre</button>
                    </form>
                </li>
                @endif
                @if($offre->statut_offre != 'cloturee')
                <li>
                    <form method="POST" action="{{ route('entreprise.offres.statut', $offre->id_offre) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="statut" value="cloturee">
                        <button type="submit" class="dropdown-item text-danger">🔒 Clôturer</button>
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@empty
<div class="empty-state">
    <div style="font-size:3rem;margin-bottom:1rem">📋</div>
    <h3 style="color:#1A2340;font-weight:600">Aucune offre publiée</h3>
    <p style="color:#94a3b8">Commencez par créer votre première offre d'emploi.</p>
    <a href="{{ route('entreprise.offres.create') }}"
       style="background:#6366f1;color:#fff;border-radius:10px;padding:0.65rem 1.5rem;text-decoration:none;font-weight:600;display:inline-block;margin-top:1rem">
        + Créer une offre
    </a>
</div>
@endforelse

@endsection