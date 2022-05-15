<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Service\Rule;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Store\Model\StoreManagerInterface;
use Onestic\AcmeShipping\Api\Data\RuleInterface;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterface;
use Onestic\AcmeShipping\Api\RuleRepositoryInterface;
use Onestic\AcmeShipping\Api\Service\Rule\MatchRulesServiceInterface;

class MatchRulesService implements MatchRulesServiceInterface
{
    /**
     * @var RuleRepositoryInterface
     */
    private RuleRepositoryInterface $ruleRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @param RuleRepositoryInterface $ruleRepository
     * @param StoreManagerInterface $storeManager
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        RuleRepositoryInterface $ruleRepository,
        StoreManagerInterface $storeManager,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->ruleRepository = $ruleRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
    }

    /**
     * @param RateRequest $request
     * @return RuleSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(RateRequest $request): RuleSearchResultsInterface
    {
        $websiteCode = $this->storeManager->getWebsite($request->getWebsiteId())->getCode();
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            RuleInterface::WEBSITE_CODE,
            $websiteCode
        )->addFilter(
            RuleInterface::DESTINATION_COUNTRY,
            $request->getDestCountryId()
        )->addFilter(
            RuleInterface::DESTINATION_POSTCODE,
            $request->getDestPostcode()
        )->create();

        return $this->ruleRepository->getList($searchCriteria);
    }
}
