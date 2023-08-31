<?php
 
namespace App\Console\Commands;
 
use App\Models\Navbar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
 
class CreateNavbar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'navbar:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all navbar items to the local database';
 
    public function titleCase($input) {
        return implode(' ', array_map('ucfirst', explode('.', str_replace('-', '.', $input))));
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routeCollection = Route::getRoutes();

        foreach ($routeCollection as $key => $value) {
            if ($value->getName()) {
                $query[] = $value->getName();
            }
        }

        $collection = collect($query);
        
        foreach($collection as $value) {
            try {
                if (!Navbar::where('route_name', $value)->exists()) {
                    Log::debug("Navbar creation: {$value}");
                    $navbar = Navbar::create(
                        [
                            'name' => $this->titleCase($value), 
                            'position' => 0, 
                            'route_name' => $value, 
                            'is_custom' => false, 
                            'is_closed' => true
                        ],
                    );
                }
            } catch (\Exception $e) {
                Log::error("Error creating or finding navbar item: {$e->getMessage()}");
            }
        }
    }
}