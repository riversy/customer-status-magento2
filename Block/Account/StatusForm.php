<?php

namespace Riversy\CustomerStatus\Block\Account;
;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;
use Riversy\CustomerStatus\Model\OptionsProvider;
use Magento\Customer\Api\CustomerRepositoryInterface;

class StatusForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var OptionsProvider
     */
    private $optionsProvider;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * Status constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param OptionsProvider $optionsProvider
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        OptionsProvider $optionsProvider,
        CustomerRepositoryInterface $customerRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->context = $context;
        $this->customerSession = $customerSession;
        $this->optionsProvider = $optionsProvider;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__("Status"));
        return parent::_prepareLayout();
    }


    /**
     * Submit URL
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl('*/*/save');
    }

    public function getStatusOptionsSelectHtml()
    {
        $name = 'status';
        $id = 'status';
        $title = __('Status');

        $options = $this->optionsProvider->getOptionsArray();
        $value = $this->getStatusValue();

        $layout = $this->getLayout();

        $html = $layout
            ->createBlock(\Magento\Framework\View\Element\Html\Select::class)
            ->setName($name)
            ->setId($id)
            ->setTitle($title)
            ->setValue($value)
            ->setOptions($options)
            ->setExtraParams('data-validate="{\'validate-select\':true}"')
            ->getHtml()
        ;

        return $html;
    }

    private function getStatusValue()
    {
        $customerId = $this->getCustomerId();
        if (!$customerId) {
            return '';
        }

        $customer = $this->customerRepository->getById($customerId);
        if (!$customer) {
            return '';
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        $customerStatus = $extensionAttributes->getCustomerStatus();

        return $customerStatus ?: '';
    }

    private function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }
}