<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipApplication extends Model
{
    protected $fillable = ['membership_category_id', 'reference_no', 'full_name', 'email', 'phone', 'address', 'latitude', 'longitude', 'status', 'verification_sent_at'];

    protected function casts(): array
    {
        return ['latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'verification_sent_at' => 'datetime'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MembershipCategory::class, 'membership_category_id');
    }
}
