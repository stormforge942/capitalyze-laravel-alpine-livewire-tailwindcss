<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;

trait AsTab
{
    protected array $data = [];

    public static function title(): string
    {
        return Str::title(Str::snake(class_basename(get_called_class()), ' '));
    }

    public static function key(): string
    {
        return Str::kebab(static::title());
    }
}
