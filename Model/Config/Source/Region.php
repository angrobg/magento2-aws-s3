<?php

namespace ST\AwsS3\Model\Config\Source;

class Region implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \ST\AwsS3\Helper\S3
     */
    private $helper;

    public function __construct(\ST\AwsS3\Helper\S3 $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Return list of available Amazon S3 regions
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->helper->getRegions();
    }
}
