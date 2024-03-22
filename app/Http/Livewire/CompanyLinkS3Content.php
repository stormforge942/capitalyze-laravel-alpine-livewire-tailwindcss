<?php

namespace App\Http\Livewire;

use App\Models\CompanyLinks;
use WireElements\Pro\Components\Modal\Modal;

class CompanyLinkS3Content extends Modal
{
    public ?string $s3Link = null;
    public string $content = '';
    public bool $loaded = false;
    public ?string $imageLink = null;

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


        $this->imageLink = CompanyLinks::query()
            ->where([
                'symbol' => $row['symbol'],
                'acceptance_time' => $row['acceptance_time'],
                'form_type' => $row['form_type'],
            ])
            ->first()
            ?->final_link;
    }

    public function render()
    {
        return view('livewire.company-link-s3-content');
    }

    public function loadData()
    {
        $this->content = $this->s3Link ? (file_get_contents($this->s3Link) ?? '') : '';
        $this->content = mb_convert_encoding($this->content, 'UTF-8', 'UTF-8');

        $finalLinkImage = dirname($this->imageLink);
        $this->content = preg_replace_callback(
            '/<img\s+([^>]*)(src="([^"]+\.jpg)")([^>]*)>/i',
            function ($matches) use ($finalLinkImage) {
                $beforeSrcAttributes = $matches[1]; 
                $imgSrc = $matches[3];
                $afterSrcAttributes = $matches[4];
        
                if (preg_match('/style="([^"]*)"/i', $beforeSrcAttributes . $afterSrcAttributes, $styleMatches)) {
                    $newStyle = rtrim($styleMatches[1], ';') . '; display: inline;';
                    $updatedAttributes = preg_replace('/style="([^"]*)"/i', 'style="' . $newStyle . '"', $beforeSrcAttributes . $afterSrcAttributes);
                } else {
                    $updatedAttributes = 'style="display: inline;" ' . $beforeSrcAttributes . $afterSrcAttributes;
                }
        
                if (strpos($imgSrc, 'https://www.sec.gov') !== 0) {
                    $imgSrc = $finalLinkImage . '/' . $imgSrc;
                }
        
                return '<img ' . $updatedAttributes . 'src="' . $imgSrc . '"';
            },
            $this->content
        );
        

        $this->loaded = true;
    }

    public static function attributes(): array
    {
        return [
            'size' => '4xl',
        ];
    }
}
