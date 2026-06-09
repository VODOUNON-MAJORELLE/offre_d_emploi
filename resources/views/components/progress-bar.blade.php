{{-- 
    Composant Barre de Progression du Recrutement
    @param $candidature — instance Candidature (avec relations progressions.etapeOffre chargées)
--}}

@php
    $progressions = $candidature->progressions->sortBy(function($p) {
        return $p->etapeOffre->ordre_etape ?? 0;
    });
    $totalSteps = $progressions->count();
    $completedSteps = $progressions->where('statut_etape', 'complétée')->count();
    $percentage = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
@endphp

<div class="progress-tracker-wrapper mb-4">
    {{-- Percentage Bar --}}
    <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="fw-bold text-dark" style="font-size: 0.85rem;">Progression du recrutement</span>
        <span class="badge bg-primary-subtle text-primary px-3 py-1" style="font-size: 0.8rem;">{{ $percentage }}%</span>
    </div>
    <div class="progress mb-4" style="height: 6px; border-radius: 6px; background: #e9ecef;">
        <div class="progress-bar" role="progressbar" 
             style="width: {{ $percentage }}%; background: linear-gradient(90deg, #4e44e7, #7d73fc); border-radius: 6px; transition: width 0.6s ease;"
             aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>

    {{-- Step Indicators --}}
    <div class="d-flex justify-content-between position-relative" style="margin-top: -8px;">
        {{-- Connecting line behind the dots --}}
        <div class="position-absolute w-100" style="top: 14px; left: 0; z-index: 0;">
            <div style="height: 2px; background: #e0e0e0; margin: 0 20px;"></div>
        </div>

        @foreach($progressions as $progression)
            @php
                $etape = $progression->etapeOffre;
                $statut = $progression->statut_etape;
                
                if ($statut === 'complétée') {
                    $dotClass = 'bg-success text-white';
                    $dotIcon = '✓';
                    $labelClass = 'text-success';
                } elseif ($statut === 'en_cours') {
                    $dotClass = 'bg-primary text-white';
                    $dotIcon = '●';
                    $labelClass = 'text-primary fw-bold';
                } else {
                    $dotClass = 'bg-light text-muted border';
                    $dotIcon = ($etape->ordre_etape ?? '');
                    $labelClass = 'text-muted';
                }
            @endphp

            <div class="text-center position-relative" style="z-index: 1; flex: 1; max-width: {{ 100 / $totalSteps }}%;">
                {{-- Dot --}}
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle {{ $dotClass }}"
                     style="width: 30px; height: 30px; font-size: 0.75rem; font-weight: 700;
                            @if($statut === 'en_cours') box-shadow: 0 0 0 4px rgba(78, 68, 231, 0.2); animation: pulse-dot 2s infinite; @endif">
                    {{ $dotIcon }}
                </div>
                {{-- Label --}}
                <div class="mt-2 {{ $labelClass }}" style="font-size: 0.7rem; line-height: 1.2;">
                    {{ $etape->nom_etape ?? 'Étape' }}
                </div>
                {{-- Date --}}
                @if($progression->date_validation)
                    <div class="text-muted" style="font-size: 0.65rem;">
                        {{ $progression->date_validation->format('d/m') }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<style>
    @keyframes pulse-dot {
        0% { box-shadow: 0 0 0 4px rgba(78, 68, 231, 0.2); }
        50% { box-shadow: 0 0 0 8px rgba(78, 68, 231, 0.08); }
        100% { box-shadow: 0 0 0 4px rgba(78, 68, 231, 0.2); }
    }
</style>
