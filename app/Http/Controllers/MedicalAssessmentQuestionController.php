<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\MedicalAssessmentQuestionRepositoryInterface;
use Brian2694\Toastr\Facades\Toastr;

class MedicalAssessmentQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $medical_asses;
    public function __construct(MedicalAssessmentQuestionRepositoryInterface $medical_asses){
        $this->medical_asses = $medical_asses;
    }

    public function index()
    {
        $medical_assessment_questions = $this->medical_asses->get_medical_assessment_questions();
        return view('medical_assessment_questions.index', compact('medical_assessment_questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
