<?php

namespace Onestic\AcmeShipping\Api\Data;

interface ConfigInterface
{
    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @return float
     */
    public function getDefaultPrice(): float;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDefaultMethodName(): string;

    /**
     * @return string
     */
    public function getCarrierCode(): string;
}
