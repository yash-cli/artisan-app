<?php

namespace App\Http\Controllers;

use App\Services\AnnouncementFeedService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function __construct(private readonly AnnouncementFeedService $feedService) {}

    public function index(): View
    {
        $announcements = $this->feedService->getForUser(Auth::user());

        return view('announcements.index', compact('announcements'));
    }
}
