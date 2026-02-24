<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ActivityLog::with('user')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/Activity/Index', [
            'logs' => $logs
        ]);
    }

}
