<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Roles extends Component
{
    use AsTab;

    public $current;

    public $roles;

    public $permissions;

    protected $queryString = [
        'current' => ['except' => ''],
    ];

    public function mount(Request $request)
    {
        $this->current = $request->query('current', '');

        $this->permissions = Permission::all();
        $this->getRoles();
    }

    public function updateCurrent($current)
    {
        $this->current = $current;
    }

    public function getRoles()
    {
        $this->roles = Role::with('permissions')
            ->where('team_id', Auth::user()->current_team_id)
            ->get()->toArray();
    }

    public function addRole($roleName, $permissionStatus)
    {
        $role = Role::create(['name' => $roleName, 'team_id' => Auth::user()->current_team_id]);
        $role->permissions()->sync($permissionStatus);

        $this->getRoles();

        $this->emitTo(TeamMembers::class, 'refresh');
    }

    public function updateRole($id, $roleName, $permissionStatus)
    {
        $role = Role::find($id);
        $role->name = $roleName;
        $role->permissions()->sync($permissionStatus);
        $role->save();

        $this->getRoles();
    }

    public function render()
    {
        return view('livewire.account-settings.roles');
    }
}
