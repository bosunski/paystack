<?php

namespace Xeviant\Paystack\Contract;


interface EventType
{
    const INVOICE_UPDATED = 'invoice.update';
    const INVOICE_CREATED = 'invoice.create';
    const CHARGE_SUCCESS = 'charge.success';
    const TRANSFER_SUCCESS = 'transfer.success';
    const TRANSFER_FAILED = 'transfer.failed';
    const INVOICE_FAILED = 'invoice.failed';
    const SUBSCRIPTION_ENABLED = 'subscription.enable';
    const SUBSCRIPTION_DISABLED = 'subscription.disable';
    const SUBSCRIPTION_CREATE = 'subscription.disable';
}
