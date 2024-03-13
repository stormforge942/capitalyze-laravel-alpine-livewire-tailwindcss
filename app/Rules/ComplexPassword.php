<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ComplexPassword implements Rule
{
    private string $message = '';

    public function passes($attribute, $value)
    {
        if (strlen($value) < 8) {
            $this->message = 'Password must be at least 8 characters long.';
            return false;
        }

        // must contain at least one uppercase letter
        if (!preg_match('/[A-Z]/', $value)) {
            $this->message = 'Password must contain at least one uppercase letter.';
            return false;
        }

        // must contain at least one lowercase letter
        if (!preg_match('/[a-z]/', $value)) {
            $this->message = 'Password must contain at least one lowercase letter.';
            return false;
        }

        // must contain at least one symbol
        if (!preg_match('/[\'^£$%&*()}{@#!~?><>,|=_+¬-]/', $value)) {
            $this->message = 'Password must contain at least one symbol.';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}
