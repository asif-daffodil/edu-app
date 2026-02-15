<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Modules\Mentors\Models\Mentor;

class SiteController extends Controller
{
    public function home(): View
    {
        $mentors = Mentor::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->limit(12)
            ->get(['id', 'name', 'topic', 'bio']);

        return view('welcome', compact('mentors'));
    }

    public function mentors(): View
    {
        $mentors = Mentor::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('pages.mentors', compact('mentors'));
    }
}
