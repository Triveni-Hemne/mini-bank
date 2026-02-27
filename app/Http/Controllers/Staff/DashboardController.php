<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAccounts = Account::count();
        $totalDeposits = Transaction::where('type', 'credit')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'debit')->sum('amount');
        $systemBalance = Account::sum('balance');
        $todayTransactions = Transaction::whereDate('created_at', now())->count();

        $recentTransactions = Transaction::with('account.user')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Staff/Dashboard', [
            'stats' => [
                'totalAccounts' => $totalAccounts,
                'totalDeposits' => $totalDeposits,
                'totalWithdrawals' => $totalWithdrawals,
                'systemBalance' => $systemBalance,
                'todayTransactions' => $todayTransactions,
            ],
            'recentTransactions' => $recentTransactions
        ]);
    }
}
