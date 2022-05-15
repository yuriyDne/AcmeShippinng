<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api\Data;

interface RuleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Rule list.
     * @return \Onestic\AcmeShipping\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.
     * @param \Onestic\AcmeShipping\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

