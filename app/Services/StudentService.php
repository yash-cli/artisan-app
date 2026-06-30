<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StudentService
{
    public function getDataTable(): JsonResponse
    {
        $students = User::query()->role('student')->with('parent')->select(['id', 'name', 'email']);

        return DataTables::of($students)
            ->addIndexColumn()
            ->addColumn('parent_name', function ($row) {
                return $row->parent ? $row->parent->name : '-';
            })
            ->addColumn('parent_email', function ($row) {
                return $row->parent ? $row->parent->email : '-';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('students.edit', $row->id);
                $deleteUrl = route('students.destroy', $row->id);

                $btn = '';
                if (auth()->user()->hasRole('teacher')) {
                    $btn .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-1">Edit</a>';
                    $btn .= '<form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this student?\');">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>';
                } else {
                    $btn = '<span class="text-muted">No Actions</span>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $student = User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('Test@123'),
            ]);
            $student->assignRole('student');

            if (!empty($data['has_parent'])) {
                $parent = User::query()->create([
                    'name' => $data['parent_name'],
                    'email' => $data['parent_email'],
                    'password' => Hash::make('Test@123'),
                    'student_id' => $student->id,
                ]);
                $parent->assignRole('parent');
            }

            return $student;
        });
    }

    public function update(User $student, array $data): bool
    {
        return DB::transaction(function () use ($student, $data) {
            $student->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
            if (!empty($data['has_parent'])) {
                if ($student->parent) {
                    $student->parent->update([
                        'name' => $data['parent_name'],
                        'email' => $data['parent_email'],
                    ]);
                } else {
                    $parent = User::query()->create([
                        'name' => $data['parent_name'],
                        'email' => $data['parent_email'],
                        'password' => Hash::make('Test@123'),
                        'student_id' => $student->id,
                    ]);
                    $parent->assignRole('parent');
                }
            } else {
                if ($student->parent) {
                    $student->parent->delete();
                }
            }

            return true;
        });
    }

    public function delete(User $student): ?bool
    {
        return $student->delete();
    }
}
