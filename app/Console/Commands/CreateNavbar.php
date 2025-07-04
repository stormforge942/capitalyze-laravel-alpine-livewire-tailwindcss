<?php

namespace App\Console\Commands;

use App\Models\Navbar;
use Illuminate\Console\Command;
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

    public function titleCase($input)
    {
        $map = [
            'track-investors' => 'Track Investors',
            'event-filings' => 'Events Tracker',
            'insider-transactions' => 'Insider Transactions',
            'earnings-calendar' => 'Earnings Calendar',
            'economics-calendar' => 'Economics Calendar',
            'company.profile' => 'Overview',
            'company.report' => 'Financials',
            'company.analysis' => 'Analysis',
            'company.filings-summary' => 'Filings',
            'company.ownership' => 'Ownership',
            'builder.chart' => 'Chart',
            'builder.table' => 'Table',
            'screener' => 'Screener',
            'investor-adviser' => 'Investor Advisers',
        ];

        return $map[$input] ?? implode(' ', array_map('ucfirst', explode('.', str_replace('-', '.', $input))));
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routeCollection = Route::getRoutes();

        foreach ($routeCollection as $value) {
            if ($value->getName()) {
                $query[] = $value->getName();
            }
        }

        $collection = collect($query);

        foreach ($collection as $value) {
            $isModdable = !in_array($value, [
                'login',
                'password.request',
                'logout',
                'password.reset',
                'password.reset.successful',
                'password.reset-link.sent',
                'password.email',
                'password.update',
                'register',
                'verification.notice',
                'verification.verify',
                'verification.send',
                'user-profile-information.update',
                'user-password.update',
                'password.confirmation',
                'password.confirm',
                'two-factor.login',
                'two-factor.enable',
                'two-factor.confirm',
                'two-factor.disable',
                'two-factor.qr-code',
                'two-factor.secret-key',
                'two-factor.recovery-codes',
                'profile.show',
                'sanctum.csrf-cookie',
                'livewire.message',
                'livewire.message-localized',
                'livewire.upload-file',
                'livewire.preview-file',
                'ignition.healthCheck',
                'ignition.executeSolution',
                'ignition.updateConfig',
                'home',
                'waitlist.join',
                'dashboard',
                'admin.users',
                'admin.permission-management',
                'admin.groups-management',
                'admin.feedbacks-management',
                'waiting-for-approval',
                'settings.update',
                'chart-builder.update',
                'table-builder.update',
                'table-builder.update-note',
                'table-builder.update.table-order',
            ]);

            Navbar::query()
                ->updateOrCreate([
                    'route_name' => $value
                ], [
                    'name' => $this->titleCase($value),
                    'is_moddable' => $isModdable,
                    'is_route' => true,
                ]);
        }

        Navbar::query()
            ->updateOrCreate([
                'route_name' => 'create.company.segment.report',
            ], [
                'name' => $this->titleCase("Reviewer Access"),
                'is_moddable' => true,
                'is_route' => false,
            ]);

        Navbar::query()->where('route_name', 'track-investor')->delete();
        Navbar::query()
            ->updateOrCreate([
                'route_name' => 'track-investors',
            ], [
                'name' => $this->titleCase("track-investors"),
                'is_moddable' => true,
                'is_route' => true,
            ]);

        $this->info('Navbar imported successfully!');
    }
}
