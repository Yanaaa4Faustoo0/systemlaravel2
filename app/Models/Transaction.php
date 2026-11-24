<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'membership_transactions';

    protected $fillable = [
        'member_id', 'reference_number', 'transaction_type', 'category', 'level',
        'amount', 'payment_method', 'payment_reference', 'status', 'applied_at',
        'paid_at', 'approved_at', 'expires_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'applied_at' => 'datetime',
            'paid_at' => 'datetime',
            'approved_at' => 'datetime',
            'expires_at' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'membership_transaction_id');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class, 'membership_transaction_id')->latestOfMany();
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}
