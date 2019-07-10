<?php

namespace Xeviant\Paystack\Contract;

interface ApplicationInterface
{
    public function makeApi(string $apiName): ApiInterface;

    public function makeModel(string $apiName, $parameters = []);
}
