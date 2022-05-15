<?php

namespace Onestic\AcmeShipping\Api\Service\Rule;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterface;

interface MatchRulesServiceInterface
{
    public function execute(RateRequest $request): RuleSearchResultsInterface;
}
