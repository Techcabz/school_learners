<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LearnerController extends Controller
{
    /**
     * Display a listing of learners
     */
    public function index()
    {
        $learners = Learner::orderBy('last_name')
            ->orderBy('first_name')
            ->with('enrollmentEligibility')
            ->paginate(20);

        return view('admin.learners.index', compact('learners'));
    }

    /**
     * Show the form for creating a new learner
     */
    public function create()
    {
        return view('admin.learners.create');
    }

    /**
     * Store a newly created learner
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lrn' => 'required|unique:learners|size:12',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'name_extension' => 'nullable|string|max:10',
            'birthdate' => 'required|date|before:-5 years',
            'sex' => ['required', Rule::in(['Male', 'Female'])]
        ]);

        $learner = Learner::create($validated);

        return redirect()
            ->route('admin.learners.show', $learner->id)
            ->with('success', 'Learner created successfully');
    }

    /**
     * Display learner details
     */
    public function show(Learner $learner)
    {
        $learner->load([
            'enrollmentEligibility',
            'enrollments.schoolClass.schoolYear',
            'enrollments.schoolClass.adviser',
            'quarterlyGrades.learningArea',
            'finalGrades.learningArea'
        ]);

        return view('admin.learners.show', compact('learner'));
    }

    /**
     * Show the form for editing learner information
     */
    public function edit(Learner $learner)
    {
        return view('admin.learners.edit', compact('learner'));
    }

    /**
     * Update learner information
     */
    public function update(Request $request, Learner $learner)
    {
        $validated = $request->validate([
            'lrn' => ['required', 'size:12', Rule::unique('learners')->ignore($learner->id)],
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'name_extension' => 'nullable|string|max:10',
            'birthdate' => 'required|date|before:-5 years',
            'sex' => ['required', Rule::in(['Male', 'Female'])]
        ]);

        $learner->update($validated);

        return redirect()
            ->route('admin.learners.show', $learner->id)
            ->with('success', 'Learner updated successfully');
    }

    /**
     * Remove learner from system
     */
    public function destroy(Learner $learner)
    {
        // Prevent deletion if learner has records
        if ($learner->enrollments()->exists()) {
            return back()
                ->with('error', 'Cannot delete learner with enrollment records');
        }

        $learner->delete();

        return redirect()
            ->route('admin.learners.index')
            ->with('success', 'Learner deleted successfully');
    }

    /**
     * Search for learners
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        $learners = Learner::where('lrn', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('first_name', 'like', "%{$search}%")
            ->orderBy('last_name')
            ->paginate(20);

        return view('admin.learners.index', compact('learners'));
    }

    /**
     * Get learner's current academic status
     */
    public function academicStatus(Learner $learner)
    {
        $currentEnrollment = $learner->currentEnrollment();

        if (!$currentEnrollment) {
            return response()->json([
                'status' => 'Not currently enrolled'
            ]);
        }

        return response()->json([
            'grade_level' => $currentEnrollment->schoolClass->grade_level,
            'section' => $currentEnrollment->schoolClass->section,
            'status' => $currentEnrollment->status,
            'gpa' => $learner->finalGrades->avg('rating')
        ]);
    }
}