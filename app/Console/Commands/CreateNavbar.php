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
                    $isModdable = true;

                    $notModdable = $value === 'login' 
                    || $value === 'password.request' 
                    || $value === 'logout' 
                    || $value === 'password.reset' 
                    || $value === 'password.email' 
                    || $value === 'password.update'
                    || $value === 'register'
                    || $value === 'verification.notice'
                    || $value === 'verification.verify'
                    || $value === 'verification.send'
                    || $value === 'user-profile-information.update'
                    || $value === 'user-password.update'
                    || $value === 'password.confirmation'
                    || $value === 'password.confirm'
                    || $value === 'two-factor.login'
                    || $value === 'two-factor.enable'
                    || $value === 'two-factor.confirm'
                    || $value === 'two-factor.disable'
                    || $value === 'two-factor.qr-code'
                    || $value === 'two-factor.secret-key'
                    || $value === 'two-factor.recovery-codes'
                    || $value === 'profile.show'
                    || $value === 'sanctum.csrf-cookie'
                    || $value === 'livewire.message'
                    || $value === 'livewire.message-localized'
                    || $value === 'livewire.upload-file'
                    || $value === 'livewire.preview-file'
                    || $value === 'ignition.healthCheck'
                    || $value === 'ignition.executeSolution'
                    || $value === 'ignition.updateConfig'
                    || $value === 'home'
                    || $value === 'dashboard'
                    || $value === 'admin.users'
                    || $value === 'admin.navbar-management'
                    || $value === 'admin.groups-management'
                    || $value === 'waiting-for-approval';

                    if ($notModdable) {
                        $isModdable = false;
                    }

                    $navbar = Navbar::create(
                        [
                            'name' => $this->titleCase($value), 
                            'route_name' => $value, 
                            'is_moddable' => $isModdable
                        ],
                    );
                }
            } catch (\Exception $e) {
                Log::error("Error creating or finding navbar item: {$e->getMessage()}");
            }
        }
    }
}