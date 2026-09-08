<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Inertia\Inertia;
use Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('account.user');

        // 🔍 Optional Filters (good for future)
        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->account_id) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                $request->from_date,
                $request->to_date
            ]);
        }

        // 📋 Transactions List
        $transactions = $query->latest()->paginate(10)->withQueryString();

        // 🏦 Accounts for dropdown
        $accounts = Account::select('id', 'account_number')->get();

        // 👉 Return Vue Page
        return Inertia::render('Admin/Transactions/Index', [
            'transactions' => $transactions,
            'accounts' => $accounts,
            'filters' => $request->all(), // useful for future filters
        ]);
    }

    public function store(Request $request)
    {
         $account = Account::findOrFail($request->account_id);

        // 💰 Update Balance
        if ($request->type == 'credit') {
            $account->balance += $request->amount;
        } else {
            $account->balance -= $request->amount;
        }

        $account->save();

        // 📝 Save Transaction
        Transaction::create([
            'account_id' => $account->id,
            'type' => $request->type,
            'amount' => $request->amount,
            // 'payment_mode' => $request->payment_mode,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);

        return back()->with('success', 'Transaction added');
    }

    public function update(Request $request, $id)
    {
        $txn = Transaction::findOrFail($id);
        $account = $txn->account;

        // 🔁 Reverse old
        if ($txn->type == 'credit') {
            $account->balance -= $txn->amount;
        } else {
            $account->balance += $txn->amount;
        }

        // ✅ Apply new
        if ($request->type == 'credit') {
            $account->balance += $request->amount;
        } else {
            $account->balance -= $request->amount;
        }

        $account->save();

        $txn->update($request->all());

        return back()->with('success', 'Transaction updated');
    }

    public function destroy($id)
    {
        $txn = Transaction::findOrFail($id);
        $account = $txn->account;

        // Reverse
        if ($txn->type == 'credit') {
            $account->balance -= $txn->amount;
        } else {
            $account->balance += $txn->amount;
        }

        $account->save();
        $txn->delete();

        return back()->with('success', 'Transaction deleted');
    }
}
