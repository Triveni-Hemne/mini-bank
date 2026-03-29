<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class CustomerReportController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('accounts');

        // 🔍 Filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $customers = $query->paginate(10);

        // 📊 Summary (IMPORTANT)
        $totalCustomers = $query->count();

        $totalBalance = 0;
        foreach ($customers as $customer) {
            $totalBalance += $customer->accounts->sum('balance');
        }

       return Inertia::render('Reports/Customers', [
            'customers' => $customers,
            'totalCustomers' => $totalCustomers,
            'totalBalance' => $totalBalance,
        ]);
    }
}
