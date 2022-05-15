<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Onestic\AcmeShipping\Model;

use Magento\Framework\Model\AbstractModel;
use Onestic\AcmeShipping\Api\Data\RuleInterface;

class Rule extends AbstractModel implements RuleInterface
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Rule::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId(): ?int
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function getCarrierCode(): string
    {
        return $this->getData(self::CARRIER_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCarrierCode(string $carrierCode): RuleInterface
    {
        return $this->setData(self::CARRIER_CODE, $carrierCode);
    }

    /**
     * @inheritDoc
     */
    public function getDestinationCountry(): string
    {
        return $this->getData(self::DESTINATION_COUNTRY);
    }

    public function setDestinationCountry(string $destinationCountry): RuleInterface
    {
        return $this->setData(self::DESTINATION_COUNTRY, $destinationCountry);
    }

    /**
     * @inheritDoc
     */
    public function getDestinationPostcode(): string
    {
        return $this->getData(self::DESTINATION_POSTCODE);
    }

    /**
     * @inheritDoc
     */
    public function setDestinationPostcode(string $destinationPostcode): RuleInterface
    {
        return $this->setData(self::DESTINATION_POSTCODE, $destinationPostcode);
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteCode(): string
    {
        return $this->getData(self::WEBSITE_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteCode($websiteCode): RuleInterface
    {
        return $this->setData(self::WEBSITE_CODE, $websiteCode);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): float
    {
        return (float)$this->getData(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice(string $price): RuleInterface
    {
        return $this->setData(self::PRICE, $price);
    }

    public function getMethodName(): ?string
    {
        return $this->getData(self::METHOD_NAME);
    }

    public function setMethodName(string $methodName): RuleInterface
    {
        return $this->setData(self::WEBSITE_CODE, $methodName);
    }
}

