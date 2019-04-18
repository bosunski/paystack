<?php

namespace Xeviant\Paystack\Contract;


interface EventType
{
    const INVOICE_UPDATED = 'invoice.update';
    const INVOICE_CREATED = 'invoice.create';
}
