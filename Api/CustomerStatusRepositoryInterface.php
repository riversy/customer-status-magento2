<?php

namespace Riversy\CustomerStatus\Api;

use Magento\Framework\Exception\LocalizedException;
use Riversy\CustomerStatus\Api\Data\StatusInterface;

/**
 * Interface CustomerStatusRepositoryInterface
 * @package Riversy\CustomerStatus\Api
 */
interface CustomerStatusRepositoryInterface
{
    /**
     * Retrieve customer status model.
     *
     * @param int $customerId
     * @return StatusInterface
     * @throws LocalizedException
     */
    public function getByCustomerId($customerId);

    /**
     * Save page.
     *
     * @param StatusInterface $statusModel
     * @return StatusInterface
     * @throws LocalizedException
     */
    public function save(StatusInterface $statusModel);
}