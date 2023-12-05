<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\Modal\Modal;

class UpgradeAccountModal extends Modal
{
    public string $content = '';
    public bool $submitted = false;

    protected $rules = [
        'content' => ['required', 'string', 'min:5'],
    ];

    protected $messages = [
        'content.required' => 'Please enter a message.',
        'content.min' => 'Please write a minimum of 5 characters.',
    ];

    public function render()
    {
        return view('livewire.upgrade-account-modal');
    }

    public static function attributes(): array
    {
        return [
            'size' => 'xl',
        ];
    }

    public function submit() {
        $this->validate();

        // Do something with the content

        $this->submitted = true;
    }
}
