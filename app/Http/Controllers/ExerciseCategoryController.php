<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExerciseCategory;
use Brian2694\Toastr\Facades\Toastr;
use App\Repositories\Contracts\ExerciseCategoryRepositoryInterface;

class ExerciseCategoryController extends Controller
{
    protected $exercise;

    public function __construct(ExerciseCategoryRepositoryInterface $exercise)
    {
        $this->exercise = $exercise;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercise_categories = $this->exercise->get_exercise_categories();
        return view('exercise_categories.index', compact('exercise_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exercise_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->exercise->create_exercise_category($validated);
        Toastr::success('Exercise Category created successfully', 'Success');
        return redirect()->route('exercise-categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExerciseCategory $exerciseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExerciseCategory $exerciseCategory)
    {
        $exercise_category = $this->exercise->get_exercise_category($exerciseCategory->id);
        return view('exercise_categories.edit', compact('exercise_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExerciseCategory $exerciseCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->exercise->update_exercise_category($exerciseCategory->id, $validated);
        Toastr::success('Exercise Category updated successfully', 'Success');
        return redirect()->route('exercise-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExerciseCategory $exerciseCategory)
    {
        $this->exercise->delete_exercise_category($exerciseCategory->id);
        Toastr::success('Exercise Category deleted successfully', 'Success');
        return redirect()->route('exercise-categories.index');
    }
}
