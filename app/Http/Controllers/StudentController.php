<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentUpsertRequest;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(private readonly StudentService $studentService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->studentService->getDataTable();
        }

        return view('students.index');
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(StudentUpsertRequest $request): RedirectResponse
    {
        $this->studentService->create($request->validated());

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(User $student): View
    {
        if (!$student->hasRole('student')) {
            abort(404);
        }

        $student->loadMissing('parent');

        return view('students.edit', compact('student'));
    }

    public function update(StudentUpsertRequest $request, User $student): RedirectResponse
    {
        if (!$student->hasRole('student')) {
            abort(404);
        }

        $this->studentService->update($student, $request->validated());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        if (!$student->hasRole('student')) {
            abort(404);
        }

        $this->studentService->delete($student);

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
