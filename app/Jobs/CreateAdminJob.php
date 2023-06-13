<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $adminDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $adminDetails)
    {
        $this->adminDetails = $adminDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = new User();
        $user->name = $this->adminDetails['name'];
        $user->email = $this->adminDetails['email'];
        $user->password =  Hash::make($this->adminDetails['password']);
        $user->email_verified_at = now();
        $user->is_approved = true;
        $user->is_admin = true;
        $user->save();
    }
}
