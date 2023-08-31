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
            (object)['position' => 0, 'name' => 'Earnings Calendar'],
            (object)['position' => 1, 'name' => 'Economics Calendar'],
            (object)['position' => 2, 'name' => 'Company Filings'],
            (object)['position' => 3, 'name' => 'Funds Filings'],
            (object)['position' => 4, 'name' => 'Mutual Funds Filings'],
            (object)['position' => 5, 'name' => 'Company Identifiers'],
            (object)['position' => 6, 'name' => 'Delistings'],
            (object)['position' => 7, 'name' => 'Euronext'],
            (object)['position' => 8, 'name' => 'Shanghai'],
            (object)['position' => 9, 'name' => 'LSE'],
            (object)['position' => 10, 'name' => 'TSX'],
            (object)['position' => 11, 'name' => 'HKEX'],
            (object)['position' => 12, 'name' => 'Japan'],
            (object)['position' => 13, 'name' => 'Press Release'],
            (object)['position' => 14, 'name' => 'Products'],
            (object)['position' => 15, 'name' => 'Company Profile'],
            (object)['position' => 16, 'name' => 'Geographic'],
            (object)['position' => 17, 'name' => 'Metrics'],
            (object)['position' => 18, 'name' => 'Full Report'],
            (object)['position' => 19, 'name' => 'Shareholders'],
            (object)['position' => 20, 'name' => 'Summary'],
            (object)['position' => 21, 'name' => 'Insider'],
            (object)['position' => 22, 'name' => 'Filings'],
            (object)['position' => 23, 'name' => 'Splits'],
            (object)['position' => 24, 'name' => 'Chart'],
            (object)['position' => 25, 'name' => 'Executive Compensation'],
            (object)['position' => 26, 'name' => 'Restatement'],
            (object)['position' => 27, 'name' => 'Employee Count'],
            (object)['position' => 28, 'name' => 'Fail To Deliver']
        ];

        $collection = collect($query);
        
        foreach($collection as $value) {
            if (isset($value->name) && !empty($value->name)) {
                Log::debug("`Name` is set and not empty: {$value->name}");
                try {
                    $navbar = Navbar::updateOrCreate(
                        ['name' => $value->name],
                        ['position' => $value->position]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding navbar item: {$e->getMessage()}");
                }
            }
        }
    }
}