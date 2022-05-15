<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api\Data;

interface RuleInterface
{

    const DESTINATION_COUNTRY = 'destination_country';
    const WEBSITE_CODE = 'website_code';
    const DESTINATION_POSTCODE = 'destination_postcode';
    const PRICE = 'price';
    const ENTITY_ID = 'entity_id';
    const CARRIER_CODE = 'carrier_code';
    const METHOD_NAME = 'method_name';


    /**
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * Get entity_id
     * @return string
     */
    public function setEntityId(int $entityId);

    /**
     * Get carrier_code
     * @return string
     */
    public function getCarrierCode(): string;

    /**
     * Set carrier_code
     * @param string $carrierCode
     * @return RuleInterface
     */
    public function setCarrierCode(string $carrierCode): RuleInterface;

    /**
     * Get desctination_country
     * @return string
     */
    public function getDestinationCountry(): string;

    /**
     * Set desctination_country
     * @param string $destinationCountry
     * @return RuleInterface
     */
    public function setDestinationCountry(string $destinationCountry): RuleInterface;

    /**
     * Get desctination_postcode
     * @return string
     */
    public function getDestinationPostcode(): string;

    /**
     * Set desctination_postcode
     * @param string $destinationPostcode
     * @return RuleInterface
     */
    public function setDestinationPostcode(string $destinationPostcode): RuleInterface;

    /**
     * Get website_code
     * @return string
     */
    public function getWebsiteCode(): string;

    /**
     * Set website_code
     * @param string $websiteCode
     * @return RuleInterface
     */
    public function setWebsiteCode(string $websiteCode): RuleInterface;

    /**
     * @return string|null
     */
    public function getMethodName(): ?string;

    /**
     * Set website_code
     * @param string $methodName
     * @return RuleInterface
     */
    public function setMethodName(string $methodName): RuleInterface;
    /**
     * Get price
     * @return float
     */
    public function getPrice(): float;

    /**
     * Set price
     * @param string $price
     * @return RuleInterface
     */
    public function setPrice(string $price): RuleInterface;
}
