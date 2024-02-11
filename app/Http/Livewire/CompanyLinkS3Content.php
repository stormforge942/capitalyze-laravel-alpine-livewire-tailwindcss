<?php

namespace App\Http\Livewire;

use App\Models\CompanyLinks;
use WireElements\Pro\Components\Modal\Modal;

class CompanyLinkS3Content extends Modal
{
    public ?string $s3Link = null;
    public string $content = '';
    public bool $loaded = false;

    public function mount(array $row)
    {
        $this->s3Link = CompanyLinks::query()
            ->where([
                'symbol' => $row['symbol'],
                'acceptance_time' => $row['acceptance_time'],
                'form_type' => $row['form_type'],
            ])
            ->first()
            ?->s3_link;
    }

    public function render()
    {
        return view('livewire.company-link-s3-content');
    }

    public function loadData()
    {
        $this->content = $this->s3Link ? (file_get_contents($this->s3Link) ?? '') : '';
        $this->content = mb_convert_encoding($this->content, 'UTF-8', 'UTF-8');

        $this->loaded = true;
    }

    public static function attributes(): array
    {
        return [
            'size' => '4xl',
        ];
    }
}
