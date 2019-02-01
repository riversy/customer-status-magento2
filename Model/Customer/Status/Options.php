<?php

namespace Riversy\CustomerStatus\Model\Customer\Status;

use Magento\Framework\Data\OptionSourceInterface;
use Riversy\CustomerStatus\Model\OptionsProvider;

class Options implements OptionSourceInterface
{
    /**
     * @var OptionsProvider
     */
    private $optionsProvider;

    /**
     * Options constructor.
     * @param OptionsProvider $optionsProvider
     */
    public function __construct(OptionsProvider $optionsProvider)
    {

        $this->optionsProvider = $optionsProvider;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return $this->optionsProvider->getOptionsArray();
    }
}