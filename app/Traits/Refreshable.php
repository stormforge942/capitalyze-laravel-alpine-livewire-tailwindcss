<?php

namespace App\Traits;

trait Refreshable
{
    public function getListeners()
    {
        return $this->listeners + [
            'refresh' => '$refresh',
        ];
    }
}
