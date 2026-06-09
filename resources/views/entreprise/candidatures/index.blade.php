@extends('layouts.app')

@section('title', 'Candidatures reçues — ' . $offre->titre_offre)

@section('content')
<div class="row">
    <div class="col-12">

        {{-- Hero Header --}}
        <div class="premium-card border-0 bg-talentlink-gradient text-white p-4 p-md-5 mb-4 position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 opacity-25" style="font-size: 8rem; line-height: 1; margin-top: -1rem; margin-right: 1rem;">📊</div>
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '›';">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-white-50 text-decoration-none">Mes offres</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Candidatures</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-2" style="font-size: 1.75rem;">Candidatures reçues</h1>
            <p class="mb-0 text-white-50">{{ $offre->titre_offre }} — <span class="badge bg-white bg-opacity-25 text-white">{{ $candidatures->count() }} candidature(s)</span></p>
        </div>

        {{-- Action Bar --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div class="d-flex gap-2">
                <span class="score-badge high">{{ $candidatures->where('score_final', '>=', 70)->count() }} excellents</span>
                <span class="score-badge medium">{{ $candidatures->whereBetween('score_final', [40, 69])->count() }} moyens</span>
                <span class="score-badge low">{{ $candidatures->where('score_final', '<', 40)->count() }} faibles</span>
            </div>
            <a href="{{ route('entreprise.questionnaires.create', $offre->id_offre) }}" class="premium-btn btn-primary">
                📋 {{ $offre->questionnaire ? 'Modifier le questionnaire' : 'Ajouter un questionnaire' }}
            </a>
        </div>

        {{-- Candidatures List --}}
        @if($candidatures->isEmpty())
            <div class="premium-card p-5 text-center border-0">
                <div class="mb-3" style="font-size: 3.5rem;">📭</div>
                <h5 class="fw-bold mb-2">Aucune candidature reçue</h5>
                <p class="text-muted mb-0">Les candidats n'ont pas encore postulé à cette offre.</p>
            </div>
        @else
            @foreach($candidatures as $candidature)
                <div class="premium-card p-4 mb-3" style="animation: fadeInUp 0.3s ease-out {{ $loop->index * 0.05 }}s both;">
                    <div class="row align-items-center">
                        {{-- Candidate Info --}}
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3" style="width: 44px; height: 44px; font-size: 0.9rem;">
                                    {{ strtoupper(substr($candidature->candidat->prenom, 0, 1)) }}{{ strtoupper(substr($candidature->candidat->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $candidature->candidat->prenom }} {{ $candidature->candidat->nom }}</div>
                                    <div class="text-muted small">{{ $candidature->candidat->email }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Scores --}}
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="d-flex gap-2 align-items-center">
                                @php
                                    $scoreClass = $candidature->score_final >= 70 ? 'high' : ($candidature->score_final >= 40 ? 'medium' : 'low');
                                    $score = $candidature->candidat->scores->where('id_offre', $offre->id_offre)->first();
                                @endphp
                                <div class="text-center">
                                    <div class="score-badge {{ $scoreClass }} fw-bold" style="font-size: 1.1rem; padding: 0.4rem 0.9rem;">{{ $candidature->score_final }}%</div>
                                    <div class="text-muted small mt-1">Final</div>
                                </div>
                                <div class="text-center ms-2">
                                    <span class="fw-semibold text-primary">{{ $score ? $score->score_compatibilite.'%' : '—' }}</span>
                                    <div class="text-muted small mt-1">Compat.</div>
                                </div>
                                <div class="text-center ms-2">
                                    <span class="fw-semibold">{{ $candidature->score_questionnaire !== null ? $candidature->score_questionnaire.'%' : '—' }}</span>
                                    <div class="text-muted small mt-1">Quest.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Status + Actions --}}
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="d-flex justify-content-end align-items-center gap-2 flex-wrap">
                                <span class="text-muted small">{{ $candidature->date_soumission->format('d/m/Y') }}</span>
                                @if($candidature->motif_refus)
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">Refusée</span>
                                @else
                                    <span class="badge bg-success-subtle text-success px-3 py-2">Active</span>
                                @endif

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-pill dropdown-toggle px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        ⋯
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3" style="min-width: 220px;">
                                        @if($candidature->id_cv)
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('cvs.download', $candidature->id_cv) }}" target="_blank">
                                                📄 Télécharger CV
                                            </a>
                                        </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('candidatures.downloadLettre', $candidature->id_candidature) }}" target="_blank">
                                                ✉️ Voir lettre de motivation
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('messagerie.show', $candidature->id_candidat) }}">
                                                💬 Envoyer un message
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item py-2" type="button" data-bs-toggle="modal" data-bs-target="#noteModal_{{ $candidature->id_candidature }}">
                                                📝 Note interne
                                            </button>
                                        </li>
                                        @if(!$candidature->motif_refus)
                                        <li>
                                            <button class="dropdown-item py-2 text-danger" type="button" data-bs-toggle="modal" data-bs-target="#rejectModal_{{ $candidature->id_candidature }}">
                                                ❌ Refuser la candidature
                                            </button>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Note interne (si existante) --}}
                    @if($candidature->note_interne)
                        <div class="mt-3 p-2 rounded-3 small" style="background: rgba(245, 158, 11, 0.06); border: 1px solid rgba(245, 158, 11, 0.12);">
                            <span class="fw-semibold text-warning">📌 Note interne :</span> {{ $candidature->note_interne }}
                        </div>
                    @endif

                    {{-- Progression row --}}
                    @if($candidature->progressions && $candidature->progressions->count() > 0)
                        <div class="mt-3 p-3 rounded-3" style="background: rgba(78, 68, 231, 0.02); border: 1px solid rgba(78, 68, 231, 0.06);">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small text-muted fw-semibold text-uppercase" style="letter-spacing: 0.03em;">Progression du recrutement</span>
                                @php
                                    $currentStep = $candidature->progressions->where('statut_etape', 'en_cours')->first();
                                @endphp
                                @if($currentStep && !$candidature->motif_refus)
                                    <form action="{{ route('entreprise.candidatures.progression', $candidature->id_candidature) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id_progression" value="{{ $currentStep->id_progression }}">
                                        <input type="hidden" name="statut_etape" value="complétée">
                                        <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            ✓ Valider l'étape en cours
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @include('components.progress-bar', ['candidature' => $candidature])
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>

