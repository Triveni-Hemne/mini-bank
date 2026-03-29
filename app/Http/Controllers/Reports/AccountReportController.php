<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Account;

class AccountReportController extends Controller
{
   public function index(Request $request)
    {
        $query = Account::with('user'); // or customer (based on your relation)

        // 🔍 Filters
        if ($request->search) {
            $query->where('account_number', 'like', '%' . $request->search . '%');
        }

        if ($request->type) {
            $query->where('account_type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $accounts = $query->latest()->paginate(10);

        // 📊 Summary
        $totalAccounts = $query->count();

        $totalBalance = $query->clone()->sum('balance');

        return Inertia::render('Reports/Accounts', [
            'accounts' => $accounts,
            'totalAccounts' => $totalAccounts,
            'totalBalance' => $totalBalance,
            'filters' => $request->all(),
        ]);
    }
}