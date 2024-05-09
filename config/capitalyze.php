<?php

return [
    'transaction_code_map' => [
        'P' => [
            'label' => 'Purchase',
            'description' => 'Open market or private purchase of non-derivative or derivative security'
        ],
        'S' => [
            'label' => 'Sale',
            'description' => 'Open market or private sale of non-derivative or derivative security'
        ],
        'V' => [
            'label' => 'Voluntary',
            'description' => 'Transaction voluntarily reported earlier than required'
        ],
        'A' => [
            'label' => 'Grant',
            'description' => 'Grant, award or other acquisition pursuant to Rule 16b-3(d)'
        ],
        'D' => [
            'label' => 'Disposition',
            'description' => 'Disposition to the issuer of issuer equity securities pursuant to Rule 16b-3(e)'
        ],
        'F' => [
            'label' => 'Payment',
            'description' => 'Payment of exercise price or tax liability by delivering or withholding securities incident to the receipt, exercise or vesting of a security issued in accordance with Rule 16b-3'
        ],
        'I' => [
            'label' => 'Discretionary',
            'description' => 'Discretionary transaction in accordance with Rule 16b-3(f) resulting in acquisition or disposition of issuer securities'
        ],
        'M' => [
            'label' => 'Exercise',
            'description' => 'Exercise or conversion of derivative security exempted pursuant to Rule 16b-3'
        ],
        'C' => [
            'label' => 'Conversion',
            'description' => 'Conversion of derivative security'
        ],
        'E' => [
            'label' => 'Expiration',
            'description' => 'Expiration of short derivative position'
        ],
        'H' => [
            'label' => 'Expiration/Cancellation',
            'description' => 'Expiration (or cancellation) of long derivative position with value received'
        ],
        'O' => [
            'label' => 'Out-of-the-money Exercise',
            'description' => 'Exercise of out-of-the-money derivative security'
        ],
        'X' => [
            'label' => 'In/at-the-money Exercise',
            'description' => 'Exercise of in-the-money or at-the-money derivative security'
        ],
        'G' => [
            'label' => 'Gift',
            'description' => 'Bona fide gift'
        ],
        'L' => [
            'label' => 'Small Acquisition',
            'description' => 'Small acquisition under Rule 16a-6'
        ],
        'W' => [
            'label' => 'Will/Descent',
            'description' => 'Acquisition or disposition by will or the laws of descent and distribution'
        ],
        'Z' => [
            'label' => 'Voting Trust',
            'description' => 'Deposit into or withdrawal from voting trust'
        ],
        'J' => [
            'label' => 'Other',
            'description' => 'Other acquisition or disposition (describe transaction)'
        ],
        'K' => [
            'label' => 'Equity Swap',
            'description' => 'Transaction in equity swap or instrument with similar characteristics'
        ],
        'U' => [
            'label' => 'Tender Disposition',
            'description' => 'Disposition pursuant to a tender of shares in a change of control transaction'
        ],
    ],
    'chartColors' => [
        "#464E49",
        "#52D3A2",
        "#3561E7",
        "#3F5765",
        "#4D2C29",
        "#6467BC",
        "#828C85",
        "#DA680B",
        "#6645A9",
        "#E53E8F",
        "#C22929",
        "#1D1351",
        
        '#393a14',
        '#030802',
        '#2f1431',
        '#0f0003',
        '#0d1a01',
        '#000000',
        '#603006',
        '#493c04',
        '#3d2b0e',
        '#051330',
        '#2c170c',
        '#192003',
        '#271809',
        '#0e392b',
        '#272a7c',
        '#16362c',
        '#712540',
        '#0e2633',
        '#1b0b40',
        '#021101',
        '#010403',
        '#1c0f03',
        '#010001',
        '#102b2d',
        '#6d2246',
        '#084d62',
        '#114f3c',
        '#300f21',
        '#0b038f',
        '#0f1402',
        '#050921',
        '#1b3109',
        '#010001',
        '#030217',
        '#3d2003',
        '#012b2a',
        '#55321d',
        '#050003',
        '#4c4622',
        '#453a19',
        '#281b48',
        '#290919',
        '#000405',
        '#282b01',
        '#3b2600',
        '#060f04',
        '#550053',
        '#1b3c56',
        '#061a1d',
        '#0e2a29',
    ],
    'table-builder' => [
        'summaries' => [
            'Max',
            'Min',
            'Sum',
            'Median',
        ]
    ]
];
