<?php

namespace Riversy\CustomerStatus\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class OptionsProvider
{
    private const XML_PATH_STATUS_VALUES = 'customer_status/general/status_values';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * OptionsProvider constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Options from Configuration
     *
     * @return array
     */
    public function getOptionsArray()
    {
        $values = $this->scopeConfig->getValue(self::XML_PATH_STATUS_VALUES);
        $options = $this->convertTextValueToArray($values);

        $options = array_map(function($option) {
            return [
                'value' => $option,
                'label' => $option,
            ];
        }, $options);

        $emptyValue = [
            'value' => '',
            'label' => __("Choose a Status"),
        ];

        return array_merge([$emptyValue], $options);
    }

    /**
     * Convert text value from configuration to list of options.
     *
     * @param $value
     * @return array
     */
    private function convertTextValueToArray($value)
    {
        $trimmedValue = trim($value);
        $lines = explode("\n", $trimmedValue);
        $cleanLines = array_map('trim', $lines);
        $filteredLines = array_filter($cleanLines);

        return $filteredLines;
    }
}