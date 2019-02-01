<?php

namespace Riversy\CustomerStatus\Model\Data;

use \Riversy\CustomerStatus\Api\Data\StatusInterface;

class Status implements StatusInterface
{
    private $customerId;
    private $status;

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customer id
     *
     * @param int $customerId
     */
    public function setCustomerId($customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}