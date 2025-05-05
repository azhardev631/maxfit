<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExercisesController extends Controller
{
    public function __invoke()
    {
        $exercises = Exercise::get();
        return $this->success($exercises, 'Exercises fetched successfully', 200);
    }
}
