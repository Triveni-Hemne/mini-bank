<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $transactions = Transaction::with('account')
            ->whereHas('account', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(15);

        return Inertia::render('User/Transactions/Index', [
            'transactions' => $transactions
        ]);
        
    }
}

    