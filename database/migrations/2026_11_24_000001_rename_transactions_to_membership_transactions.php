<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transactions') && ! Schema::hasTable('membership_transactions')) {
            Schema::rename('transactions', 'membership_transactions');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('membership_transactions') && ! Schema::hasTable('transactions')) {
            Schema::rename('membership_transactions', 'transactions');
        }
    }
};
