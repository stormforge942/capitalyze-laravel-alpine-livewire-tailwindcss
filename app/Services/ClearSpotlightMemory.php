<?php

namespace App\Services;

use WireElements\Pro\Components\Spotlight\Spotlight;

class ClearSpotlightMemory
{
    public function handle(): void
    {
        Spotlight::$tips = [];
        Spotlight::$actions = [];
        Spotlight::$tokens = [];
        Spotlight::$scopes = [];
        Spotlight::$groups = [];
        Spotlight::$queries = [];
        Spotlight::$modes = [];
    }
}
