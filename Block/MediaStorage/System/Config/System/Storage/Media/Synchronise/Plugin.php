<?php

namespace ST\AwsS3\Block\MediaStorage\System\Config\System\Storage\Media\Synchronise;

class Plugin
{
    public function aroundGetTemplate(): string
    {
        return 'ST_AwsS3::system/config/system/storage/media/synchronise.phtml';
    }
}
