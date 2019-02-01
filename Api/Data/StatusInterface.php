<?php

namespace Riversy\CustomerStatus\Api\Data;

interface StatusInterface
{
    public const CUSTOMER_ID = 'customer_id';
    public const STATUS = 'status';

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set customer id
     *
     * @param int $customerId
     */
    public function setCustomerId($customerId);

    /**
     * @return string|null
     */
    public function getStatus();

    /**
     * @param string $status
     */
    public function setStatus($status);
}