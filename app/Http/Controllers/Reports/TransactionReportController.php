<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Inertia\Inertia;

class TransactionReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['account.user']);

        // 🔍 Filters
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        if ($request->account_id) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->type) {
            $query->where('type', $request->type); // debit / credit
        }

        $transactions = $query->latest()->paginate(10);

        $accounts = Account::all();

        // 📊 Summary
        $totalCredit = $query->clone()->where('type', 'credit')->sum('amount');
        $totalDebit  = $query->clone()->where('type', 'debit')->sum('amount');

        return Inertia::render('Reports/Transactions', [
            'transactions' => $transactions,
            'accounts' => $accounts,
            'totalCredit' => $totalCredit,
            'totalDebit' => $totalDebit,
        ]);
    }
}
