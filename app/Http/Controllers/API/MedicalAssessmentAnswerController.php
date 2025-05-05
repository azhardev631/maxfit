<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\MedicalAssessmentQuestion;
use App\Repositories\Contracts\API\MedicalAssessmentAnswerInterface;

class MedicalAssessmentAnswerController extends Controller
{
    protected $answer;

    public function __construct(MedicalAssessmentAnswerInterface $answer)
    {
        $this->answer = $answer;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth('sanctum')->user();
        // dd($user->id);
        try {
            $validated = $request->validate([
                'answers' => 'required|array'
            ]);

            $questionIds = array_keys($validated['answers']);

            $validQuestionIds = MedicalAssessmentQuestion::whereIn('id', $questionIds)->pluck('id')->toArray();
            $invalidIds = array_diff($questionIds, $validQuestionIds);

            if (!empty($invalidIds)) {
                return $this->error("Invalid question IDs: " . implode(', ', $invalidIds), [], 422);
            }

            $userId = $user->id;
            $storedAnswers = [];
            //Log::info('Available question IDs:', MedicalAssessmentQuestion::pluck('id')->toArray());
            // return;
            foreach ($validated['answers'] as $questionId => $answer) {
                $storedAnswers =    $this->answer->store_medical_assessment_answers([
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'user_id' => $userId,
                ]);
            }

            return $this->success($storedAnswers, 'Medical assessment added successfully', 200);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), [], 422);
        }
    }
}
