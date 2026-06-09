@extends('layouts.app')

@section('title', 'Candidature soumise avec succès !')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-7 col-md-9 text-center">
        <!-- Success Badge -->
        <div class="mb-4">
            <span class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle" style="width: 80px; height: 80px; font-size: 3rem;">
                🎉
            </span>
        </div>

        <h1 class="fw-bold mb-2">Candidature Soumise !</h1>
        <p class="text-muted fs-5 mb-4">Votre dossier a été transmis avec succès à l'entreprise <strong>{{ $offre->entreprise->nom_entreprise }}</strong>.</p>

        <!-- Stats Card -->
        <div class="card card-glass p-4 mb-4 text-start border-0 shadow-sm">
            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-info-circle me-2"></i> Récapitulatif du dossier</h5>
            
            <div class="row align-items-center mb-3">
                <div class="col-sm-8">
                    <p class="mb-0 fw-semibold">Offre postulée :</p>
                    <p class="text-muted mb-0">{{ $offre->titre_offre }}</p>
                </div>
                <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                    <span class="badge bg-secondary-subtle text-secondary py-2 px-3">{{ $offre->type_contrat }}</span>
                </div>
            </div>

            <hr class="text-muted my-3">

            <!-- Matching Scores -->
            <div class="row align-items-center py-2">
                <div class="col-sm-8">
                    <h6 class="fw-bold mb-1">Score de compatibilité initial :</h6>
                    <p class="text-muted small mb-0">Basé sur vos compétences, expériences, études et localisation.</p>
                </div>
                <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                    <span class="fs-3 fw-bold text-primary">{{ $candidature->score_final }} %</span>
                </div>
            </div>

            <!-- Pre-qualification Questionnaire status -->
            @if($candidature->score_questionnaire !== null)
                <div class="row align-items-center py-2 border-top">
                    <div class="col-sm-8">
                        <h6 class="fw-bold mb-1">Score du Questionnaire :</h6>
                        <p class="text-muted small mb-0">Correction automatique de vos réponses QCM.</p>
                    </div>
                    <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                        <span class="fs-4 fw-bold text-success">{{ $candidature->score_questionnaire }} %</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Call to Action -->
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="/" class="btn btn-outline-secondary py-3 px-4 rounded-3">
                <i class="bi bi-house me-1"></i> Retour à l'accueil
            </a>
            <a href="/messagerie" class="btn btn-primary py-3 px-4 rounded-3 shadow">
                <i class="bi bi-chat-dots me-1"></i> Ouvrir la messagerie
            </a>
        </div>
    </div>
</div>
@endsection
