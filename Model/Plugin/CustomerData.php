<?php

namespace Riversy\CustomerStatus\Model\Plugin;

use Magento\Customer\Helper\Session\CurrentCustomer;

/**
 * Class CustomerData
 * @package Riversy\CustomerStatus\Model\Plugin
 */
class CustomerData
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * CustomerData constructor.
     * @param CurrentCustomer $currentCustomer
     */
    public function __construct(
        CurrentCustomer $currentCustomer
    ) {
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * @param \Magento\Customer\CustomerData\Customer $subject
     * @param $result
     * @return mixed
     */
    public function afterGetSectionData(\Magento\Customer\CustomerData\Customer $subject, $result)
    {
        $customerId = $this->currentCustomer->getCustomerId();

        if ($customerId) {
            $customer = $this->currentCustomer->getCustomer();

            $statusValue = $customer->getExtensionAttributes()->getCustomerStatus();
            $result['status'] = $statusValue;
        }

        return $result;
    }
}