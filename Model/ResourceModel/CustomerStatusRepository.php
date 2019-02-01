<?php

namespace Riversy\CustomerStatus\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Riversy\CustomerStatus\Api\Data\StatusInterface;
use Riversy\CustomerStatus\Model\Status;
use Riversy\CustomerStatus\Model\StatusFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Riversy\CustomerStatus\Api\CustomerStatusRepositoryInterface;
use Riversy\CustomerStatus\Model\ResourceModel\Status as StatusResource;

/**
 * Class CustomerStatusRepository
 * @package Riversy\CustomerStatus\Model\ResourceModel
 */
class CustomerStatusRepository implements CustomerStatusRepositoryInterface
{
    /**
     * @var StatusFactory
     */
    private $statusFactory;

    /**
     * @var \Riversy\CustomerStatus\Model\ResourceModel\Status
     */
    private $resource;

    public function __construct
    (
        StatusResource $resource,
        StatusFactory $statusFactory
    )
    {
        $this->statusFactory = $statusFactory;
        $this->resource = $resource;
    }

    /**
     * Retrieve customer status record.
     *
     * @param int $customerId
     * @return StatusInterface|Status
     * @throws NoSuchEntityException
     */
    public function getByCustomerId($customerId)
    {
        /** @var Status $statusModel */
        $statusModel = $this->statusFactory->create();
        $this->resource->load($statusModel, $customerId);

        if (!$statusModel->getId()) {
            throw new NoSuchEntityException(
                __("Status record is not found for Customer with id %1", $customerId)
            );
        }
        return $statusModel;
    }

    /**
     * Save page.
     *
     * @param StatusInterface $statusModel
     * @return StatusInterface
     * @throws LocalizedException
     */
    public function save(StatusInterface $statusModel)
    {
        $this->resource->save($statusModel);

        return $statusModel;
    }

    /**
     * Retrieve an array of Customer Code's indexed by Customer ID
     *
     * @param int[] $customerIds
     * @return StatusInterface[] Indexed by Customer ID
     */
    public function getListByCustomerIds(array $customerIds)
    {
        return array_map([$this, 'getStatusByCustomerId'], $customerIds);
    }

    /**
     * @param $customerId
     * @return StatusInterface
     */
    private function getStatusByCustomerId($customerId)
    {
        try {
            $statusModel = $this->getByCustomerId($customerId);
        } catch (NoSuchEntityException $noSuchEntityException) {
            $statusModel = $this->statusFactory->create();
            $statusModel->setCustomerId($customerId);
        }

        return $statusModel;
    }
}