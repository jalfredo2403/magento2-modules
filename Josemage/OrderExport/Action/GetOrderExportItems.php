<?php

namespace Josemage\OrderExport\Action;

use Magento\Sales\Api\Data\OrderInterface;

/**
 *
 */
class GetOrderExportItems
{
    /**
     * @var array
     */
    private $allowedTypes;

    public function __construct(
        array $allowedTypes = []
    )
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @param OrderInterface $order
     * @return array
     */
    public function execute(OrderInterface $order): array
    {
        $items = [];
        foreach ($order->getItems() as $orderItem) {
            if (in_array($orderItem->getProductType(), $this->allowedTypes)) {
                $items[] = $orderItem;
            }
        }

        return $items;
    }

}
