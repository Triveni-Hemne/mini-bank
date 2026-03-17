<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreAccountRequest;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $accounts = Account::with('user')
            ->latest()
            ->paginate(10)
            ->through(function ($account) {
                return [
                    'id' => $account->id,
                    'account_number' => $account->account_number,
                    'user_name' => $account->user->name,
                    'account_type' => $account->account_type,
                    'balance' => $account->balance,
                    'status' => $account->status,
                    'created_at' => $account->created_at->format('Y-m-d'),
                ];
            });

        return Inertia::render('Staff/Accounts/Index', [
            'accounts' => $accounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('user')->select('id', 'name', 'email')->orderBy('name')->get();

        return Inertia::render('Staff/Accounts/Create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'account_type' => ['required', 'in:savings,current,loan,fd'],
            'opening_balance' => ['nullable', 'numeric', 'min:0'],
        ]);

       $account = DB::transaction(function () use ($validated) {

            $account = Account::create([
                'user_id' => $validated['user_id'],
                'account_number' => 'ACC-' . strtoupper(Str::random(8)),
                'account_type' => $validated['account_type'],
                'balance' => 0,
                'status' => 'active',
            ]);

            // Opening deposit transaction
            if (!empty($validated['opening_balance']) && $validated['opening_balance'] > 0) {

                Transaction::create([
                    'account_id' => $account->id,
                    'type' => 'credit',
                    'amount' => $validated['opening_balance'],
                    'reference_number' => 'OPEN-' . Str::random(8),
                    'created_by' => auth()->id(),
                ]);

                $account->increment('balance', $validated['opening_balance']);
            }
            return $account;
        });

        return redirect()->route('staff.accounts.show', $account)
            ->with('success', 'Account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
       $account->load(['user']);

        return Inertia::render('Staff/Accounts/Show', [
            'account' => [
                'id' => $account->id,
                'account_number' => $account->account_number,
                'account_type' => $account->account_type,
                'balance' => $account->balance,
                'status' => $account->status,
                'created_at' => $account->created_at->format('Y-m-d'),

                'user' => [
                    'name' => $account->user->name,
                    'email' => $account->user->email,
                ]
            ]
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
}
