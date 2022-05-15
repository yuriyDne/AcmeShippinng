<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Test\Integration\Service;

use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;
use Onestic\AcmeShipping\Service\CollectRatesService;
use Onestic\AcmeShipping\Test\Integration\Factory\RateRequestFactory;
use PHPUnit\Framework\TestCase;

class CollectRatesServiceTest extends TestCase
{
    /**
     * @var mixed|RateRequestFactory
     */
    private $rateRequestFactory;
    /**
     * @var mixed|CollectRatesService
     */
    private $collectRatesService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        /** @var $objectManager ObjectManager */
        $objectManager = Bootstrap::getObjectManager();
        $this->rateRequestFactory = $objectManager->get(RateRequestFactory::class);
        $this->collectRatesService = $objectManager->get(CollectRatesService::class);
    }

    /**
     * @dataProvider postcodeToCountDataProvider
     * @magentoDataFixture ../../../../app/code/Onestic/AcmeShipping/Test/Integration/_files/acme_rules.php
     */
    public function testMethodsCount($postCode, $websiteCode, $methodsCount)
    {
        $rateRequest = $this->rateRequestFactory->create($websiteCode, $postCode);

        $searchResult = $this->collectRatesService->execute($rateRequest);
        $rates = $searchResult->getAllRates();
        $this->assertEquals($methodsCount, count($rates));
    }

    /**
     * @magentoDataFixture ../../../../app/code/Onestic/AcmeShipping/Test/Integration/_files/acme_rules.php
     */
    public function testDefaultMethod()
    {
        $rateRequest = $this->rateRequestFactory->create('base', 'Non Used Postcode');
        $searchResult = $this->collectRatesService->execute($rateRequest);
        $rates = $searchResult->getAllRates();
        /** @var Method $defaultRate */
        $defaultRate = reset($rates);

        $this->assertEquals('acmeshipping', $defaultRate->getMethod());
        $this->assertEquals('acmeshipping', $defaultRate->getCarrier());

        return true;
    }

    /**
     * @magentoDataFixture ../../../../app/code/Onestic/AcmeShipping/Test/Integration/_files/acme_rules.php
     */
    public function testCustomMethod()
    {
        $rateRequest = $this->rateRequestFactory->create('website_2', '70020');

        $searchResult = $this->collectRatesService->execute($rateRequest);
        $rates = $searchResult->getAllRates();
        /** @var Method $defaultRate */
        $customRate = reset($rates);

        $this->assertEquals('3c_code_b_b', $customRate->getMethod());
        $this->assertEquals('acmeshipping', $customRate->getCarrier());
        $this->assertEquals('14', $customRate->getPrice());

        return true;
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
            ['70030', 'website_2', 1],
        ];
    }
}
