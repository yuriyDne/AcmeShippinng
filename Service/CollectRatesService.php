<?php
declare(strict_types=1);

namespace Onestic\AcmeShipping\Service;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Onestic\AcmeShipping\Api\Data\ConfigInterface;
use Onestic\AcmeShipping\Api\Data\RuleSearchResultsInterface;
use Onestic\AcmeShipping\Api\Service\CollectRatesServiceInterface;
use Onestic\AcmeShipping\Api\Service\Rule\MatchRulesServiceInterface;

class CollectRatesService implements CollectRatesServiceInterface
{
    /**
     * @var MatchRulesServiceInterface
     */
    private MatchRulesServiceInterface $matchRulesService;

    /**
     * @var ResultFactory
     */
    private ResultFactory $rateResultFactory;

    /**
     * @var MethodFactory
     */
    private MethodFactory $rateMethodFactory;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @param MatchRulesServiceInterface $matchRulesService
     * @param ConfigInterface $config
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     */
    public function __construct(
        MatchRulesServiceInterface $matchRulesService,
        ConfigInterface $config,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory
    ) {
        $this->matchRulesService = $matchRulesService;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->config = $config;
    }

    /**
     * @param RateRequest $request
     * @return Result
     */
    public function execute(RateRequest $request): Result
    {
        $customRulesResult = $this->matchRulesService->execute($request);
        if ($customRulesResult->getTotalCount()) {
            return $this->getCustomMethods($customRulesResult);
        } else {
            return $this->getDefaultMethod();
        }
    }

    /**
     * @param RuleSearchResultsInterface $customRules
     * @return Result
     */
    private function getCustomMethods(RuleSearchResultsInterface $customRules): Result
    {
        $result = $this->rateResultFactory->create();

        foreach ($customRules->getItems() as $rule) {
            $method = $this->rateMethodFactory->create();
            $method->setCarrier($this->config->getCarrierCode());
            $method->setCarrierTitle($this->config->getTitle());

            $method->setMethod($rule->getCarrierCode());
            $methodTitle = $rule->getMethodName() ?: $this->config->getDefaultMethodName();
            $method->setMethodTitle($methodTitle);

            $shippingCost = $rule->getPrice();
            $method->setPrice($shippingCost);
            $method->setCost($shippingCost);

            $result->append($method);
        }

        return $result;
    }

    /**
     * @return Result
     */
    private function getDefaultMethod(): Result
    {
        $result = $this->rateResultFactory->create();
        $method = $this->rateMethodFactory->create();

        $method->setCarrier($this->config->getCarrierCode());
        $method->setCarrierTitle($this->config->getTitle());

        $method->setMethod($this->config->getCarrierCode());
        $method->setMethodTitle($this->config->getDefaultMethodName());

        $shippingCost = $this->config->getDefaultPrice();
        $method->setPrice($shippingCost);
        $method->setCost($shippingCost);

        $result->append($method);

        return $result;
    }
}
