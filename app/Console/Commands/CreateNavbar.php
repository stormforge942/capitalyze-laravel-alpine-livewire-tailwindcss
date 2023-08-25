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
            (object)['name' => 'Earnings Calendar', 'show' => false],
            (object)['name' => 'Economics Calendar', 'show' => false],
            (object)['name' => 'Company Filings', 'show' => false],
            (object)['name' => 'Funds Filings', 'show' => false],
            (object)['name' => 'Mutual Funds Filings', 'show' => false],
            (object)['name' => 'Company Identifiers', 'show' => false],
            (object)['name' => 'Delistings', 'show' => false],
            (object)['name' => 'Euronext', 'show' => false],
            (object)['name' => 'Shanghai', 'show' => false],
            (object)['name' => 'LSE', 'show' => false],
            (object)['name' => 'TSX', 'show' => false],
            (object)['name' => 'Japan', 'show' => false],
            (object)['name' => 'Press Release', 'show' => false],
            (object)['name' => 'Products', 'show' => false],
            (object)['name' => 'Company Profile', 'show' => false],
            (object)['name' => 'Geographic', 'show' => false],
            (object)['name' => 'Metrics', 'show' => false],
            (object)['name' => 'Full Report', 'show' => false],
            (object)['name' => 'Shareholders', 'show' => false],
            (object)['name' => 'Summary', 'show' => false],
            (object)['name' => 'Insider', 'show' => false],
            (object)['name' => 'Filings', 'show' => false],
            (object)['name' => 'Splits', 'show' => false],
            (object)['name' => 'Chart', 'show' => false],
            (object)['name' => 'Executive Compensation', 'show' => false],
            (object)['name' => 'Restatement', 'show' => false],
            (object)['name' => 'Employee Count', 'show' => false],
            (object)['name' => 'Fail To Deliver', 'show' => false]
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