<?php

namespace App\Http\Livewire\AccountSettings;

use App\Mail\TeamInvitationMail;
use App\Models\PendingInvitation;
use App\Models\TeamMember;
use App\Models\User;
use App\Traits\Refreshable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class TeamMembers extends Component
{
    use InteractsWithConfirmationModal, Refreshable;

    private $team;

    public $roles;

    public $members;

    public $current;

    public $invitations;

    public function boot()
    {
        $this->team = request()->user()->team;
    }

    public function mount(Request $request)
    {
        $this->roles = $this->team->roles->reduce(function ($carry, $role) {
            $carry[$role->id] = $role->name;

            return $carry;
        }, []);

        $this->current = $request->query('current');

        $this->getMembers();
        $this->getInvitations();
    }

    public function addMembers($newMembers)
    {
        $members = TeamMember::query()->pluck('user_id')->toArray();

        try {
            foreach ($newMembers as $newMember) {
                $user = User::where('email', $newMember['email'])->first();

                // if user is the owner or already a member, skip
                if ($user && ($user->id === $this->team->owner_id || in_array($user->id, $members))) {
                    continue;
                }

                $invitation = $this->addPendingInvitation($newMember['email'], $newMember['role']);
                Mail::to($newMember['email'])->queue(new TeamInvitationMail($invitation));
            }

            $this->getInvitations();
        } catch (\Exception $e) {
            logger($e->getMessage());
            $this->addError('addMembers', $e->getMessage());
        }
    }

    public function getMembers()
    {
        $fields = [
            'name', 'email', 'last_activity_at', 'id', 'facebook_link', 'twitter_link', 'job', 'dob',
        ];

        $owner = $this->team->owner()->select($fields)->first();

        $this->members = [
            [
                ...$owner->toArray(),
                'role_id' => null,
                'isOwner' => true,
                'last_activity_at' => $owner->last_activity_at?->format('jS F, Y h:ia T'),
                'start_date' => $this->team->created_at?->format('jS F, Y'),
            ],
            ...TeamMember::query()->where('team_id', $this->team->id)
                ->with(['user' => fn ($q) => $q->select($fields)])
                ->get()
                ->map(function ($item) {
                    return [
                        ...$item['user']->toArray(),
                        'role_id' => $item['role_id'],
                        'isOwner' => false,
                        'last_activity_at' => $item['user']['last_activity_at']?->format('jS F, Y h:ia T'),
                        'start_date' => $item['created_at']?->format('jS F, Y'),
                    ];
                }),
        ];
    }

    public function getInvitations()
    {
        $this->invitations = PendingInvitation::where('team_id', $this->team->id)->with('role')->get()->toArray();
    }

    public function addPendingInvitation($email, $role_id)
    {
        return PendingInvitation::query()
            ->updateOrCreate([
                'email' => $email,
                'team_id' => $this->team->id,
            ], [
                'role_id' => $role_id,
            ]);
    }

    public function deleteInvitation($id)
    {
        PendingInvitation::where('team_id', $this->team->id)
            ->where('id', $id)
            ->delete();

        $this->getInvitations();
    }

    public function removeMember($id)
    {
        $this->askForConfirmation(
            callback: function () use ($id) {
                if ($this->team->owner_id === $id) {
                    return;
                }

                DB::transaction(function () use ($id) {
                    TeamMember::query()->where([
                        'team_id' => $this->team->id,
                        'user_id' => $id,
                    ])
                        ->delete();

                    User::query()->update(['current_team_id' => null]);
                });

                $this->getMembers();

                $this->current = null;
            },
        );
    }

    public function updateRole($id, $role)
    {
        $role = $this->team->roles()->find($role);

        if (! $role) {
            return;
        }

        TeamMember::query()
            ->where(['team_id' => $this->team->id, 'user_id' => $id])
            ->update(['role_id' => $role->id]);
    }

    public function render()
    {
        return view('livewire.account-settings.team-members', [
            'columns' => [
                [
                    'name' => 'Name',
                    'key' => 'name',
                    'center' => true,
                ],
                [
                    'name' => 'Role',
                    'key' => 'role',
                ],
                [
                    'name' => 'Last Activity',
                    'key' => 'last_activity',
                ],
                [
                    'name' => 'Start Date',
                    'key' => 'state_date',
                ],
            ],
        ]);
    }
}
