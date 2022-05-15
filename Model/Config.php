<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Onestic\AcmeShipping\Api\Data\ConfigInterface;

class Config implements ConfigInterface
{
    const PATH = 'carriers/';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var string
     */
    private string $carrierCode;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param string $carrierCode
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        string $carrierCode
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->carrierCode = $carrierCode;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->scopeConfig->isSetFlag(
            $this->getConfigPath('active'),
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return float
     */
    public function getDefaultPrice(): float
    {
        return (float) $this->scopeConfig->getValue(
            $this->getConfigPath('shipping_cost'),
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->scopeConfig->getValue(
            $this->getConfigPath('title'),
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getDefaultMethodName(): string
    {
        return $this->scopeConfig->getValue(
            $this->getConfigPath('name'),
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getCarrierCode(): string
    {
        return $this->carrierCode;
    }

    /**
     * @param string $suffix
     * @return string
     */
    private function getConfigPath(string $suffix): string
    {
        return self::PATH . $this->carrierCode . '/' . $suffix;
    }
}
