<?php

namespace ST\AwsS3\Model\MediaStorage\File\Uploader;

class Plugin
{
    private $helper;
    private $storageModel = null;
    private $storageHelperstorageModel = null;

    public function __construct(
        \ST\AwsS3\Helper\Data $helper,
        \ST\AwsS3\Model\MediaStorage\File\Storage\S3Factory $s3StorageFactory,
        \Magento\MediaStorage\Helper\File\Storage\Database $storageHelper
    ) {
        $this->helper = $helper;
        $this->storageModel = $s3StorageFactory->create();
        $this->storageHelper = $storageHelper;
    }

    public function afterSave($subject, $result)
    {
        if ($this->helper->checkS3Usage()) {
            if (substr($result['path'], strlen($result['path']) - 1, 1) != '/'
                && substr($result['file'], 0, 1) != '/') {
                $result["file"] = "/" . $result["file"];
            }
            $s3result = $this->storageModel->saveFile($this->storageHelper->getMediaRelativePath($result["path"].$result["file"]));
            if (!$s3result) {
                $e = new Exception('Division by zero.', 0);
                throw $e;
                return;
            }
        }
        return $result;
    }
}
