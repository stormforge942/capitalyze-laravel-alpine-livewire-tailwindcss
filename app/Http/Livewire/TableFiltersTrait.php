<?php

namespace App\Http\Livewire;

trait TableFiltersTrait
{
    public $view = 'Common Size';
    public $unitType = 'Millions';
    public $decimal = '0';
    public $template = 'Standart';
    public $order = 'Latest on the Right';
    public $freezePanes = 'Top Row';

    public function formatWithUnitType($value) {
        if (!$value) return '-';
        switch ($this->unitType) {
            case 'Billions':
                return number_format(floatval($value) / 1000 / 1000 / 1000,0).'B';
                break;
            case 'Millions':
                return number_format(floatval($value) / 1000 / 1000,0).'M';
                break;
            default:
                return number_format(floatval($value) / 1000 ,0).'T';
        }
    }
}
