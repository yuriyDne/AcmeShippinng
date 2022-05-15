<?php

namespace Onestic\AcmeShipping\Model\ResourceModel;

class Rule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
{
    $this->_init('acme_shipping_rules', 'entity_id');
}
}
