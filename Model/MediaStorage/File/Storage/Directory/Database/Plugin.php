<?php

namespace ST\AwsS3\Model\MediaStorage\File\Storage\Directory\Database;

class Plugin
{
    private $helper;

    private $storageModel;

    public function __construct(
        \ST\AwsS3\Helper\Data $helper,
        \ST\AwsS3\Model\MediaStorage\File\Storage\S3 $storageModel
    ) {
        $this->helper = $helper;
        $this->storageModel = $storageModel;
    }

    public function aroundCreateRecursive($subject, $proceed, $path)
    {
        if ($this->helper->checkS3Usage()) {
            return $this;
        }
        return $proceed($path);
    }

    public function aroundGetSubdirectories($subject, $proceed, $directory)
    {
        if ($this->helper->checkS3Usage()) {
            return $this->storageModel->getSubdirectories($directory);
        } else {
            return $proceed($directory);
        }
    }

    public function aroundDeleteDirectory($subject, $proceed, $path)
    {
        if ($this->helper->checkS3Usage()) {
            return $this->storageModel->deleteDirectory($path);
        } else {
            return $proceed($path);
        }
    }
}
