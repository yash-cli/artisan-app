<?php

namespace App\Services;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class TeacherService
{
    public function getDataTable(): JsonResponse
    {
        $teachers = User::role(Role::TEACHER->value);

        return DataTables::of($teachers)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('teachers.edit', $row->id);
                $deleteUrl = route('teachers.destroy', $row->id);
                $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-1">Edit</a>';
                $btn = $btn . '<form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this teacher?\');">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(array $data): User
    {
        $teacher = DB::transaction(function () use ($data) {
            $teacher = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(config('site.default_password')),
            ]);

            $teacher->assignRole(Role::TEACHER->value);
            return $teacher;
        });

        return $teacher;
    }

    public function update(User $teacher, array $data): bool
    {
        return $teacher->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function delete(User $teacher): ?bool
    {
        return $teacher->delete();
    }
}
