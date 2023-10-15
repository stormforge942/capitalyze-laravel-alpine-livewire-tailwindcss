<?php

namespace App\Actions\Fortify;

use App\Rules\ComplexPassword;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return [
            'required',
            'string',
            new ComplexPassword,
            'confirmed'
        ];
    }
}
