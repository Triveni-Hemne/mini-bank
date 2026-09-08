<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 Cards
        $totalCustomers = User::count();
        $totalAccounts = Account::count();
        $totalBalance = Account::sum('balance');

        $todayTransactions = Transaction::whereDate('created_at', today())->count();

        // 📈 Transaction Chart (last 7 days)
        $transactionsChart = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN type="credit" THEN amount ELSE 0 END) as credit'),
                DB::raw('SUM(CASE WHEN type="debit" THEN amount ELSE 0 END) as debit')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->take(7)
            ->get();

        // 🥧 Account Type Chart
        $accountTypes = Account::select('account_type', DB::raw('COUNT(*) as total'))
            ->groupBy('account_type')
            ->get();

        return inertia('Admin/Dashboard', [
            'totalCustomers' => $totalCustomers,
            'totalAccounts' => $totalAccounts,
            'totalBalance' => $totalBalance,
            'todayTransactions' => $todayTransactions,
            'transactionsChart' => $transactionsChart,
            'accountTypes' => $accountTypes
        ]);
    }
}
