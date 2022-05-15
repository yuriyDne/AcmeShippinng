<?php

namespace Onestic\AcmeShipping\Model\ResourceModel\Rule;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Onestic\AcmeShipping\Model\Rule;

class Collection extends AbstractCollection
{
    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';


    protected function _construct()
    {
        $this->_init(
            Rule::class,
            \Onestic\AcmeShipping\Model\ResourceModel\Rule::class
        );
    }
}
