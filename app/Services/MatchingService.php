<?php

namespace App\Services;

use App\Models\Candidat;
use App\Models\Offre;

class MatchingService
{
    /**
     * Study level hierarchy values.
     */
    protected static array $studyLevels = [
        'Bac' => 1,
        'Licence+2' => 2,
        'Licence' => 3,
        'Master' => 4,
        'Doctorat' => 5,
    ];

    /**
     * Calculate compatibility score (0 to 100).
     */
    public function calculateScore(Candidat $candidat, Offre $offre): array
    {
        // 1. Competences (40%)
        $scoreCompetences = 0;
        $requiredSkills = array_filter(array_map('trim', explode(',', strtolower($offre->competences_requises))));
        $candidatSkills = array_filter(array_map('trim', explode(',', strtolower($candidat->competences))));

        if (empty($requiredSkills)) {
            $scoreCompetences = 40;
        } else {
            $intersect = array_intersect($requiredSkills, $candidatSkills);
            $scoreCompetences = (count($intersect) / count($requiredSkills)) * 40;
        }

        // 2. Experience (30%)
        $scoreExperience = 0;
        $reqExp = (int) $offre->experience_requise;
        $candExp = (int) $candidat->annees_experience;

        if ($reqExp <= 0) {
            $scoreExperience = 30;
        } else {
            if ($candExp >= $reqExp) {
                $scoreExperience = 30;
            } else {
                $scoreExperience = ($candExp / $reqExp) * 30;
            }
        }

        // 3. Etudes (20%)
        $scoreEtudes = 0;
        $reqLevel = $offre->niveau_etudes_requis;
        $candLevel = $candidat->niveau_etudes;

        $reqVal = self::$studyLevels[$reqLevel] ?? 1;
        $candVal = self::$studyLevels[$candLevel] ?? 1;

        if ($candVal >= $reqVal) {
            $scoreEtudes = 20;
        } elseif ($candVal == $reqVal - 1) {
            $scoreEtudes = 10;
        } else {
            $scoreEtudes = 0;
        }

        // 4. Localisation (10%)
        $scoreLocalisation = 0;
        $jobCity = trim(strtolower($offre->ville_poste));
        $candCity = trim(strtolower($candidat->ville));

        if ($jobCity === $candCity) {
            $scoreLocalisation = 10;
        } else {
            $scoreLocalisation = 0;
        }

        // Sum up compatibility score
        $scoreCompatibilite = (int) round($scoreCompetences + $scoreExperience + $scoreEtudes + $scoreLocalisation);

        return [
            'score_competences' => (int) round($scoreCompetences),
            'score_experience' => (int) round($scoreExperience),
            'score_etudes' => (int) round($scoreEtudes),
            'score_localisation' => (int) round($scoreLocalisation),
            'score_compatibilite' => min(100, max(0, $scoreCompatibilite)),
        ];
    }
}
