<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementUpsertRequest;
use App\Models\Announcement;
use App\Services\AnnouncementManageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminAnnouncementController extends Controller
{
    public function __construct(private readonly AnnouncementManageService $announcementManageService) {}

    public function index(): View
    {
        $announcements = $this->announcementManageService->getAnnouncements(Auth::user());

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(AnnouncementUpsertRequest $request): RedirectResponse
    {
        $this->announcementManageService->store(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement): View
    {
        if (!$announcement->user->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(AnnouncementUpsertRequest $request, Announcement $announcement): RedirectResponse
    {
        if (!$announcement->user->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $this->announcementManageService->update($announcement, $request->validated(), $request->user());

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if (!$announcement->user->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $this->announcementManageService->delete($announcement);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
