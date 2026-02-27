<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Account;
// use App\Models\User;
use Inertia\Inertia;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\StoreTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $transactions = \App\Models\Transaction::with(['account.user', 'staff'])
                ->latest()
                ->paginate(15);

            return Inertia::render('Staff/Transactions/Index', [
                'transactions' => $transactions
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return Inertia::render('Staff/Transactions/Create', [
            'account' => $account->load('user')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {

            $account = \App\Models\Account::lockForUpdate()->find($request->account_id);

            // Prevent overdraft
            if ($request->type === 'debit' && $account->balance < $request->amount) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'amount' => 'Insufficient balance.'
                ]);
            }

            // Update balance
            if ($request->type === 'credit') {
                $account->balance += $request->amount;
            } else {
                $account->balance -= $request->amount;
            }

            $account->save();

            // Create transaction
            \App\Models\Transaction::create([
                'account_id' => $account->id,
                'type' => $request->type,
                'amount' => $request->amount,
                'description' => $request->description,
                'reference_no' => 'TXN' . now()->timestamp,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('staff.transactions.index')
            ->with('success', 'Transaction completed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function statement(Request $request, \App\Models\Account $account)
    {
        $query = $account->transactions()->orderBy('created_at');

        // Apply date filters
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $transactions = $query->get();

        $openingBalance = 0;

        if ($request->filled('from')) {
            $openingTransactions = $account->transactions()
                ->whereDate('created_at', '<', $request->from)
                ->get();

            foreach ($openingTransactions as $txn) {
                $openingBalance += $txn->type === 'credit'
                    ? $txn->amount
                    : -$txn->amount;
            }
        }

        $runningBalance = $openingBalance;

        $statement = [];

        foreach ($transactions as $txn) {

            if ($txn->type === 'credit') {
                $runningBalance += $txn->amount;
            } else {
                $runningBalance -= $txn->amount;
            }

            $statement[] = [
                'date' => $txn->created_at->format('d-m-Y'),
                'type' => $txn->type,
                'amount' => $txn->amount,
                'description' => $txn->description,
                'reference_no' => $txn->reference_no,
                'balance' => $runningBalance,
            ];
        }

        return Inertia::render('Staff/Transactions/Statement', [
            'account' => $account->load('user'),
            'statement' => $statement,
            'opening_balance' => $openingBalance,
            'filters' => $request->only('from', 'to'),
        ]);
    }   
}
