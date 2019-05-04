<?php

return [
    'core' => [
        //
    ],
    'providers' => [
        'balance' => \Xeviant\Paystack\Api\Balance::class,
        'bank' => \Xeviant\Paystack\Api\Bank::class,
        'customers' => \Xeviant\Paystack\Api\Customers::class,
    ],
    'models' => [
        'customer' => ''
    ],
];
