<?php

namespace App\Http\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class FilingsSummaryS3LinkContent extends SlideOver
{
    public string $cik;
    public string $date;
    public string $name_of_issuer;
    public string $content = '';
    public ?string $url = null;
    public int $page = 0;
    public int $numberOfPages = 1;

    private const PAGE_SIZE = 20;

    public function updatedPage()
    {
        $this->load();
    }

    public function render()
    {
        $paginator = new LengthAwarePaginator([], $this->numberOfPages * self::PAGE_SIZE, self::PAGE_SIZE, $this->page);

        return view('livewire.filings-summary-s3-link-content', [
            'pages' => $paginator->linkCollection(),
        ]);
    }

    public function load(?int $page = null)
    {
        // Increase the time limit to 3 minutes
        set_time_limit(60 * 3);

        if ($page) {
            $this->page = $page;
        }

        if (!$this->url) {
            $this->url = DB::connection('pgsql-xbrl')
                ->table('filings_summary')
                ->where([
                    'cik' => $this->cik,
                    'date' => $this->date,
                ])
                ->value('s3_url');
        }

        if (!$this->url) {
            return;
        }

        // $this->content = Cache::driver('file')->remember('filing_summary_s3_content:' . $this->url, 3600, fn () => file_get_contents($this->url));
        $this->content = file_get_contents($this->url);

        $this->paginateContent();
    }

    public function paginateContent()
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($this->content);

        $xpath = new \DOMXPath($dom);
        $tables = $xpath->query("//table[@summary]");

        if (!$tables->length) return;

        $lastTable = $tables->item($tables->length - 1);

        if (!$lastTable) {
            return;
        }

        $rows = $lastTable->getElementsByTagName('tr');

        $this->numberOfPages = ceil(($rows->length - 3) / self::PAGE_SIZE);

        if ($this->page && $this->page > $this->numberOfPages) {
            $this->page = $this->numberOfPages;
        }

        $targetRowIndex = -1;
        foreach ($rows as $index => $row) {
            if ($index < 3) continue;

            $cells = $row->getElementsByTagName('td');

            if (
                $cells->length > 0 &&
                strtolower(trim($cells->item(0)->textContent)) === strtolower(trim($this->name_of_issuer))
            ) {
                foreach ($row->childNodes as $cell) {
                    if (trim($cell->textContent) != "\u{A0}") {
                        $span = $dom->createElement('span');
                        $span->setAttribute('style', 'background-color:yellow; display: inline-block; padding: 2px;');
                        while ($cell->firstChild) {
                            $span->appendChild($cell->firstChild);
                        }
                        $cell->appendChild($span);
                    }
                }

                $targetRowIndex = $targetRowIndex >= 0 ? $targetRowIndex : $index;
            }
        }

        // Calculate page number based on the row index
        $page = $this->page > 0
            ? $this->page
            : (($targetRowIndex != -1) ? intval(($targetRowIndex - 3) / self::PAGE_SIZE) + 1 : 1);

        $this->page = $page;

        $paginationStartIndex = 3;
        $startIndex = ($page - 1) * self::PAGE_SIZE + $paginationStartIndex;
        $endIndex = $startIndex + self::PAGE_SIZE;

        // Remove rows that are not within the range of $startIndex and $endIndex, excluding the first three
        for ($i = $rows->length - 1; $i >= $paginationStartIndex; $i--) {
            if ($i < $startIndex || $i >= $endIndex) {
                $rowParent = $rows->item($i)->parentNode;
                $rowParent->removeChild($rows->item($i));
            }
        }

        // Replace the original table with the modified one
        $originalParent = $lastTable->parentNode;
        $originalParent->replaceChild($dom->importNode($lastTable, true), $lastTable);

        $this->content = $dom->saveHTML();
    }


    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