{{-- Modals --}}
@foreach($candidatures as $candidature)
    {{-- Note Interne Modal --}}
    <div class="modal fade" id="noteModal_{{ $candidature->id_candidature }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <form action="{{ route('entreprise.candidatures.note', $candidature->id_candidature) }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-light">
                        <h5 class="modal-title fw-bold">📝 Note interne</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">Cette note est confidentielle et visible uniquement par votre équipe.</p>
                        <textarea name="note_interne" class="form-control border-0 bg-light" rows="4" placeholder="Notez vos observations sur ce candidat..." style="border-radius: 10px; resize: none;">{{ $candidature->note_interne }}</textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="premium-btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="premium-btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    @if(!$candidature->motif_refus)
    <div class="modal fade" id="rejectModal_{{ $candidature->id_candidature }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <form action="{{ route('entreprise.candidatures.reject', $candidature->id_candidature) }}" method="POST">
                    @csrf
                    <div class="modal-header border-0" style="background: rgba(239, 68, 68, 0.05);">
                        <h5 class="modal-title fw-bold text-danger">❌ Refuser la candidature</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">Un message de refus sera envoyé à <strong>{{ $candidature->candidat->prenom }} {{ $candidature->candidat->nom }}</strong>.</p>
                        <label class="form-label fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.03em;">Motif du refus</label>
                        <textarea name="motif_refus" class="form-control border-0 bg-light" rows="3" placeholder="Ex: Le profil ne correspond pas aux compétences techniques requises." required style="border-radius: 10px; resize: none;"></textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="premium-btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">Confirmer le refus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
