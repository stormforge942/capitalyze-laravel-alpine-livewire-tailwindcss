<?php

namespace App\Console\Commands;

use App\Jobs\CreateAdminJob;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        CreateAdminJob::dispatch([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->info('Admin user created successfully.');

        return 0;
    }
}
