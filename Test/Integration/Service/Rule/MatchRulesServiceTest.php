<?php

namespace Onestic\AcmeShipping\Test\Integration\Service\Rule;

use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;
use Onestic\AcmeShipping\Service\Rule\MatchRulesService;
use Onestic\AcmeShipping\Test\Integration\Factory\RateRequestFactory;
use PHPUnit\Framework\TestCase;

class MatchRulesServiceTest extends TestCase
{
    /**
     * @var MatchRulesService
     */
    private $matchRulesService;

    /**
     * @var RateRequestFactory
     */
    private $rateRequestFactory;

    /**
     * @var WebsiteRepositoryInterface
     */
    private $websiteRepository;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        /** @var $objectManager ObjectManager */
        $objectManager = Bootstrap::getObjectManager();
        $this->rateRequestFactory = $objectManager->get(RateRequestFactory::class);
        $this->matchRulesService = $objectManager->get(MatchRulesService::class);
        $this->websiteRepository = $objectManager->get(WebsiteRepositoryInterface::class);
    }


    /**
     * @dataProvider postcodeToCountDataProvider
     * @magentoDataFixture ../../../../app/code/Onestic/AcmeShipping/Test/Integration/_files/acme_rules.php
     */
    public function testRulesCount($postCode, $websiteCode, $matchingCount)
    {
        $rateRequest = $this->rateRequestFactory->create($websiteCode, $postCode);

        $searchResult = $this->matchRulesService->execute($rateRequest);
        $this->assertEquals($matchingCount, $searchResult->getTotalCount());
    }

    /**
     * @magentoDataFixture ../../../../app/code/Onestic/AcmeShipping/Test/Integration/_files/acme_rules.php
     * @magentoAppArea frontend
     */
    public function testMatchingData()
    {
        $rateRequest = $this->rateRequestFactory->create();
        $rateRequest->setDestPostcode('70020');
        $websiteId = $this->websiteRepository->get('website_2')->getId();
        $rateRequest->setWebsiteId($websiteId);
        $searchResult = $this->matchRulesService->execute($rateRequest);
        $items = $searchResult->getItems();
        $ruleModel = reset($items);

        $this->assertEquals($ruleModel->getCarrierCode(), '3c_code_b_b');
        $this->assertEquals($ruleModel->getDestinationCountry(), 'ES');
        $this->assertEquals($ruleModel->getDestinationPostcode(), '70020');
        $this->assertEquals($ruleModel->getWebsiteCode(), 'website_2');
        $this->assertEquals($ruleModel->getPrice(), 14);
        $this->assertEquals($ruleModel->getMethodName(), '');
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function postcodeToCountDataProvider()
    {
        return [
                ['70010', 'base', 2],
                ['70020', 'website_2', 1],
                ['70030', 'website_2', 0],
        ];
    }
}
