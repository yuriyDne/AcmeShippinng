<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Onestic\AcmeShipping\Api\Data\RuleInterface;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterface;

/**
 * CRUD operations for Acme Shipping Rule data model
 */
interface RuleRepositoryInterface
{
    /**
     * @param RuleInterface $rule
     * @return RuleInterface
     */
    public function save(RuleInterface $rule): RuleInterface;

    /**
     * @param int $ruleId
     * @return RuleInterface
     * @throws NoSuchEntityException
     */
    public function get(int $ruleId): RuleInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return RuleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): RuleSearchResultsInterface;

    /**
     * @param RuleInterface $rule
     * @return bool
     */
    public function delete(RuleInterface $rule): bool;

    /**
     * @param int $ruleId
     * @return bool
     */
    public function deleteById(int $ruleId): bool;
}
