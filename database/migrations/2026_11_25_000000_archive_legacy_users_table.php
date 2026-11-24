<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && ! Schema::hasTable('legacy_users')) {
            Schema::rename('users', 'legacy_users');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('legacy_users') && ! Schema::hasTable('users')) {
            Schema::rename('legacy_users', 'users');
        }
    }
};
