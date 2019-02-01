<?php

namespace Riversy\CustomerStatus\Model\ResourceModel;

class Status extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_isPkAutoIncrement = false;
        $this->_init('customer_status', 'customer_id');
    }
}