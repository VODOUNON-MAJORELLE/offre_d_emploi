@extends('layouts.app')

@section('title', 'Créer un questionnaire - ' . $offre->titre_offre)

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-11">
        <div class="mb-4">
            <a href="{{ route('entreprise.offres.candidatures', ['id_offre' => $offre->id_offre]) }}" class="text-decoration-none text-secondary d-inline-flex align-items-center gap-2">
                <span class="fs-5">←</span>
                <span>Retour au dashboard</span>
            </a>
        </div>

        <div class="premium-card p-4 p-lg-5 mb-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4">
                <div>
                    <p class="text-uppercase fw-semibold text-muted mb-2" style="letter-spacing: 0.16em; font-size: 0.75rem;">Créer une nouvelle offre</p>
                    <h1 class="fw-bold mb-2" style="font-size: clamp(2rem, 2.5vw, 2.5rem);">Questionnaire de candidature</h1>
                    <p class="text-muted mb-0">Ajoutez des questions pour mieux évaluer les candidats.</p>
                </div>
                <button type="button" class="premium-btn btn-primary px-4 py-3 align-self-stretch" onclick="addQuestion()">
                    + Ajouter
                </button>
            </div>

            <div class="mt-4">
                <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="step-pill completed">1. Informations</span>
                        <span class="step-pill active">2. Questionnaire</span>
                        <span class="step-pill pending">3. Processus</span>
                        <span class="step-pill pending">4. Aperçu</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('entreprise.questionnaires.store', $offre->id_offre) }}" method="POST" id="questionnaireForm">
            @csrf

            <div class="premium-card p-5 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
                    <div>
                        <h2 class="fw-bold mb-1" style="font-size: 1.4rem;">Questionnaire de candidature</h2>
                        <p class="text-muted mb-0">Ajoutez des questions pour mieux évaluer les candidats.</p>
                    </div>
                    <button type="button" class="premium-btn btn-primary px-4 py-3" onclick="addQuestion()">
                        + Ajouter
                    </button>
                </div>

                <div class="mb-4">
                    <label for="titre_questionnaire" class="form-label fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.03em;">Titre du questionnaire</label>
                    <input type="text" name="titre_questionnaire" id="titre_questionnaire" value="{{ old('titre_questionnaire') }}"
                           class="form-control form-control-lg border-0 bg-light" placeholder="Ex: Test de préqualification — Développeur PHP Senior"
                           required style="border-radius: 14px;">
                    <p class="form-text text-muted mt-2">Ce titre sera visible par les candidats.</p>
                </div>

                <div id="questions_container"></div>

                <div id="empty_questions_state" class="text-center p-5 rounded-4" style="border: 2px dashed rgba(78, 68, 231, 0.18); background: rgba(78, 68, 231, 0.02);">
                    <div class="mb-3" style="font-size: 3rem;">📝</div>
                    <h3 class="fw-bold mb-2">Aucune question — cliquez sur "Ajouter" pour créer votre questionnaire.</h3>
                    <p class="text-muted mb-4">C'est ici que vous construisez votre préqualification question par question.</p>
                    <button type="button" class="premium-btn btn-primary px-5 py-3" onclick="addQuestion()">Ajouter une question</button>
                </div>

                <div id="points_summary" class="d-none mt-4 p-4 rounded-4" style="background: rgba(79, 82, 234, 0.06); border: 1px solid rgba(78, 68, 231, 0.13);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 0.9rem; letter-spacing: 0.04em; text-transform: uppercase;">Total des points</p>
                            <p class="fs-4 fw-bold mb-0" id="total_points_value">0 pts</p>
                        </div>
                        <div class="badge rounded-pill bg-white text-dark px-3 py-2" style="box-shadow: 0 6px 20px rgba(78, 68, 231, 0.08);">🎯</div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <a href="{{ route('entreprise.offres.candidatures', ['id_offre' => $offre->id_offre]) }}" class="premium-btn btn-secondary px-4 py-3 w-100 w-md-auto text-center">← Retour</a>
                <button type="submit" class="premium-btn btn-primary px-5 py-3 w-100 w-md-auto">Continuer →</button>
            </div>

            <div class="text-muted small mt-3">💡 Les candidats répondront à ce questionnaire lors de leur candidature. Le score obtenu sera combiné au score de compatibilité pour classer les candidatures.</div>
        </form>
    </div>
