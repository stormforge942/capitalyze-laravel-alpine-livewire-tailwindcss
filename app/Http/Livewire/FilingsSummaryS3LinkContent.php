<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class FilingsSummaryS3LinkContent extends SlideOver
{
    public string $cik;
    public string $date;
    public string $name_of_issuer;
    public string $content = '';

    public function render()
    {
        return view('livewire.filings-summary-s3-link-content');
    }

    public function load()  // Accepts the name of the issuer to find
    {
        $url = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->where([
                'cik' => $this->cik,
                'date' => $this->date,
            ])
            ->value('s3_url');

        $this->content = file_get_contents($url);

        $dom = new \DOMDocument();
        @$dom->loadHTML($this->content);  // Suppress warnings from malformed HTML

        $xpath = new \DOMXPath($dom);
        $tables = $xpath->query("//table[@summary]");

        if ($tables->length > 0) {
            $lastTable = $tables->item($tables->length - 1);
            $rows = $lastTable->getElementsByTagName('tr');

            // Find the row index containing the specified issuer name
            $targetRowIndex = -1;
            foreach ($rows as $index => $row) {
                if ($index == 0) continue;  // Skip the header row if present
                $cells = $row->getElementsByTagName('td');
                if ($cells->length > 0 && strtolower(trim($cells->item(0)->textContent)) === strtolower(trim($this->name_of_issuer))) {
                    foreach ($row->childNodes as $cell) {
                        // Check if the node is a TD element
                        // dump($cell->textContent);
                        if ($cell->nodeName === 'td' && trim($cell->textContent) != "\u{A0}") {
                            // Create a span element
                            $span = $dom->createElement('span');
                            // Set the background color style to the span
                            $span->setAttribute('style', 'background-color:yellow; display: inline-block; padding: 2px;'); // Example style: gray background
                            // Move the content of the cell to the span
                            while ($cell->firstChild) {
                                $span->appendChild($cell->firstChild);
                            }
                            // Replace the content of the cell with the span
                            $cell->appendChild($span);
                        }
                    }
                    $targetRowIndex = $index;
                }
            }

            // Calculate page number based on the row index
            $page = ($targetRowIndex != -1) ? intval(($targetRowIndex - 3) / 10) + 1 : 1;

            $paginationStartIndex = 3;
            $startIndex = ($page - 1) * 10 + $paginationStartIndex;
            $endIndex = $startIndex + 10;

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
        } else {
            dd("No tables with a 'summary' attribute found.");
        }
    }

    


    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
