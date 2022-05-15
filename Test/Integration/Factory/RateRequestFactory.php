<?php

namespace Onestic\AcmeShipping\Test\Integration\Factory;

use Magento\Store\Api\WebsiteRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;

class RateRequestFactory
{
    private WebsiteRepositoryInterface $websiteRepository;

    /**
     * @param WebsiteRepositoryInterface $websiteRepository
     */
    public function __construct(WebsiteRepositoryInterface $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address\RateRequest|mixed
     */
    public function create(string $websiteCode = 'base', string $postcode = '70010', string $country = 'ES')
    {
        $websiteId = $this->websiteRepository->get($websiteCode)->getId();

        /** @var $objectManager ObjectManager */
        $objectManager = Bootstrap::getObjectManager();
        $rateRequest = $objectManager->create(\Magento\Quote\Model\Quote\Address\RateRequest::class);
        $rateRequest->setWebsiteId($websiteId)
            ->setDestCountryId($country)
            ->setDestPostcode($postcode);

        return $rateRequest;
    }
}
