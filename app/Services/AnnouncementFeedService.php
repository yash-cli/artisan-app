<?php

namespace App\Services;

use App\Enums\AnnouncementType;
use App\Enums\Role;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Collection;

class AnnouncementFeedService
{
    public function getForUser(User $user): Collection
    {
        $types = [];

        if ($user->hasRole(Role::TEACHER->value)) {
            $types[] = AnnouncementType::TEACHER;
        } else if ($user->hasRole(Role::STUDENT->value)) {
            $types[] = AnnouncementType::STUDENT;
            $types[] = AnnouncementType::STUDENT_AND_PARENTS;
        } else if ($user->hasRole(Role::PARENT->value)) {
            $types[] = AnnouncementType::PARENTS;
            $types[] = AnnouncementType::STUDENT_AND_PARENTS;
        }

        return Announcement::query()->with('user')
            ->when(filled($types), fn($q) => $q->whereIn('type', $types))
            ->when($user->hasRole(Role::ADMIN->value) || $user->hasRole(Role::TEACHER->value), function ($q) {
                $q->whereHas('user', function ($q) {
                    $q->role(Role::ADMIN->value);
                });
            })
            ->latest()
            ->get();
    }
}
