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
        $query = [
            (object)['name' => 'Admins'],
            (object)['name' => 'Developers'],
            (object)['name' => 'Testers'],
            (object)['name' => 'Users'],
        ];

        $collection = collect($query);
        
        foreach($collection as $value) {
            if (isset($value->name) && !empty($value->name)) {
                Log::debug("`Name` is set and not empty: {$value->name}");
                try {
                    $groups = Groups::updateOrCreate(
                        [ 
                            'name' => $value->name
                        ],
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding navbar item: {$e->getMessage()}");
                }
            }
        }
    }
}
