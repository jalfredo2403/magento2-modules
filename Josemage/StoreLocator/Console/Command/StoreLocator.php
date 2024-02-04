<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Console\Command;

use Josemage\StoreLocator\Action\SaveStoreLocatorToDataBase;
use Josemage\StoreLocator\Model\LocatorData;
use Josemage\StoreLocator\Model\LocatorDataFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StoreLocator extends Command
{

    const OPT_NAME_NAME = 'name';
    const OPT_NAME_HOURS = 'hours';
    const OPT_NAME_STATUS = 'status';
    const OPT_NAME_LATITUDE = 'latitude';
    const OPT_NAME_LONGITUDE = 'longitude';

    /**
     * @var LocatorDataFactory
     */
    private LocatorDataFactory $locatorDataFactory;
    /**
     * @var SaveStoreLocatorToDataBase
     */
    private SaveStoreLocatorToDataBase $saveStoreLocator;

    public function __construct(
        LocatorDataFactory         $locatorDataFactory,
        SaveStoreLocatorToDataBase $saveStoreLocator,
        string                     $name = null
    )
    {
        parent::__construct($name);
        $this->locatorDataFactory = $locatorDataFactory;
        $this->saveStoreLocator = $saveStoreLocator;
    }

    /**
     * @inheirtdoc
     */
    protected function configure()
    {
        $this->setName('store:locator:add');
        $this->setDescription('Create new store locator')
            ->addOption(
                self::OPT_NAME_NAME,
                null,
                InputOption::VALUE_OPTIONAL,
                'Store name'
            )->addOption(
                self::OPT_NAME_HOURS,
                null,
                InputOption::VALUE_OPTIONAL,
                'Store hours'
            )->addOption(
                self::OPT_NAME_STATUS,
                null,
                InputOption::VALUE_OPTIONAL,
                'Store Status'
            )->addOption(
                self::OPT_NAME_LATITUDE,
                'lat',
                InputOption::VALUE_OPTIONAL,
                'Store latitude'
            )->addOption(
                self::OPT_NAME_LONGITUDE,
                'log',
                InputOption::VALUE_OPTIONAL,
                'Store longitude'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $name = $input->getOption(self::OPT_NAME_NAME);
        $hours = $input->getOption(self::OPT_NAME_HOURS);
        $status = (int)$input->getOption(self::OPT_NAME_STATUS) ?? 0;
        $latitude = $input->getOption(self::OPT_NAME_LATITUDE);
        $longitude = $input->getOption(self::OPT_NAME_LONGITUDE);


        /** @var  $locatorData */
        $locatorData = $this->locatorDataFactory->create();

        if ($name) {
            $locatorData->setName($name);
        }

        if ($hours) {
            $locatorData->setHours($hours);
        }

        if ($status) {
            $locatorData->setStatus($status);
        }

        if ($latitude) {
            $locatorData->setLatitude($latitude);
        }

        if ($longitude) {
            $locatorData->setLongitude($longitude);
        }

        $result = $this->saveStoreLocator->execute($locatorData);
        $success = $result['success'] ?? false;
        if ($success) {
            $output->writeln(__('Successfully new Store Locator created'));
        } else {
            $msg = $result['error'] ?? null;
            if ($msg === null) {
                $msg = __('Unexpected errors occurred');
            }
            $output->writeln($msg);
            return 1;
        }

        return 0;
    }
}
