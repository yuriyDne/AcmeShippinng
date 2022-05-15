<?php
use Magento\TestFramework\Helper\Bootstrap;
use Onestic\AcmeShipping\Model\Rule;
use Magento\Framework\DB\Adapter\AdapterInterface;

$ruleFactory = Bootstrap::getObjectManager()
    ->create(\Onestic\AcmeShipping\Model\RuleFactory::class);

$ruleModel = $ruleFactory->create();
/** @var AdapterInterface $dbConnection */
$dbConnection = $ruleModel->getResource()->getConnection();
$webSiteCodes = [
    [
        'code' => 'base',
        'name' => 'Base',
    ],
    [
        'code' => 'website_2',
        'name' => 'Website 2',
    ],
];
$tableName = $dbConnection->getTableName('store_website');
$dbConnection->insertOnDuplicate($tableName, $webSiteCodes);

$dataToInsert = [
    [
        Rule::CARRIER_CODE => '2c_code_a_a',
        Rule::DESTINATION_COUNTRY => 'ES',
        Rule::DESTINATION_POSTCODE => '70010',
        Rule::WEBSITE_CODE => 'base',
        Rule::PRICE => '12',
        Rule::METHOD_NAME => 'Method 1',
    ],
    [
        Rule::CARRIER_CODE => '3c_code_b_a',
        Rule::DESTINATION_COUNTRY => 'ES',
        Rule::DESTINATION_POSTCODE => '70010',
        Rule::WEBSITE_CODE => 'base',
        Rule::PRICE => '16',
        Rule::METHOD_NAME => 'Method 2',
    ],
    [
        Rule::CARRIER_CODE => '3c_code_b_b',
        Rule::DESTINATION_COUNTRY => 'ES',
        Rule::DESTINATION_POSTCODE => '70020',
        Rule::WEBSITE_CODE => 'website_2',
        Rule::PRICE => '14',
        Rule::METHOD_NAME => '',
    ],
];

foreach ($dataToInsert as $data) {
    /** @var Rule $ruleModel */
    $ruleModel = $ruleFactory->create();
    $ruleModel->setData($data);
    $ruleModel->save();
}

