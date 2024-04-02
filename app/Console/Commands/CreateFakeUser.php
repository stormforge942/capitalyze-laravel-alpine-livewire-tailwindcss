<?php

namespace App\Console\Commands;
use App\Models\User;

use Illuminate\Console\Command;

class CreateFakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a fake user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $user = User::updateOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => "test",
                'password' => bcrypt('password'),
                'is_approved' => true,
                'is_admin' => true,
                'group_id' => 4,
                'linkedin_link' => null,
            ]
        );
        
        $user->email_verified_at = now();
        $user->save();        

       
    }
}
