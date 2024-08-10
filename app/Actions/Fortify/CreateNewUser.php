<?php

namespace App\Actions\Fortify;

use App\Enums\Plan;
use App\Models\Team;
use App\Models\User;
use App\Models\Groups;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $this->createUser($input);
    }

    public function createUser(array $input): User
    {
        $group = Groups::where('name', "Users")->first();

        if ($group) {
            $groupId = $group->id;
        } else {
            $group = Groups::first();
            $groupId = $group->id;
        }

        $newUser = DB::transaction(function () use ($input, $groupId) {
            $newUser = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'is_approved' => false, // New users are not approved by default
                'group_id' => $groupId,
                'linkedin_link' => $input['linkedin_link'] ?? null,
            ]);

            $team = Team::create([
                'name' => $input['name'] . '\' Team',
                'plan' => Plan::SOLO,
                'owner_id' => $newUser->id
            ]);

            $newUser->update(['current_team_id' => $team->id]);

            return $newUser;
        });

        $admins = User::where('is_admin', true)->get(); // Fetch all admins

        foreach ($admins as $admin) {
            $admin->notify(new NewUser($newUser)); // Notify each admin about new user
        }

        return $newUser;
    }
}
