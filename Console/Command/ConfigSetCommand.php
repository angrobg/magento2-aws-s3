<?php

namespace ST\AwsS3\Console\Command;

use Magento\Config\Model\Config\Factory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigSetCommand extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var Factory
     */
    private $configFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * @var \ST\AwsS3\Helper\S3
     */
    private $helper;

    public function __construct(
        \Magento\Framework\App\State $state,
        Factory $configFactory,
        \ST\AwsS3\Helper\S3 $helper
    ) {
        $this->state = $state;
        $this->helper = $helper;
        $this->configFactory = $configFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('s3:config:set')
            ->setDescription('Allows you to set your S3 configuration via the CLI.')
            ->setDefinition($this->getOptionsList());
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->state->emulateAreaCode(
            'adminhtml',
            [$this, 'process'],
            [$input, $output]
        );
    }

    protected function process(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('region') && !$input->getOption('bucket') && !$input->getOption('secret-key') && !$input->getOption('access-key-id')) {
            $output->writeln($this->getSynopsis());
            return;
        }

        $errors = $this->validate($input);
        if ($errors) {
            $output->writeln('<error>' . implode('</error>' . PHP_EOL .  '<error>', $errors) . '</error>');
            return;
        }

        $config = $this->configFactory->create();

        if (!empty($input->getOption('access-key-id'))) {
            $config->setDataByPath('st_aws_s3/general/access_key', $input->getOption('access-key-id'));
            $config->save();
        }

        if (!empty($input->getOption('secret-key'))) {
            $config->setDataByPath('st_aws_s3/general/secret_key', $input->getOption('secret-key'));
            $config->save();
        }

        if (!empty($input->getOption('bucket'))) {
            $config->setDataByPath('st_aws_s3/general/bucket', $input->getOption('bucket'));
            $config->save();
        }

        if (!empty($input->getOption('region'))) {
            $config->setDataByPath('st_aws_s3/general/region', $input->getOption('region'));
            $config->save();
        }

        $output->writeln('<info>You have successfully updated your S3 credentials.</info>');
    }

    public function getOptionsList()
    {
        return [
            new InputOption('access-key-id', null, InputOption::VALUE_OPTIONAL, 'a valid AWS access key ID'),
            new InputOption('secret-key', null, InputOption::VALUE_OPTIONAL, 'a valid AWS secret access key'),
            new InputOption('bucket', null, InputOption::VALUE_OPTIONAL, 'an S3 bucket name'),
            new InputOption('region', null, InputOption::VALUE_OPTIONAL, 'an S3 region, e.g. us-east-1')
        ];
    }

    public function validate(InputInterface $input)
    {
        $errors = [];
        if ($input->getOption('region')) {
            if (!$this->helper->isValidRegion($input->getOption('region'))) {
                $errors[] = sprintf('The region "%s" is invalid.', $input->getOption('region'));
            }
        }
        return $errors;
    }
}
