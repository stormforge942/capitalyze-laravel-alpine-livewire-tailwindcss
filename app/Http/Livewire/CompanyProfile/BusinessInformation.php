<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use App\Models\CompanyPresentation;
use Illuminate\Support\Facades\Cache;

class BusinessInformation extends Component
{
    use AsTab;

    public $menuLinks;
    public $imagesUrl;

    public function mount($data = [])
    {
        $ticker = $data['profile']['symbol'];

        $cacheKey = 'company_presentation_' . $ticker . '_10-K';

        $cacheDuration = 3600;

        $this->menuLinks = Cache::remember($cacheKey, $cacheDuration, function () use ($ticker) {
            return CompanyPresentation::query()
                ->where('form_type', '10-K')
                ->where('symbol', $ticker)
                ->orderByDesc('acceptance_time')
                ->first()
                ?->toArray() ?? [];
        });

        $imagesUrl = '';

        if ($this->menuLinks) {
            $parsedUrl = parse_url($this->menuLinks['url']);
            $folderPath = dirname($parsedUrl['path']);
            $imagesUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $folderPath;
        }

        $this->imagesUrl = $imagesUrl;
    }

    public function render()
    {
        return view('livewire.company-profile.business-information');
    }
}
