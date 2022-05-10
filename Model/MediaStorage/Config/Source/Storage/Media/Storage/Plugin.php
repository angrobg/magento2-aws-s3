<?php

namespace ST\AwsS3\Model\MediaStorage\Config\Source\Storage\Media\Storage;

class Plugin
{
    public function afterToOptionArray($subject, $result)
    {
        $result[] = [
            'value' => \ST\AwsS3\Model\MediaStorage\File\Storage::STORAGE_MEDIA_S3,
            'label' => __('Amazon S3')
        ];
        return $result;
    }
}
