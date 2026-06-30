<?php

namespace App\Services;

use App\Enums\AnnouncementType;
use App\Enums\Role;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Collection;

class AnnouncementManageService
{
    public function getAnnouncements(User $user): Collection
    {
        return Announcement::query()
            ->when(
                $user->hasRole(Role::ADMIN->value),
                fn($query) => $query->whereHas('user', fn($q) => $q->role(Role::ADMIN->value)),
                fn($query) => $query->where('user_id', $user->id)
            )
            ->with('user')
            ->latest()
            ->get();
    }

    public function store(array $data, User $user): Announcement
    {
        $type = AnnouncementType::TEACHER;

        if ($user->hasRole(Role::TEACHER->value)) {
            $type = $this->getAnnouncementType($data['targets'] ?? []);
        }

        return Announcement::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $type,
        ]);
    }

    public function update(Announcement $announcement, array $data, User $user): bool
    {
        $type = AnnouncementType::TEACHER;

        if ($user->hasRole(Role::TEACHER->value)) {
            $type = $this->getAnnouncementType($data['targets'] ?? []);
        }

        return $announcement->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $type,
        ]);
    }

    public function delete(Announcement $announcement): ?bool
    {
        return $announcement->delete();
    }

    private function getAnnouncementType(array $targets): AnnouncementType
    {
        $hasStudent = in_array(AnnouncementType::STUDENT->value, $targets);
        $hasParents = in_array(AnnouncementType::PARENTS->value, $targets);

        if ($hasStudent && $hasParents) {
            return AnnouncementType::STUDENT_AND_PARENTS;
        }

        if ($hasStudent) {
            return AnnouncementType::STUDENT;
        }

        return AnnouncementType::PARENTS;
    }
}
