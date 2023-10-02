<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public string $email;
    public string $password;
    public string $remember;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember == 'on')) {
            throw ValidationException::withMessages([
                'email' => 'Email or password is incorrect.'
            ]);
        }

        return redirect()->intended();
    }

    protected function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ];
    }
}
