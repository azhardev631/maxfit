<?php

namespace App\Repositories;

use App\Models\MedicalAssessmentQuestion;
use App\Repositories\Contracts\MedicalAssessmentQuestionRepositoryInterface;

class MedicalAssessmentQuestionRepository implements MedicalAssessmentQuestionRepositoryInterface
{

    public function get_medical_assessment_questions () {
        return MedicalAssessmentQuestion::get();
    }
}
