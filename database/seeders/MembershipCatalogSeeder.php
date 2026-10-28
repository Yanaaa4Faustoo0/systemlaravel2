<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Database\Seeder;

class MembershipCatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Student', 'description' => 'For currently enrolled students.'],
            ['name' => 'Regular', 'description' => 'Standard individual membership.'],
            ['name' => 'Senior Citizen', 'description' => 'For qualified senior citizens.'],
            ['name' => 'Corporate', 'description' => 'For company and organization memberships.'],
        ] as $category) {
            MembershipCategory::updateOrCreate(['name' => $category['name']], $category);
        }

        foreach ([
            ['name' => 'Basic', 'fee' => 0, 'validity_months' => 12, 'benefits' => 'Member registration and standard community access.'],
            ['name' => 'Silver', 'fee' => 500, 'validity_months' => 12, 'benefits' => 'Basic benefits plus member discounts and event access.'],
            ['name' => 'Gold', 'fee' => 1000, 'validity_months' => 12, 'benefits' => 'Silver benefits plus priority support and premium events.'],
            ['name' => 'Platinum', 'fee' => 2000, 'validity_months' => 12, 'benefits' => 'All benefits plus exclusive events and concierge support.'],
        ] as $level) {
            MembershipLevel::updateOrCreate(['name' => $level['name']], $level);
        }
    }
}
