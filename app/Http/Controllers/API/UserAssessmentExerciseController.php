<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserAssessmentExerciseController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'exercise_id' => 'required|exists:exercises,id',
            'value' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return $this->unprocessable($validator->errors()->toArray(), 'Validation Error');
        }

        //dd('zaid');
        try {
            $assessment = DB::table('user_exercise_assessment')->insert([
                'user_id' => $request->user_id,
                'exercise_id' => $request->exercise_id,
                'value' => $request->value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), [], 500);
        }

        return $this->success($assessment, 'User Assessment added successfully', 200);
    }
}
