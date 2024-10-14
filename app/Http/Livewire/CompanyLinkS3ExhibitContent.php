<?php

namespace App\Http\Livewire;

use App\Models\CompanyLinks;
use Illuminate\Http\Request;
use WireElements\Pro\Components\Modal\Modal;

class CompanyLinkS3ExhibitContent extends Modal
{
    public string $activeLink;
    public array $row;
    public string $content;
    public array $tabs;
    public array $data;

    public array $tabTitlesMap = [
        'Document Format Files' => 'document_format_files',
        'Data Files' => 'data_files',
    ];

    public $activeTab = [
        'Document Format Files' => [
            'key' => 'document_format_files',
            'title' => 'Document Format Files'
        ],
    ];

    public function render()
    {
        return view('livewire.company-link-s3-exhibit-content');
    }

    public function mount(Request $request)
    {
        $this->activeTab = [
            'key' => $request->query('presentationTab'),
            'title' => 'Document Format Files'
        ];
    }

    public function loadData()
    {
        $entry = CompanyLinks::query()
            ->where([
                'symbol' => $this->row['symbol'],
                'acceptance_time' => $this->row['acceptance_time'],
                'form_type' => $this->row['form_type'],
            ])
            ->first();

        $s3ExhibitLinksData = json_decode($entry->exhibit_s3_links, true);

        if (!isset($s3ExhibitLinksData)) {
            return;
        }

        $s3ExhibitLinksFormatedData = array_reduce($s3ExhibitLinksData, function ($carry, $item) {
            if (!isset($carry[$item['folder']])) {
                $carry[$item['folder']] = [];
            }

            $carry[$item['folder']][] = [
                'id' => uniqid(),
                'link' => $item['link'],
                'name' => $item['type']
            ];

            return $carry;
        }, []);

        $this->data = $s3ExhibitLinksFormatedData;

        $this->tabs = array_reduce($s3ExhibitLinksData, function ($carry, $item) {
            if (!isset($carry[$item['folder']])) {
                $carry[$this->tabTitlesMap[$item['folder']]] = [
                    'title' => $item['folder'],
                    'key' => $this->tabTitlesMap[$item['folder']],
                ];
            }

            return $carry;
        }, []);

        $this->refresh();
    }

    public static function attributes(): array
    {
        return [
            'size' => '4xl',
        ];
    }

    public function setTabName($tab)
    {
        $this->activeTab = $tab;
    }

    public function setContent($link)
    {
        if (str_ends_with($link, '.jpg')) {
            $this->content = '<div class="flex justify-center"><img ' . 'src="' . $link . '"</div>';
            return;
        }

        $this->content = $link ? (file_get_contents($link) ?? '') : '';
        $this->content = mb_convert_encoding($this->content, 'UTF-8', 'UTF-8');

        if ($this->isXmlContent($this->content)) {
            $formatedXml = $this->formatXml(preg_replace('/<\/?(html|body)[^>]*>/', '', $this->content));
            $this->content = '<textarea class="w-full border-none" disabled rows="50">' . $formatedXml . '</textarea>';

            return;
        };

        $finalLinkImage = dirname($link);
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
    }

    public function refresh()
    {
        $this->content = '';

        if(isset($this->data[$this->activeTab['title']][0])) {
            $this->setContent($this->data[$this->activeTab['title']][0]['link']);
            $this->activeLink = $this->data[$this->activeTab['title']][0]['id'];
        }
    }

    public function isXmlContent($content) {
        return strpos($content, '<?xml') !== false || strpos($content, 'xmlns:') !== false;
    }

    function formatXml($xmlContent) {
        $dom = new \DOMDocument('1.0', 'UTF-8');

        \libxml_use_internal_errors(true);

        if (!$dom->loadXML($xmlContent)) {
            return $xmlContent;
        }

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        return $dom->saveXML();
    }
}
