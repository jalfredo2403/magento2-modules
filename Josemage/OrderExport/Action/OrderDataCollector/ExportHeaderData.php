<?php

namespace Josemage\OrderExport\Action\OrderDataCollector;

use Josemage\OrderExport\Api\OrderDataCollectorInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;

class ExportHeaderData implements OrderDataCollectorInterface
{

    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $shipDate = $headerData->getShipDate();
        return [
            'merchant_notes' => $headerData->getMerchantNote(),
            'shipping' => [
                'ship_on' => $shipDate !== null ? $shipDate->format('d/m/y') : '',
            ]
        ];
    }
}
