<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Action;

use Josemage\OrderExport\Api\OrderDataCollectorInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 *
 */
class CollectOrderData
{

    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /** @var OrderDataCollectorInterface[] */
    private array $collectors;

    /**
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        array                    $collectors = []
    )
    {
        $this->orderRepository = $orderRepository;
        $this->collectors = $collectors;
    }

    /**
     * @param int $orderID
     * @param HeaderData $headerData
     * @return array
     */
    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);
        $output = [];

        foreach ($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }

        return $output;
    }
}
