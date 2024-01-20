<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Console\Command;


use Josemage\OrderExport\Action\CollectOrderData;
use Josemage\OrderExport\Model\HeaderData;
use Josemage\OrderExport\Model\HeaderDataFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class OrderExport extends Command
{

    const ARG_NAME_ORDER_ID = 'order-id';
    const OPT_NAME_SHIP_DATE = 'ship-date';
    const OPT_NAME_MERCHANT_NOTE = 'notes';


    /**
     * @var HeaderDataFactory
     */
    private HeaderDataFactory $headerDataFactory;

    /**
     * @var CollectOrderData
     */
    private CollectOrderData $collectOrderData;

    /**
     * @param HeaderDataFactory $headerDataFactory
     * @param string|null $name
     */
    public function __construct(
        HeaderDataFactory $headerDataFactory,
        CollectOrderData $collectOrderData,
        string            $name = null
    )
    {
        parent::__construct($name);
        $this->headerDataFactory = $headerDataFactory;
        $this->collectOrderData = $collectOrderData;
    }

    /**
     * @inheirtdoc
     */
    protected function configure()
    {
        $this->setName('order-export:run');
        $this->setDescription('Export order to ERP')
            ->addArgument(
                self::ARG_NAME_ORDER_ID,
                InputArgument::REQUIRED,
                "Order Id"
            )
            ->addOption(
                self::OPT_NAME_SHIP_DATE,
                'd',
                InputOption::VALUE_OPTIONAL,
                'Shpping date in format YYYY-MM-DD'
            )
            ->addOption(
                self::OPT_NAME_MERCHANT_NOTE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Merchant notes'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $orderId = (int)$input->getArgument(self::ARG_NAME_ORDER_ID);
        $notes = $input->getOption(self::OPT_NAME_MERCHANT_NOTE);
        $shipDate = $input->getOption(self::OPT_NAME_SHIP_DATE);

        /** @var  HeaderData $headerData */
        $headerData = $this->headerDataFactory->create();
        if($shipDate){
            $headerData->setShipDate(new \DateTime($shipDate));
        }
        if($notes){
            $headerData->setMerchantNote($notes);
        }

        $orderData = $this->collectOrderData->execute($orderId,$headerData);

        $output->writeln(print_r($orderData, true));
        return 0;
    }

}
