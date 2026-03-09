<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
// use App\Models\User;
use Inertia\Inertia;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $transactions = Transaction::with(['account.user', 'staff'])
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

            $account = Account::lockForUpdate()->find($request->account_id);

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
    public function show(Transaction $transaction)
    {
        $transaction->load('account.user');

        return Inertia::render('Staff/Transactions/Show', [
            'transaction' => $transaction
        ]);
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
    
    public function depositForm(Account $account)
    {
        $account->load('user');

        return Inertia::render('Staff/Transactions/Deposit', [
            'account' => $account
        ]);
    }

    public function withdrawForm(Account $account)
    {
        $account->load('user');

        return Inertia::render('Staff/Transactions/Withdraw', [
            'account' => $account
        ]);
    }

    public function deposit(Request $request, Account $account)
    {
        $data = $request->validate([
            'amount' => ['required','numeric','min:1']
        ]);

        DB::transaction(function () use ($account, $data) {

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'credit',
                'amount' => $data['amount'],
                'reference_number' => 'TXN-' . strtoupper(Str::random(10)),
                'created_by' => auth()->id(),
            ]);

            $account->increment('balance', $data['amount']);
        });

        return redirect()
            ->route('staff.accounts.show', $account)
            ->with('success', 'Deposit successful');
    }

    public function withdraw(Request $request, Account $account)
    {
        $data = $request->validate([
            'amount' => ['required','numeric','min:1']
        ]);

        DB::transaction(function () use ($account, $data) {

            $account->refresh();

            if ($account->balance < $data['amount']) {
                abort(400, 'Insufficient balance');
            }

            Transaction::create([
                'account_id' => $account->id,
                'type' => 'debit',
                'amount' => $data['amount'],
                'reference_number' => 'TXN-' . strtoupper(Str::random(10)),
                'created_by' => auth()->id(),
            ]);

            $account->decrement('balance', $data['amount']);
        });

        return redirect()
            ->route('staff.accounts.show', $account)
            ->with('success', 'Withdrawal successful');
    }
}
