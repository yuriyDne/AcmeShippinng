<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Api\Data;

/**
 * Module configuration
 */
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
