<?php

namespace Onestic\AcmeShipping\Api\Service;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;

interface CollectRatesServiceInterface
{
    public function execute(RateRequest $request): Result;
}
