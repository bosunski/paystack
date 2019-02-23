# Paystack API Client
A simple, fluent and stable PHP client for Paystack API.

### Features
- Covers the **WHOLE** Paystack API as referenced [here][1]
- Well tested - tests covering the whole API.


### Requirements
- PHP >= 7.1

### Installation
```bash
$ composer require xeviant/paystack
```

### Basic Usage
```php
<?php

require_once "vendor/autoload.php";
use Xeviant\Paystack\Paystack;

$paystack = new Paystack('pk_12xcd', 'sk_12xcb');
/**
  * The pattern is that you call the API method and then the the part of the API you want to access
 * In this example I am accessing the list feature of the customers API check: https://developers.paystack.co/reference
 */
var_dump($paystack->customers()->list());
```

### Available API Methods
- `customers()` - Customers API
- `balance()` - Balance API
- `bank()` - Bank API
- `bulkCharges()` - Bulk Charges API
- `bvn()` - BVN API
- `charge()` - Charge API
- `integration()` - Integration API
- `invoices()` - Invoices API
- `pages()` - Pages API
- `plans()` - Plans API
- `refund()` - Refund API
- `settlements()` - Settlements API
- `subAccount()` - Sub-accounts API
- `subscriptions()` - Subscriptions API
- `transactions()` - Transactions API
- `transferRecipients()` - Transfer Recipients
- `transfers()` - Transfers API
```

[1]: https://developers.paystack.co/reference