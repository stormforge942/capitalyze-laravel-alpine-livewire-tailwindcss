<?php

namespace App\Exceptions;

class CompanyNotFoundException extends \Exception
{
    public function __construct(private string $ticker)
    {
    }

    public function render()
    {
        return response()->view('errors.ticker-not-found', [
            'ticker' => $this->ticker
        ], 404);
    }
}
