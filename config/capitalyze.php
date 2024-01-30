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
        "#9A46CD",
        "#52D3A2",
        "#3561E7",
        "#E38E48",
        "#39a80f",
        "#cb6c2d",
        "#8a2aa7",
        "#c47f2b",
        "#1634a3",
        "#F8BC20",
        "#9FB0EE",
        "#070cc6",
        "#d16882",
        "#C22929",
    ]
];
