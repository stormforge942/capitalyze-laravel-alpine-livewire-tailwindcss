<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Groups;
use Illuminate\Support\Facades\Log;

class CreateGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'groups:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all group items to the local database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $groups = [
            'Admins',
            'Developers',
            'Testers',
            'Users',
        ];

        foreach ($groups as $name) {
            $groups = Groups::updateOrCreate([
                'name' => $name
            ]);
        }
        $this->info('Groups imported successfully!');
    }
}
