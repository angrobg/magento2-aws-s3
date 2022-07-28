<?php

namespace ST\AwsS3\Console\Command;

use Magento\Config\Model\Config\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigListCommand extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var Factory
     */
    private $configFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    public function __construct(
        \Magento\Framework\App\State $state,
        Factory $configFactory
    ) {
        $this->state = $state;
        $this->configFactory = $configFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('aws-s3:config:list')
            ->setDescription('Lists whatever credentials for S3 you have provided for Magento.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode('adminhtml');
        $config = $this->configFactory->create();
        $output->writeln('Here are your AWS credentials.');
        $output->writeln('');
        $output->writeln(sprintf('Access Key ID:     %s', $config->getConfigDataValue('st_aws_s3/general/access_key')));
        $output->writeln(sprintf('Secret Access Key: %s', $config->getConfigDataValue('st_aws_s3/general/secret_key')));
        $output->writeln(sprintf('Bucket:            %s', $config->getConfigDataValue('st_aws_s3/general/bucket')));
        $output->writeln(sprintf('Region:            %s', $config->getConfigDataValue('st_aws_s3/general/region')));
    }
}
