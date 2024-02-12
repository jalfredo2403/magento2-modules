<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Console\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderExportTest extends Command
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param string|null $name
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name = null
    ) {
        parent::__construct($name);
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    protected function configure()
    {
        $this->setName('order-export:test')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->searchCriteriaBuilder->setPageSize(5);
        $orders = $this->orderRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        foreach ($orders as $order)
        {
            $output->writeln($order->getEntityId());
            $extAttrs = $order->getExtensionAttributes();
            $exportDetails = $extAttrs->getExportDetails();
            if ($exportDetails) {
                $output->writeln(print_r($exportDetails->getData(), true));
            }
        }
        return 0;
    }
}
