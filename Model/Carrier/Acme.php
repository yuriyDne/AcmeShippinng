<?php

namespace Onestic\AcmeShipping\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Onestic\AcmeShipping\Api\Data\ConfigInterface;
use Onestic\AcmeShipping\Api\Service\CollectRatesServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Acme shipping model
 */
class Acme extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var bool
     */
    protected $_isFixed = false;

    /**
     * @var CollectRatesServiceInterface
     */
    private CollectRatesServiceInterface $collectRatesService;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param CollectRatesServiceInterface $collectRatesService
     * @param ConfigInterface $config
     * @param string $code
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory         $rateErrorFactory,
        LoggerInterface      $logger,
        CollectRatesServiceInterface $collectRatesService,
        ConfigInterface $config,
        string $code,
        array $data = []
    ) {
        $this->_code = $code;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
        $this->collectRatesService = $collectRatesService;
        $this->config = $config;
    }


    /**
     * Custom Shipping Rates Collector
     *
     * @param RateRequest $request
     * @return Result|bool
     */
    public function collectRates(RateRequest $request)
    {
        if ($this->config->isActive() === false) {
            return false;
        }

        return $this->collectRatesService->execute($request);
    }

    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->config->getDefaultMethodName()];
    }
}
