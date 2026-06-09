@extends('layouts.entreprise')
@section('title', $offre->titre_offre)
@section('page_title', 'Détail offre')

@section('styles')
<style>
body { background:#f1f5f9; }
.info-card { background:#fff; border-radius:14px; border:1px solid #e8ecf0; padding:1.5rem; margin-bottom:1.25rem; }
.stat-box { text-align:center; padding:1rem; background:#f8fafc; border-radius:12px; }
.stat-val { font-size:1.6rem; font-weight:700; }
.stat-lbl { font-size:0.78rem; color:#94a3b8; }
.badge-statut { font-size:0.8rem; padding:4px 14px; border-radius:20px; font-weight:500; }
.badge-active { background:#f0fdf4; color:#16a34a; }
.badge-en_attente { background:#fef3c7; color:#d97706; }
.badge-suspendue { background:#fef2f2; color:#dc2626; }
.candidat-row { display:flex; align-items:center; gap:1rem; padding:0.875rem 0; border-bottom:1px solid #f1f5f9; }
.candidat-row:last-child { border-bottom:none; }
.candidat-avatar { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.85rem; font-weight:700; color:#fff; flex-shrink:0; }
</style>
@endsection

@section('content')

<a href="{{ route('entreprise.offres.index') }}"
   style="color:#64748b;text-decoration:none;font-size:0.875rem;display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem">
    ← Retour au dashboard
</a>

{{-- Header offre --}}
<div class="info-card">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h2 style="font-weight:700;color:#1A2340;margin-bottom:0.5rem">{{ $offre->titre_offre }}</h2>
            <div style="display:flex;gap:1rem;font-size:0.875rem;color:#64748b;flex-wrap:wrap">
                <span>📍 {{ $offre->ville_poste ?? 'Non précisé' }}</span>
                <span>📋 {{ $offre->type_contrat }}</span>
                <span class="badge-statut badge-{{ $offre->statut_offre }}">{{ ucfirst($offre->statut_offre) }}</span>
                <span>🕐 Publiée {{ $offre->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <a href="{{ route('entreprise.offres.edit', $offre->id_offre) }}"
           style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:0.5rem 1.25rem;text-decoration:none;color:#374151;font-size:0.875rem;font-weight:500">
            ✏️ Modifier
        </a>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-3">
            <div class="stat-box">
                <div class="stat-val" style="color:#6366f1">{{ $offre->nb_candidatures }}</div>
                <div class="stat-lbl">Candidatures</div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-box">
                <div class="stat-val" style="color:#22c55e">0%</div>
                <div class="stat-lbl">Score moyen</div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-box">
                <div class="stat-val" style="color:#06b6d4">0%</div>
                <div class="stat-lbl">Taux complétion</div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-box">
                <div class="stat-val" style="color:#f59e0b">
                    {{ $offre->date_limite ? \Carbon\Carbon::parse($offre->date_limite)->diffInDays(now()) : '∞' }}
                </div>
                <div class="stat-lbl">Jours restants</div>
            </div>
        </div>
    </div>
</div>

{{-- Candidats --}}
<div class="info-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="font-weight:600;color:#1A2340;margin:0">
            👥 Candidats ({{ $candidatures->count() }})
        </h5>
        <div style="display:flex;gap:0.5rem">
            <span style="font-size:0.8rem;color:#94a3b8">Filtrer</span>
        </div>
    </div>

    @forelse($candidatures as $i => $cand)
    @php $colors = ['#1A2340','#6366f1','#ec4899','#22c55e','#f59e0b']; @endphp
    <div class="candidat-row">
        <div style="width:28px;height:28px;border-radius:50%;background:{{ $i==0?'#6366f1':'#f1f5f9' }};display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:{{ $i==0?'#fff':'#94a3b8' }}">
            {{ $i+1 }}
        </div>
        <div class="candidat-avatar" style="background:{{ $colors[$i % count($colors)] }}">
            {{ strtoupper(substr($cand->candidat->nom??'C',0,1).substr($cand->candidat->prenom??'A',0,1)) }}
        </div>
        <div style="flex:1">
            <div style="font-size:0.875rem;font-weight:600;color:#1A2340">
                {{ $cand->candidat->nom ?? '' }} {{ $cand->candidat->prenom ?? '' }}
            </div>
            <div style="font-size:0.78rem;color:#94a3b8">
                {{ $cand->candidat->niveau_etudes ?? '' }}
            </div>
        </div>
        <div style="font-size:0.78rem;color:#64748b">
            {{ $cand->candidat->annees_experience ?? 0 }} ans
        </div>
        <span style="font-size:0.78rem;padding:3px 10px;border-radius:20px;background:#f0fdf4;color:#16a34a">
            {{ ucfirst($cand->statut) }}
        </span>
        <div style="display:flex;align-items:center;gap:0.5rem">
            <div style="width:80px;height:6px;background:#e2e8f0;border-radius:3px;overflow:hidden">
                <div style="width:{{ $cand->score_final }}%;height:100%;background:linear-gradient(90deg,#6366f1,#8b5cf6)"></div>
            </div>
            <span style="font-size:0.875rem;font-weight:700;color:#6366f1">⚡ {{ $cand->score_final }}%</span>
        </div>
        <a href="{{ route('entreprise.candidatures.show', $cand->id_candidature) }}"
           style="background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:8px;padding:5px 14px;text-decoration:none;font-size:0.82rem;font-weight:600">
            Voir ›
        </a>
    </div>
    @empty
    <div style="text-align:center;padding:3rem;color:#94a3b8">
        <div style="font-size:2.5rem;margin-bottom:0.75rem">📭</div>
        <p>Aucune candidature reçue pour cette offre.</p>
    </div>
    @endforelse
</div>

@endsection