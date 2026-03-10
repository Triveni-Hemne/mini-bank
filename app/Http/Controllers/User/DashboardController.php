<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $accounts = $user->accounts()
            ->with(['transactions' => function ($query) {
                $query->latest()->limit(5);
            }])
            ->get();

        return Inertia::render('User/Dashboard', [
            'accounts' => $accounts
        ]);
    }

}
