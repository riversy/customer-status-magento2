<?php

namespace Riversy\CustomerStatus\Model\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Riversy\CustomerStatus\Model\ResourceModel\CustomerStatusRepository;
use Riversy\CustomerStatus\Model\StatusFactory;

class CustomerRepository
{
    /**
     * @var CustomerStatusRepository
     */
    private $statusRepository;

    /**
     * @var CustomerExtensionFactory
     */
    private $customerExtensionFactory;

    /**
     * @var StatusFactory
     */
    private $statusFactory;

    /**
     * CustomerRepository constructor.
     * @param CustomerStatusRepository $statusRepository
     * @param CustomerExtensionFactory $customerExtensionFactory
     * @param StatusFactory $statusFactory
     */
    public function __construct(
        CustomerStatusRepository $statusRepository,
        CustomerExtensionFactory $customerExtensionFactory,
        StatusFactory $statusFactory
    )
    {
        $this->statusRepository = $statusRepository;
        $this->customerExtensionFactory = $customerExtensionFactory;
        $this->statusFactory = $statusFactory;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterGetById(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result
    )
    {
        $customerId = $result->getId();

        try {
            $statusModel = $this->statusRepository->getByCustomerId($customerId);
            $statusValue = $statusModel->getStatus();
        } catch (NoSuchEntityException $notFoundException) {
            $statusValue = '';
        }

        $extensionAttributes = $result->getExtensionAttributes();
        if (!$extensionAttributes) {
            /** @var CustomerExtensionInterface $extensionAttributes */
            $extensionAttributes = $this->customerExtensionFactory->create();
        }

        $extensionAttributes->setCustomerStatus($statusValue);
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @param CustomerInterface $customer
     * @return CustomerInterface
     * @throws LocalizedException
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer
    )
    {
        $customerId = $customer->getId();
        $extensionAttributes = $customer->getExtensionAttributes();
        $statusValue = $extensionAttributes->getCustomerStatus();

        try {
            $statusModel = $this->statusRepository->getByCustomerId($customerId);
        } catch (NoSuchEntityException $notFoundException) {
            $statusModel = $this->statusFactory->create();
            $statusModel->setCustomerId($customerId);
        }

        $statusModel->setStatus($statusValue);
        $this->statusRepository->save($statusModel);

        return $result;
    }
}