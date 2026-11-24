<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') return back()->with('error', 'Only pending transactions can receive a payment.');
        $data = $request->validate(['payment_method' => ['required', 'string', 'max:50'], 'payment_reference' => ['nullable', 'string', 'max:100'], 'amount' => ['required', 'numeric', 'min:0', 'in:' . $transaction->amount]]);
        Payment::create(['membership_transaction_id' => $transaction->id, 'amount' => $data['amount'], 'payment_method' => $data['payment_method'], 'payment_reference' => $data['payment_reference'] ?? null, 'status' => 'paid', 'paid_at' => now()]);
        $transaction->update(['payment_method' => $data['payment_method'], 'payment_reference' => $data['payment_reference'] ?? null, 'status' => 'paid', 'paid_at' => now()]);
        return redirect()->route('transactions.show', $transaction)->with('success', 'Payment recorded.');
    }
}
