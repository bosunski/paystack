<?php

return [
    'core' => [
        //
    ],
    'providers' => [
        'bvn' => \Xeviant\Paystack\Api\Bvn::class,
        'bank' => \Xeviant\Paystack\Api\Bank::class,
        'pages' => \Xeviant\Paystack\Api\Pages::class,
        'plans' => \Xeviant\Paystack\Api\Plans::class,
        'charge' => \Xeviant\Paystack\Api\Charge::class,
        'refund' => \Xeviant\Paystack\Api\Refund::class,
        'balance' => \Xeviant\Paystack\Api\Balance::class,
        'invoices' => \Xeviant\Paystack\Api\Invoices::class,
        'transfers' => \Xeviant\Paystack\Api\Transfers::class,
        'customers' => \Xeviant\Paystack\Api\Customers::class,
        'subAccount' => \Xeviant\Paystack\Api\SubAccount::class,
        'settlements' => \Xeviant\Paystack\Api\Settlements::class,
        'bulkCharges' => \Xeviant\Paystack\Api\BulkCharges::class,
        'integration' => \Xeviant\Paystack\Api\Integration::class,
        'transactions' => \Xeviant\Paystack\Api\Transactions::class,
        'subscriptions' => \Xeviant\Paystack\Api\Subscriptions::class,
        'transferRecipients' => \Xeviant\Paystack\Api\TransferRecipients::class,
    ],
    'models' => [
        'customer' => ''
    ],
];
