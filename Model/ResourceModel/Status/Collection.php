<?php

namespace Riversy\CustomerStatus\Model\ResourceModel\Status;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'customer_id';


    protected function _construct()
    {
        $this->_init('Riversy\CustomerStatus\Model\Status', 'Riversy\CustomerStatus\Model\ResourceModel\Status');
    }

}