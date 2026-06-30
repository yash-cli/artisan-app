<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementUpsertRequest;
use App\Models\Announcement;
use App\Services\AnnouncementManageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAnnouncementController extends Controller
{
    public function __construct(private readonly AnnouncementManageService $announcementService) {}

    public function index(): View
    {
        $announcements = $this->announcementService->getAnnouncements(Auth::user());

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('teacher.announcements.create');
    }

    public function store(AnnouncementUpsertRequest $request): RedirectResponse
    {
        $this->announcementService->store(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('teacher.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement, Request $request): View
    {
        if ($announcement->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('teacher.announcements.edit', compact('announcement'));
    }

    public function update(AnnouncementUpsertRequest $request, Announcement $announcement): RedirectResponse
    {
        if ($announcement->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->announcementService->update($announcement, $request->validated(), $request->user());

        return redirect()
            ->route('teacher.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement, Request $request): RedirectResponse
    {
        if ($announcement->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $this->announcementService->delete($announcement);

        return redirect()
            ->route('teacher.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
