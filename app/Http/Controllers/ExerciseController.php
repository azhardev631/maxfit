<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\ExerciseRepositoryInterface;

class ExerciseController extends Controller
{
    protected $exe;

    public function __construct(ExerciseRepositoryInterface $exe)
    {
        $this->exe = $exe;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercises = $this->exe->get_exercises();
        return view('exercises.index', compact('exercises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercises = $this->exe->get_exercise_caetegories();
        return view('exercises.create', compact('exercises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'exercise_category_id' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (isset($validated['image']) && $validated['image']->isValid()) {
            $imageName = time() . '.' . $validated['image']->getClientOriginalExtension();
            $path = $validated['image']->storeAs('uploads/exercises', $imageName, 'public');
            $validated['image'] = $path;
        }

        $this->exe->create_exercise($validated);
        Toastr::success('Exercise created successfully', 'Success');
        return redirect()->route('exercises.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        $exercises = $this->exe->get_exercise_caetegories();
        return view('exercises.edit', compact('exercises', 'exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'exercise_category_id' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image
            if ($exercise->image && Storage::disk('public')->exists($exercise->image)) {
                Storage::disk('public')->delete($exercise->image);
            }

            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('uploads/exercises', $imageName, 'public');

            $validated['image'] = $path;
        } else {
            unset($validated['image']);
        }

        $this->exe->update_exercise($exercise->id, $validated);
        Toastr::success('Exercise updated successfully', 'Success');
        return redirect()->route('exercises.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        if (!$exercise) {
            return false;
        }

        if ($exercise->image) {
            $imagePath = str_replace(asset('storage') . '/', '', $exercise->image);
            $fullPath = public_path('storage/' . $imagePath);

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $this->exe->delete_exercise($exercise->id);

        Toastr::success('Exercise deleted successfully', 'Success');
        return redirect()->route('exercises.index');
    }
}