</div>

<script>
    let questionIndex = 0;

    function updateSummary() {
        const container = document.getElementById('questions_container');
        const count = container.children.length;

        // Calculate total points
        let total = 0;
        container.querySelectorAll('input[name$="[points]"]').forEach(el => {
            total += parseInt(el.value) || 0;
        });
        document.getElementById('total_points_value').textContent = total + ' pts';

        const summary = document.getElementById('points_summary');
        if (count > 0) {
            summary.classList.remove('d-none');
        } else {
            summary.classList.add('d-none');
        }
    }

    function addQuestion() {
        document.getElementById('empty_questions_state').classList.add('d-none');

        const container = document.getElementById('questions_container');

        const qHtml = `
            <div class="premium-card p-4 mb-3 position-relative" id="question_card_${questionIndex}" style="animation: fadeInUp 0.3s ease-out;">
                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <span class="score-badge medium me-2">Q${questionIndex + 1}</span>
                        <span class="fw-bold text-dark">Question #${questionIndex + 1}</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-link text-danger text-decoration-none fw-semibold p-0" onclick="removeQuestion(${questionIndex})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                        Supprimer
                    </button>
                </div>

                {{-- Énoncé --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.03em;">Énoncé de la question</label>
                    <textarea name="questions[${questionIndex}][enonce]" class="form-control border-0 bg-light" rows="2"
                              placeholder="Ex: Quelle est la différence entre une classe abstraite et une interface en PHP ?"
                              required style="border-radius: 10px; resize: none;"></textarea>
                </div>

                {{-- Type + Points --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.03em;">Type de question</label>
                        <div class="d-flex gap-2">
                            <div class="form-check form-check-inline flex-fill">
                                <input class="form-check-input visually-hidden" type="radio" name="questions[${questionIndex}][type]" id="type_courte_${questionIndex}" value="reponse_courte" checked onchange="toggleQuestionType(${questionIndex}, 'reponse_courte')">
                                <label class="form-check-label w-100 text-center p-2 border rounded-3 bg-light fw-semibold small type-radio-label" for="type_courte_${questionIndex}" style="cursor: pointer; transition: all 0.2s;">
                                    ✏️ Réponse courte
                                </label>
                            </div>
                            <div class="form-check form-check-inline flex-fill">
                                <input class="form-check-input visually-hidden" type="radio" name="questions[${questionIndex}][type]" id="type_qcm_${questionIndex}" value="QCM" onchange="toggleQuestionType(${questionIndex}, 'QCM')">
                                <label class="form-check-label w-100 text-center p-2 border rounded-3 bg-light fw-semibold small type-radio-label" for="type_qcm_${questionIndex}" style="cursor: pointer; transition: all 0.2s;">
                                    ☑️ QCM
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.03em;">Points attribués</label>
                        <div class="input-group">
                            <input type="number" name="questions[${questionIndex}][points]" class="form-control border-0 bg-light fw-bold text-center"
                                   value="5" min="0" max="100" required style="border-radius: 10px 0 0 10px;" onchange="updateSummary()">
                            <span class="input-group-text bg-light border-0 text-muted" style="border-radius: 0 10px 10px 0;">pts</span>
                        </div>
                    </div>
                </div>

                {{-- QCM Options (hidden by default) --}}
                <div id="qcm_options_section_${questionIndex}" class="d-none">
                    <div class="p-3 rounded-3" style="background: rgba(78, 68, 231, 0.03); border: 1px solid rgba(78, 68, 231, 0.08);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.03em;">Options de réponse</span>
                            <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none fw-semibold p-0" onclick="addOption(${questionIndex})">
                                + Ajouter une option
                            </button>
                        </div>
                        <div id="options_container_${questionIndex}">
                            {{-- Dynamic options --}}
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', qHtml);

        // Style the active type radio
        styleTypeRadios(questionIndex);

        // Pre-add 2 default QCM options
        addOption(questionIndex);
        addOption(questionIndex);

        questionIndex++;
        updateSummary();
    }

    function removeQuestion(index) {
        const card = document.getElementById(`question_card_${index}`);
        card.style.animation = 'fadeOutDown 0.25s ease-out';
        setTimeout(() => {
            card.remove();
            const container = document.getElementById('questions_container');
            if (container.children.length === 0) {
                document.getElementById('empty_questions_state').classList.remove('d-none');
            }
            updateSummary();
        }, 200);
    }

    function toggleQuestionType(qIdx, type) {
        const optSection = document.getElementById(`qcm_options_section_${qIdx}`);
        if (type === 'QCM') {
            optSection.classList.remove('d-none');
            optSection.style.animation = 'fadeInUp 0.25s ease-out';
        } else {
            optSection.classList.add('d-none');
        }
        styleTypeRadios(qIdx);
    }

    function styleTypeRadios(qIdx) {
        const card = document.getElementById(`question_card_${qIdx}`);
        if (!card) return;
        card.querySelectorAll('.type-radio-label').forEach(label => {
            const input = document.getElementById(label.getAttribute('for'));
            if (input && input.checked) {
                label.style.borderColor = '#4e44e7';
                label.style.background = 'rgba(78, 68, 231, 0.06)';
                label.style.color = '#4e44e7';
            } else {
                label.style.borderColor = '#dee2e6';
                label.style.background = '#f8f9fa';
                label.style.color = '#6c757d';
            }
        });
    }

    let optionIndices = {};

    function addOption(qIdx) {
        if (!optionIndices[qIdx]) optionIndices[qIdx] = 0;

        const optContainer = document.getElementById(`options_container_${qIdx}`);
        const optIdx = optionIndices[qIdx];

        const oHtml = `
            <div class="d-flex align-items-center gap-2 mb-2" id="option_row_${qIdx}_${optIdx}" style="animation: fadeInUp 0.2s ease-out;">
                <div class="flex-grow-1">
                    <input type="text" name="questions[${qIdx}][options][${optIdx}][contenu]"
                           class="form-control form-control-sm border-0 bg-white"
                           placeholder="Option ${optIdx + 1}" required style="border-radius: 8px;">
                </div>
                <div class="form-check form-switch flex-shrink-0" style="min-width: 120px;">
                    <input class="form-check-input" type="checkbox" name="questions[${qIdx}][options][${optIdx}][correct]" value="1" id="correct_${qIdx}_${optIdx}" role="switch">
                    <label class="form-check-label small text-muted" for="correct_${qIdx}_${optIdx}">Correcte</label>
                </div>
                <button type="button" class="btn btn-sm p-1 text-muted flex-shrink-0" onclick="removeOption(${qIdx}, ${optIdx})" title="Supprimer cette option" style="transition: color 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/></svg>
                </button>
            </div>
        `;

        optContainer.insertAdjacentHTML('beforeend', oHtml);
        optionIndices[qIdx]++;
    }

    function removeOption(qIdx, optIdx) {
        const row = document.getElementById(`option_row_${qIdx}_${optIdx}`);
        row.style.animation = 'fadeOutDown 0.2s ease-out';
        setTimeout(() => row.remove(), 150);
    }
</script>

<style>
    .step-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(148, 163, 184, 0.25);
        color: #64748b;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .step-pill.active {
        background: rgba(78, 68, 231, 0.1);
        color: #4e44e7;
        border-color: rgba(78, 68, 231, 0.25);
        box-shadow: inset 0 0 0 1px rgba(78, 68, 231, 0.12);
    }
    .step-pill.completed {
        background: rgba(16, 185, 129, 0.12);
        color: #16a34a;
        border-color: rgba(16, 185, 129, 0.25);
    }
    .step-pill.pending {
        background: #f8fafc;
        color: #64748b;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOutDown {
        from { opacity: 1; transform: translateY(0); }
        to   { opacity: 0; transform: translateY(12px); }
    }
</style>
@endsection
