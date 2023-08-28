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
            (object)['name' => 'Earnings Calendar', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Economics Calendar', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Company Filings', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Funds Filings', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Mutual Funds Filings', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Company Identifiers', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Delistings', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Euronext', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Shanghai', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'LSE', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'TSX', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'HKEX', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Japan', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Press Release', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Products', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Company Profile', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Geographic', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Metrics', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Full Report', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Shareholders', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Summary', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Insider', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Filings', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Splits', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Chart', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Executive Compensation', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Restatement', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Employee Count', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true],
            (object)['name' => 'Fail To Deliver', 'show_users' => true, 'show_admins' => true, 'show_testers' => true, 'show_developers' => true]
        ];

        $collection = collect($query);
        
        foreach($collection as $value) {
            if (isset($value->name) && !empty($value->name)) {
                Log::debug("`Name` is set and not empty: {$value->name}");
                try {
                    $navbar = Navbar::updateOrCreate(
                        [
                            'name' => $value->name, 
                            'show_users' => $value->show_users, 
                            'show_admins' => $value->show_admins, 
                            'show_developers' => $value->show_developers, 
                            'show_testers' => $value->show_testers, 
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding navbar item: {$e->getMessage()}");
                }
            }
        }
    }
}