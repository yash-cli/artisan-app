<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertRequest;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function __construct(private readonly TeacherService $teacherService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->teacherService->getDataTable();
        }

        return view('teachers.index');
    }

    public function create(): View
    {
        return view('teachers.create');
    }

    public function store(UpsertRequest $request): RedirectResponse
    {
        $this->teacherService->create($request->validated());

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(User $teacher): View
    {
        if (!$teacher->hasRole('teacher')) {
            abort(404);
        }

        return view('teachers.edit', compact('teacher'));
    }

    public function update(UpsertRequest $request, User $teacher): RedirectResponse
    {
        if (!$teacher->hasRole('teacher')) {
            abort(404);
        }

        $this->teacherService->update($teacher, $request->validated());

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(User $teacher): RedirectResponse
    {
        if (!$teacher->hasRole('teacher')) {
            abort(404);
        }

        $this->teacherService->delete($teacher);

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
