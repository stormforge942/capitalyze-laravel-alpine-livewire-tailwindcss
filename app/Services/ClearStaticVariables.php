<?php

namespace App\Services;

use App\Services\TableBuilderService;
use WireElements\Pro\Components\Spotlight\Spotlight;

class ClearStaticVariables
{
    public function handle(): void
    {
        $this->clearSpotlightMemory();
        $this->clearTableBuilderMemory();
    }

    private function clearSpotlightMemory(): void
    {
        Spotlight::$tips = [];
        Spotlight::$actions = [];
        Spotlight::$tokens = [];
        Spotlight::$scopes = [];
        Spotlight::$groups = [];
        Spotlight::$queries = [];
        Spotlight::$modes = [];
    }

    private function clearTableBuilderMemory(): void
    {
        TableBuilderService::$options = null;
    }
}
