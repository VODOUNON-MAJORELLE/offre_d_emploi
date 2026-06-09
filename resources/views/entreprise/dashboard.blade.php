{{-- Offres actives + Top candidats --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="section-title">Offres actives</span>
                <a href="{{ route('entreprise.offres.index') }}" class="voir-tout">Voir tout ›</a>
            </div>
            @forelse($offres_recentes as $i => $offre)
            @php $colors = ['#6366f1','#ec4899','#22c55e','#f59e0b','#06b6d4']; @endphp
            <div class="offre-item">
                <div class="offre-avatar" style="background:{{ $colors[$i % count($colors)] }}">
                    {{ strtoupper(substr($offre->titre_offre,0,2)) }}
                </div>
                <div style="flex:1;min-width:0">
                    {{-- LIGNE CORRIGÉE CI-DESSOUS --}}
                    <div class="offre-title">{{ \Illuminate\Support\Str::limit($offre->titre_offre, 35) }}</div>
                    <div class="offre-meta">{{ $offre->nb_candidatures }} candidats · {{ $offre->created_at->diffForHumans() }}</div>
                </div>
                <div class="d-flex gap-1">
                    <a href="{{ route('entreprise.offres.edit', $offre->id_offre) }}" class="btn-icon">✏️</a>
                    <a href="{{ route('entreprise.offres.show', $offre->id_offre) }}" class="btn-icon">👁</a>
                </div>
            </div>
            @empty
            <div class="text-center py-4" style="color:#94a3b8;font-size:0.875rem">
                Aucune offre publiée.<br>
                <a href="{{ route('entreprise.offres.create') }}" style="color:#6366f1;font-weight:500">Créer votre première offre →</a>
            </div>
            @endforelse
        </div>
    </div>
    
    
    