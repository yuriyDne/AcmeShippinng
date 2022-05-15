<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api\Service\Rule;

use Onestic\AcmeShipping\Api\Service\Vendor;

/**
 * Save array of Acme Shipping rules data model to storage
 */
interface SaveRulesServiceInterface
{
    /**
     * @param  Vendor\Module\Api\Data\RuleInterface[] $rules
     * @return void
     *
     * @todo Need to be implemented in next version
     */
    public function execute(array $rules): void;
}
