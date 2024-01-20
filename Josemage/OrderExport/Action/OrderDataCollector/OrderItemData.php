<?php

namespace Josemage\OrderExport\Action\OrderDataCollector;

use Josemage\OrderExport\Action\GetOrderExportItems;
use Josemage\OrderExport\Api\OrderDataCollectorInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 *
 */
class OrderItemData implements OrderDataCollectorInterface
{
    /**
     * @var GetOrderExportItems
     */
    private GetOrderExportItems $exportItems;

    /**
     * @param GetOrderExportItems $exportItems
     */
    public function __construct(
        GetOrderExportItems $exportItems
    )
    {

        $this->exportItems = $exportItems;
    }

    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $mapItems = array();
        foreach ($this->exportItems->execute($order) as $orderItem){
                $mapItems[] = $this->mapOrderItem($orderItem);
        }
        return [
          'items' => $mapItems,
        ];

    }

    private function mapOrderItem(OrderItemInterface $orderItem){
        return [
            'sku' => $orderItem->getSku(),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getBaseRowTotal()
        ];
    }

}
