<?php
return [
    'statuses' => [
        'pending' => 0,
        'processing' => 1,
        'completed' => 2,
        'failed' => -1,
    ],
    'languages' => [
        'English' => 1,
        'Urdu' => 2,
        'Hindi'=>3,
        'Spanish'=>4,
        'French'=>5,
       
    ],
    'call_usertypes' => [
        'Customer' => [
            'value' => 1,
            'description' => 'A person who makes or receives calls to the call center',
        ],
        'Agent' => [
            'value' => 2,
            'description' => 'A person who makes or receives calls from the call center',
        ],
    ],
];
?>