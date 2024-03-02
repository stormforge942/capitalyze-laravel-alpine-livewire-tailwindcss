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
                ]
            ],
            [
                'title' => 'S-11',
                'description' => 'Initial registration of new securities for REITs',
                'match' => [
                    'in' => ['S-11'],
                ]
            ],
            [
                'title' => '10-12B',
                'description' => 'Initial registration of securities for a spinoff',
                'match' => [
                    'in' => ['10-12B'],
                ]
            ],
            [
                'title' => '10-12G',
                'description' => 'Initial registration of a new class of securities',
                'match' => [
                    'in' => ['10-12G'],
                ]
            ],
            [
                'title' => 'F-1',
                'description' => 'Initial registration of new securities for foreign issuer',
                'match' => [
                    'in' => ['F-1'],
                ]
            ],
            [
                'title' => 'F-10',
                'description' => 'Initial registration of new securities for Canadian issuer',
                'match' => [
                    'in' => ['F-10'],
                ]
            ],
        ],
        'Additional Registrations' => [
            [
                'title' => 'S-3',
                'description' => 'Shelf registration',
                'match' => [
                    'in' => ['S-3'],
                ]
            ],
            [
                'title' => 'S-4',
                'description' => 'Registration of securities for M&A',
                'match' => [
                    'in' => ['S-4'],
                ]
            ],
            [
                'title' => 'S-8',
                'description' => 'Registration of securities for employees',
                'match' => [
                    'in' => ['S-8'],
                ]
            ],
        ],
        'Activism and Proxy' => [
            [
                'title' => 'SC 13D',
                'description' => '≥5% ownership disclosure by active investor',
                'match' => [
                    'in' => ['SC 13D'],
                ]
            ],
            [
                'title' => 'DFAN14A',
                'description' => 'Proxy materials by non-management',
                'match' => [
                    'in' => ['DFAN14A'],
                ]
            ],
            [
                'title' => 'PREC14A',
                'description' => 'Preliminary proxy in contested situation',
                'match' => [
                    'in' => ['PREC14A'],
                ]
            ],
            [
                'title' => 'PRRRN14A',
                'description' => 'Revised preliminary proxy by non-management',
                'match' => [
                    'in' => ['PRRRN14A'],
                ]
            ],
            [
                'title' => 'DEFC14A',
                'description' => 'Proxy in contested situation',
                'match' => [
                    'in' => ['DEFC14A'],
                ]
            ],
            [
                'title' => 'Other Proxies',
                'description' => 'DEFC14A, DEFN14A, DFRN14A, PREN14A and more',
                'match' => [
                    'in' => ['DEFC14A', 'DEFN14A', 'DFRN14A', 'PREN14A', 'PREM14A', 'DEFA14A', 'PRER14A', 'DEFR14A'],
                ]
            ]
        ],
        'Restatements' => [
            [
                'title' => 'NT 10-K',
                'description' => 'Late annual filings notification',
                'match' => [
                    'in' => ['NT 10-K'],
                ]
            ],
            [
                'title' => 'NT 10-Q',
                'description' => 'Late quarterly filing notification',
                'match' => [
                    'in' => ['NT 10-Q'],
                ]
            ],
            [
                'title' => 'Correspondence',
                'description' => 'CORRESP, DOSLTR, DRSLTR, UPLOAD',
                'match' => [
                    'in' => ['CORRESP', 'DOSLTR', 'DRSLTR', 'UPLOAD'],
                ]
            ],
        ],
        'Tender Offer' => [
            [
                'title' => 'SC 13E3',
                'description' => 'Going private transaction',
                'match' => [
                    'in' => ['SC 13E3'],
                ]
            ],
            [
                'title' => 'SC 14F1',
                'description' => 'Change in board majority',
                'match' => [
                    'in' => ['SC 14F1'],
                ]
            ],
            [
                'title' => 'Tender Offer Filings',
                'description' => 'SC TO-I, SC TO-T, SC 14D9, and more',
                'match' => [
                    'in' => ['SC TO-I', 'SC TO-T', 'SC 14D9'],
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
