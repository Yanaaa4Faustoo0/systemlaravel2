<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $this->markExpiredTransactions();
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $transactions = Transaction::with('member')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('reference_number', 'like', "%{$search}%")
                        ->orWhere('payment_reference', 'like', "%{$search}%")
                        ->orWhereHas('member', function ($memberQuery) use ($search) {
                            $memberQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('member_number', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('transactions_index', compact('transactions', 'search', 'status'));
    }

    public function create(Request $request)
    {
        $members = Member::where('status', 'active')->orderBy('last_name')->orderBy('first_name')->get();
        $selectedMember = $request->integer('member_id');

        return view('transactions_create', [
            'members' => $members,
            'categories' => MembershipCategory::orderBy('name')->get(),
            'levels' => MembershipLevel::orderBy('id')->get(),
            'selectedMember' => $selectedMember,
            'selectedType' => $request->input('transaction_type', 'application'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'transaction_type' => ['required', Rule::in(['application', 'renewal'])],
            'category' => ['required', 'string', 'max:100'],
            'level' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'payment_reference' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['reference_number'] = $this->referenceNumber();
        $validated['status'] = 'pending';
        $validated['applied_at'] = now();

        $transaction = Transaction::create($validated);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $this->markExpiredTransactions();
        $transaction->load('latestPayment');
        return view('transactions_show', compact('transaction'));
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load(['member', 'latestPayment']);
        return view('transactions_receipt', compact('transaction'));
    }

    public function memberHistory(Member $member)
    {
        $this->markExpiredTransactions();
        $transactions = $member->transactions()->latest()->paginate(12)->withQueryString();

        return view('transactions_member', compact('member', 'transactions'));
    }

    public function markPaid(Request $request, Transaction $transaction)
    {
        if (!in_array($transaction->status, ['pending'], true)) {
            return back()->with('error', 'Only pending transactions can be marked as paid.');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_reference' => ['nullable', 'string', 'max:100'],
        ]);

        $transaction->update(array_merge($validated, [
            'status' => 'paid',
            'paid_at' => now(),
        ]));

        Payment::create([
            'membership_transaction_id' => $transaction->id,
            'amount' => $transaction->amount,
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $validated['payment_reference'] ?? null,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Payment recorded. Transaction is ready for approval.');
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'paid') {
            return back()->with('error', 'Only paid transactions can be approved.');
        }

        $level = MembershipLevel::where('name', $transaction->level)->first();
        $months = $level?->validity_months ?? 12;

        $transaction->update([
            'status' => 'approved',
            'approved_at' => now(),
            'expires_at' => now()->addMonths($months)->toDateString(),
        ]);

        $transaction->member->update([
            'category' => $transaction->category,
            'level' => $transaction->level,
            'status' => 'active',
        ]);

        return back()->with('success', 'Transaction approved and member membership updated.');
    }

    public function cancel(Transaction $transaction)
    {
        if (in_array($transaction->status, ['approved', 'cancelled'], true)) {
            return back()->with('error', 'This transaction cannot be cancelled.');
        }

        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', 'Transaction cancelled.');
    }

    private function referenceNumber(): string
    {
        do {
            $reference = 'TXN-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Transaction::where('reference_number', $reference)->exists());

        return $reference;
    }

    private function markExpiredTransactions(): void
    {
        Transaction::where('status', 'approved')
            ->whereNotNull('expires_at')
            ->whereDate('expires_at', '<', today())
            ->update(['status' => 'expired']);
    }
}
