<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;

class S3LinkContent extends SlideOver
{
    public ?string $sourceLink = null;
    private string $content = '';
    public bool $highlightDates = false;

    public function render()
    {
        return view('livewire.s3-link-content', [
            'content' => $this->content
        ]);
    }

    public function load()
    {
        $this->content = $this->sourceLink ? (file_get_contents($this->sourceLink) ?? '') : '';

        if ($this->highlightDates) {
            $this->content = $this->_hightlightDates();
        }

        $this->content = $this->removeThirdPartyJs($this->content);
        $this->content = $this->injectLinkClickPrevent($this->content);
        $this->content = $this->removeNotLoadedIcons($this->content);
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
            function($matches) {
                return '<a ' . $matches[1] . ' onclick="return false;">';
            },
            $html
        );
    }

    
    private function _hightlightDates(): string
    {
        $dateRegexes = $this->createDateRegexes();

        // Match HTML tags and content separately
        $pattern = '/(<[^>]+>)([^<]*)(<\/[^>]+>)/s';
        
        // Callback function to highlight dates in the text content
        $replaceCallback = function ($matches) use ($dateRegexes) {
            $textContent = $matches[2];
            
            // Apply date highlighting to the text content
            foreach ($dateRegexes as $regex) {
                $textContent = preg_replace_callback($regex, function ($match) {
                    return '<span style="background-color:yellow; color: black; display: inline;">' . $match[0] . '</span>';
                }, $textContent);
            }

            return $matches[1] . $textContent . $matches[3];
        };

        // Apply regex replacements to HTML content
        $htmlContent = preg_replace_callback($pattern, $replaceCallback, $this->content);

        return $htmlContent;
    }

    private function createDateRegexes()
    {
        $keywords = [
            'conference call', 'investor call', 'teleconference', 'webcast', 'web cast', 'webinar', 'q&a session',
            'question and answer session', 'conference', 'chat', 'call'
        ];
        $references = ['today', 'this morning', 'this afternoon', 'this evening'];

        $keywords = array_map(fn ($keyword) => str_replace(' ', '\s+', $keyword), $keywords);

        $references = array_map(fn ($reference) => str_replace(' ', '\s+', $reference), $references);

        $month_names = [
            'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october',
            'november', 'december', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct',
            'nov', 'dec', 'jan.', 'feb.', 'mar.', 'apr.', 'may.', 'jun.', 'jul.', 'aug.', 'sep.', 'oct.',
            'nov.', 'dec.'
        ];
        $gmt_offsets  = [
            'gmt' => 0, 'utc' => 0, 'ect' => -1, 'cet' => -1, 'eet' => -2, 'sa' => -2, 'art' => -2, 'eat' => -3, 'met' => -3.5,
            'net' => -4, 'plt' => -5, 'ist' => -5.5, 'bst' => -6, 'vst' => -7, 'ctt' => -8, 'hong kong' => -8, 'jst' => -9,
            'act' => -9.5, 'aet' => -10, 'sst' => -11, 'nst' => -12, 'mit' => 11, 'hst' => 10, 'ast' => 9, 'pacific time' => 8,
            'pacific' => 8, 'pacific standard time' => 8, 'pst' => 8, 'pt' => 8, 'us pacific time' => 8, 'arizona time' => 8,
            'pdt' => 7, 'pnt' => 7, 'mountain time' => 7, 'mountain standard time' => 7, 'mst' => 7, 'mt' => 7, 'cst' => 6,
            'cdt' => 6, 'ct' => 6, 'central time' => 6, 'central standard time' => 6, 'central' => 6, 'us central time' => 6,
            'iet' => 5, 'est' => 5, 'et' => 5, 'eastern standard time' => 5, 'eastern time' => 5, 'us eastern time' => 5,
            'eastern' => 5, 'edt' => 4, 'eastern daylight time' => 4, 'prt' => 4, 'cnt' => 3.5, 'agt' => 3, 'bet' => 3, 'cat' => 1
        ];

        $month_names = array_map('preg_quote', $month_names);

        $keywords_regex = '(?:' . implode('|', $keywords) . ')';
        $references_regex = '(?:' . implode('|', $references) . ')';
        $date_regex = '(?<!quarter\sended\s)(?<!year\sended\s)((?:' . implode('|', $month_names) . ')\s+\d{1,2})[,\s]*(20\d{2}|)';
        $time_regex = '(\d{1,2}(?::\d{2})?)\s*([ap]\.?m\.?)[^.\/]+?(' . implode('|', array_keys($gmt_offsets)) . ')';

        $date_regexes = [
            sprintf('%s[^.]+?%s[^.]+?%s', $keywords_regex, $time_regex, $date_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $keywords_regex, $time_regex, $references_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $keywords_regex, $date_regex, $time_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $keywords_regex, $references_regex, $time_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $time_regex, $date_regex, $keywords_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $time_regex, $references_regex, $keywords_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $date_regex, $time_regex, $keywords_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $references_regex, $time_regex, $keywords_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $date_regex, $keywords_regex, $time_regex),
            sprintf('%s[^.]+?%s[^.]+?%s', $references_regex, $keywords_regex, $time_regex),
            sprintf('%s[^.]+?%s', $keywords_regex, $time_regex),
            sprintf('%s[^.]+?%s', $time_regex, $keywords_regex),
            $date_regex
        ];

        return array_map(fn ($pattern) => '/' . $pattern . '/i', $date_regexes);
    }
}
