<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;

class StaffSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;

        if (!$query) {
            return response()->json([]);
        }

        $accounts = Account::where('account_number', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'account_number']);

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'name', 'email']);

        $transactions = Transaction::where('reference_number', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'reference_number']);

        return response()->json([
            'accounts' => $accounts,
            'users' => $users,
            'transactions' => $transactions,
        ]);
    }
}

