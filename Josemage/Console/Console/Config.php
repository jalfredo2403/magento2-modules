<?php

namespace Josemage\Console\Console;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class Config extends Command
{
   const VALUE = 'value';
   const PATH = "path";

    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $resourceConfig;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $cacheTypeList;


    /**
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     */
    public function __construct(
        \Magento\Config\Model\ResourceModel\Config     $resourceConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    )
    {
        parent::__construct();
        $this->resourceConfig = $resourceConfig;
        $this->cacheTypeList = $cacheTypeList;
    }


    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('example:set:console');
        $this->setDescription('Set data to core Config table.');
        $this->setDefinition([
            new InputOption(
                static::VALUE,
                null,
                InputOption::VALUE_REQUIRED,
                __("Value in Core Config Table")
            ),
            new InputOption(
                static::PATH,
                'PATH',
                InputOption::VALUE_OPTIONAL,
                __("Path in Core Config Table")
            )
        ]);
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exitCode = 0;
        try {
            $id =  $input->getOption(static::VALUE);
            $path =  $input->getOption(static::PATH) ??  "Path";
            $this->resourceConfig->saveConfig(
                $path,
                $id,
                \Magento\Framework\App\ScopeInterface::SCOPE_DEFAULT,
                0
            );
            $this->cacheTypeList->cleanType(\Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER);
            $output->writeln('<info>Data saved success.</info>');

        } catch (LocalizedException $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            $exitCode = 1;
        }
        return $exitCode;
    }
}
