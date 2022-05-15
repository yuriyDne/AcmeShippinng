<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Onestic\AcmeShipping\Api\Data\RuleInterface;
use Onestic\AcmeShipping\Api\Data\RuleInterfaceFactory;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterface;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterfaceFactory;
use Onestic\AcmeShipping\Api\RuleRepositoryInterface;
use Onestic\AcmeShipping\Model\ResourceModel\Rule as ResourceRule;
use Onestic\AcmeShipping\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;

class RuleRepository implements RuleRepositoryInterface
{

    /**
     * @var Rule
     */
    protected $searchResultsFactory;

    /**
     * @var ResourceRule
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var RuleCollectionFactory
     */
    protected $ruleCollectionFactory;

    /**
     * @var RuleInterfaceFactory
     */
    protected $ruleFactory;

    /**
     * @param ResourceRule $resource
     * @param RuleInterfaceFactory $ruleFactory
     * @param RuleCollectionFactory $ruleCollectionFactory
     * @param RuleSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceRule $resource,
        RuleInterfaceFactory $ruleFactory,
        RuleCollectionFactory $ruleCollectionFactory,
        RuleSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->ruleFactory = $ruleFactory;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param RuleInterface $rule
     * @return RuleInterface
     * @throws CouldNotSaveException
     */
    public function save(RuleInterface $rule): RuleInterface
    {
        try {
            $this->resource->save($rule);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rule: %1',
                $exception->getMessage()
            ));
        }
        return $rule;
    }

    /**
     * @param int $ruleId
     * @return RuleInterface
     * @throws NoSuchEntityException
     */
    public function get(int $ruleId): RuleInterface
    {
        $rule = $this->ruleFactory->create();
        $this->resource->load($rule, $ruleId);
        if (!$rule->getId()) {
            throw new NoSuchEntityException(__('Rule with id "%1" does not exist.', $ruleId));
        }

        return $rule;
    }

    /**
     * @param SearchCriteriaInterface $criteria
     * @return RuleSearchResultsInterface
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): RuleSearchResultsInterface {
        $collection = $this->ruleCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param RuleInterface $rule
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(RuleInterface $rule): bool
    {
        try {
            $ruleModel = $this->ruleFactory->create();
            $this->resource->load($ruleModel, $rule->getRuleId());
            $this->resource->delete($ruleModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Rule: %1',
                $exception->getMessage()
            ));
        }

        return true;
    }

    /**
     * @param $ruleId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($ruleId): bool
    {
        return $this->delete($this->get($ruleId));
    }
}
