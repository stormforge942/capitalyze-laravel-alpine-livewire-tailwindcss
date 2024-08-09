<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Financials']);
        Permission::create(['name' => 'Analysis']);
        Permission::create(['name' => 'Filings']);
        Permission::create(['name' => 'Ownership']);
        Permission::create(['name' => 'Track Investors']);
    }
}
