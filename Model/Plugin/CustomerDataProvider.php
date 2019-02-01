<?php

namespace Riversy\CustomerStatus\Model\Plugin;

use Magento\Customer\Model\Customer\DataProvider;
use Riversy\CustomerStatus\Api\Data\StatusInterface;
use Riversy\CustomerStatus\Model\ResourceModel\CustomerStatusRepository;


/**
 * Class CustomerDataProviderPlugin
 * @package Riversy\CustomerStatus\Model\Plugin
 */
class CustomerDataProvider
{
    /**
     * @var CustomerStatusRepository
     */
    private $statusRepository;

    /**
     * CustomerDataProvider constructor.
     * @param CustomerStatusRepository $statusRepository
     */
    public function __construct(CustomerStatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    /**
     * @param DataProvider $subject
     * @param $data
     * @return mixed
     */
    public function afterGetData(DataProvider $subject, $data)
    {
        if (empty($data)) {
            return $data;
        }

        $customerIds = [];
        foreach ($data as $fieldData) {
            if (!isset($fieldData['customer']['entity_id'])) {
                continue;
            }

            $customerIds[] = $fieldData['customer']['entity_id'];
        }

        $customerStatusModels = $this->statusRepository->getListByCustomerIds($customerIds);
        $customerIdToStatusModelMap = array_combine($customerIds, $customerStatusModels);

        foreach ($data as $dataKey => $fieldData) {
            if (
                !isset(
                    $fieldData['customer']['entity_id'],
                    $customerIdToStatusModelMap[$fieldData['customer']['entity_id']]
                )
            ) {
                continue;
            }

            $entityId = $fieldData['customer']['entity_id'];

            /** @var StatusInterface $statusModel */
            $statusModel = $customerIdToStatusModelMap[$entityId];

            $data[$dataKey]['customer']['extension_attributes']['customer_status'] = $statusModel->getStatus();
        }

        return $data;
    }
}
