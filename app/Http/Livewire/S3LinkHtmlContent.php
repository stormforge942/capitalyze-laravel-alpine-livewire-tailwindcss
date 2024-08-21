<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;

class S3LinkHtmlContent extends SlideOver
{
    public string $symbol;
    public string $url;
    public ?int $quantity = null;
    private string $content = '';
    public ?string $sourceLink = null;

    public function render()
    {
        return view('livewire.s3-link-html-content', [
            'content' => $this->content
        ]);
    }

    public function load()
    {
        $this->content =  $this->url ? (file_get_contents($this->url) ?? '') : '';

        $this->content = $this->removeThirdPartyJs($this->content);
        $this->content = $this->injectLinkClickPrevent($this->content);
        $this->content = $this->removeNotLoadedIcons($this->content);
        $this->content = $this->makeFullLinkImage($this->content);
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }

    private function removeThirdPartyJs(string $html): string
    {
        return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
    }

    private function removeNotLoadedIcons(string $html): string
    {
        $css = '<style> i::before, i::after, span::before, span::after { display: none !important; } </style>';

        return str_replace('</head>', $css . '</head>', $html);
    }

    private function injectLinkClickPrevent(string $html): string
    {
        return preg_replace_callback(
            '/<a\s+([^>]*href=["\'][^"\']*["\'][^>]*)>/i',
            function ($matches) {
                return '<a ' . $matches[1] . ' onclick="return false;">';
            },
            $html
        );
    }

    private function makeFullLinkImage(string $html): string
    {
        if (!$this->sourceLink) {
            return $html;
        }

        $finalLinkImage = dirname($this->sourceLink);

        $htmlContent = preg_replace_callback(
            '/<img\s+([^>]*)(src="([^"]+\.jpg)")([^>]*)>/i',
            function ($matches) use ($finalLinkImage) {
                $beforeSrcAttributes = $matches[1];
                $imgSrc = $matches[3];
                $afterSrcAttributes = $matches[4];

                if (strpos($imgSrc, 'https://www.sec.gov') !== 0) {
                    $imgSrc = $finalLinkImage . '/' . $imgSrc;
                }

                return '<img ' . $beforeSrcAttributes . 'src="' . $imgSrc . '"' . $afterSrcAttributes . '>';
            },
            $html
        );

        return $htmlContent;
    }
}
