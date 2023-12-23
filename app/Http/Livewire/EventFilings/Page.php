<?php

namespace App\Http\Livewire\EventFilings;

use Illuminate\Http\Request;
use Livewire\Component;

class Page extends Component
{
    protected $data = [
        'New Securities Registrations' => [
            [
                'title' => 'S-1',
                'description' => 'Initial registration of new securities (e.g. IPOs)',
                'match' => [
                    'in' => ['S-1'],
                    'patterns' => ['S-1/%'],
                ]
            ],
            [
                'title' => 'S-11',
                'description' => 'Initial registration of new securities for REITs',
                'match' => [
                    'in' => ['S-11'],
                    'patterns' => ['S-11/%'],
                ]
            ],
            [
                'title' => '10-12B',
                'description' => 'Initial registration of securities for a spinoff',
                'match' => [
                    'in' => ['10-12B'],
                    'patterns' => ['10-12B/%'],
                ]
            ],
            [
                'title' => '10-12G',
                'description' => 'Initial registration of a new class of securities',
                'match' => [
                    'in' => ['10-12G'],
                    'patterns' => ['10-12G/%'],
                ]
            ],
            [
                'title' => 'F-1',
                'description' => 'Initial registration of new securities for foreign issuer',
                'match' => [
                    'in' => ['F-1'],
                    'patterns' => ['F-1/%'],
                ]
            ],
            [
                'title' => 'F-10',
                'description' => 'Initial registration of new securities for Canadian issuer',
                'match' => [
                    'in' => ['F-10'],
                    'patterns' => ['F-10/%'],
                ]
            ],
        ],
        'Additional Securities Registrations' => [
            [
                'title' => 'S-3',
                'description' => 'Shelf registration',
                'match' => [
                    'in' => ['S-3'],
                    'patterns' => ['S-3/%'],
                ]
            ],
            [
                'title' => 'S-8',
                'description' => 'Registration of securities for employees',
                'match' => [
                    'in' => ['S-8'],
                    'patterns' => ['S-8/%'],
                ]
            ],
        ],
        'Activism and Proxy Fights' => [
            [
                'title' => 'SC 13D',
                'description' => '≥5% ownership disclosure by active investor',
                'match' => [
                    'in' => ['SC 13D'],
                    'patterns' => ['SC 13D/%'],
                ]
            ],
            [
                'title' => 'DFAN14A',
                'description' => 'Proxy materials by non-management',
                'match' => [
                    'in' => ['DFAN14A'],
                    'patterns' => ['DFAN14A/%'],
                ]
            ],
            [
                'title' => 'PREC14A',
                'description' => 'Preliminary proxy in contested situation',
                'match' => [
                    'in' => ['PREC14A'],
                    'patterns' => ['PREC14A/%'],
                ]
            ],
            [
                'title' => 'PRRRN14A',
                'description' => 'Revised preliminary proxy by non-management',
                'match' => [
                    'in' => ['PRRRN14A'],
                    'patterns' => ['PRRRN14A/%'],
                ]
            ],
            [
                'title' => 'DEFC14A',
                'description' => 'Proxy in contested situation',
                'match' => [
                    'in' => ['DEFC14A'],
                    'patterns' => ['DEFC14A/%'],
                ]
            ],
            [
                'title' => 'Other proxy fights',
                'description' => 'DEFC14A, DEFN14A, DFRN14A, PREN14A and PREC14C',
                'match' => [
                    'in' => ['DEFC14A', 'DEFN14A', 'DFRN14A', 'PREC14C'],
                    'patterns' => ['DEFC14A/%', 'DEFN14A/%', 'DFRN14A/%', 'PREC14C/%'],
                ]
            ]
        ],
        'Late Filings' => [
            [
                'title' => 'NT 10-K',
                'description' => 'Late annual filings notification',
                'match' => [
                    'in' => ['NT 10-K'],
                    'patterns' => ['NT 10-K/%'],
                ]
            ],
            [
                'title' => 'NT 10-Q',
                'description' => 'Late quarterly filing notification',
                'match' => [
                    'in' => ['NT 10-Q'],
                    'patterns' => ['NT 10-Q/%'],
                ]
            ]
        ]
    ];

    public $activeTab;
    public $activeSubTab;

    public function mount(Request $request)
    {
        $this->activeTab = $request->query('tab');
        if (!isset($this->data[$this->activeTab])) {
            $this->activeTab = array_key_first($this->data);
        }

        $this->activeSubTab = $request->query('subtab');
        if (!collect($this->data[$this->activeTab])->where('title', $this->activeSubTab)->first()) {
            $this->activeSubTab = $this->data[$this->activeTab][0]['title'];
        }
    }

    public function render()
    {
        return view('livewire.event-filings.page', [
            'data' => $this->data,
            'activeTab' => $this->activeTab,
            'activeSubTab' => $this->activeSubTab,
            'tableConfiguration' => collect($this->data[$this->activeTab])
                ->where('title', $this->activeSubTab)
                ->first()['match'],
        ]);
    }
}
