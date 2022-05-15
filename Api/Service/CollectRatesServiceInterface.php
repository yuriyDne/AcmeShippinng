<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api\Service;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;

/**
 * Collect shipping method rates
 */
interface CollectRatesServiceInterface
{
    /**
     * @param RateRequest $request
     * @return Result
     */
    public function execute(RateRequest $request): Result;
}
