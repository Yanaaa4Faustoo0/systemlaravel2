<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $this->expireTransactions();

        return view('dashboard', [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::where('status', 'active')->count(),
            'pendingTransactions' => Transaction::where('status', 'pending')->count(),
            'collectedPayments' => Payment::where('status', 'paid')->sum('amount'),
            'recentTransactions' => Transaction::with('member')->latest()->limit(8)->get(),
        ]);
    }

    private function expireTransactions(): void
    {
        Transaction::where('status', 'approved')->whereNotNull('expires_at')->whereDate('expires_at', '<', today())->update(['status' => 'expired']);
    }
}
