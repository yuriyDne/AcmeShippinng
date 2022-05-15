<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api\Service\Rule;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterface;

/**
 * Shipping rules search by RateRequest
 */
interface MatchRulesServiceInterface
{
    public function execute(RateRequest $request): RuleSearchResultsInterface;
}
