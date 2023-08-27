<?php
 
namespace App\Console\Commands;
 
use App\Models\Navbar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 
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
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = [
            (object)['name' => 'Earnings Calendar', 'show' => true],
            (object)['name' => 'Economics Calendar', 'show' => true],
            (object)['name' => 'Company Filings', 'show' => true],
            (object)['name' => 'Funds Filings', 'show' => true],
            (object)['name' => 'Mutual Funds Filings', 'show' => true],
            (object)['name' => 'Company Identifiers', 'show' => true],
            (object)['name' => 'Delistings', 'show' => true],
            (object)['name' => 'Euronext', 'show' => true],
            (object)['name' => 'Shanghai', 'show' => true],
            (object)['name' => 'LSE', 'show' => true],
            (object)['name' => 'TSX', 'show' => true],
            (object)['name' => 'Japan', 'show' => true],
            (object)['name' => 'Press Release', 'show' => true],
            (object)['name' => 'Products', 'show' => true],
            (object)['name' => 'Company Profile', 'show' => true],
            (object)['name' => 'Geographic', 'show' => true],
            (object)['name' => 'Metrics', 'show' => true],
            (object)['name' => 'Full Report', 'show' => true],
            (object)['name' => 'Shareholders', 'show' => true],
            (object)['name' => 'Summary', 'show' => true],
            (object)['name' => 'Insider', 'show' => true],
            (object)['name' => 'Filings', 'show' => true],
            (object)['name' => 'Splits', 'show' => true],
            (object)['name' => 'Chart', 'show' => true],
            (object)['name' => 'Executive Compensation', 'show' => true],
            (object)['name' => 'Restatement', 'show' => true],
            (object)['name' => 'Employee Count', 'show' => true],
            (object)['name' => 'Fail To Deliver', 'show' => true]
        ];

        $collection = collect($query);
        
        foreach($collection as $value) {
            if (isset($value->name) && !empty($value->name)) {
                Log::debug("`Name` is set and not empty: {$value->name}");
                try {
                    $navbar = Navbar::updateOrCreate(
                        [
                            'name' => $value->name, 
                            'show' => $value->show, 
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding navbar item: {$e->getMessage()}");
                }
            }
        }
    }
}