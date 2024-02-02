<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Action;

use Josemage\OrderExport\Api\OrderDataCollectorInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;

/**
 *
 */
class CollectOrderData
{

    /** @var OrderDataCollectorInterface[] */
    private array $collectors;


    /**
     * @param array $collectors
     */
    public function __construct(
        array $collectors = []
    )
    {
        $this->collectors = $collectors;
    }


    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function execute(OrderInterface $order, HeaderData $headerData): array
    {
        $output = [];

        foreach ($this->collectors as $collector) {
            $output = array_merge_recursive($output, $collector->collect($order, $headerData));
        }

        return $output;
    }
}
