<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $accounts = Account::with('user')
                ->latest()
                ->paginate(10);

            return Inertia::render('Staff/Accounts/Index', [
                'accounts' => $accounts
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('user')->select('id', 'name', 'email')->get();

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
            'account_type' => ['required', 'in:savings,current'],
        ]);

        Account::create([
            'user_id' => $validated['user_id'],
            'account_number' => 'ACC-' . strtoupper(Str::random(8)),
            'account_type' => $validated['account_type'],
            'balance' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('staff.accounts.index')
            ->with('success', 'Account created successfully.');
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
}
