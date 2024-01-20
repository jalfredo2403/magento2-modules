<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Api;

use Josemage\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * OrderDataCollectorInterface
 */
interface OrderDataCollectorInterface
{

    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, HeaderData $headerData):array;
}
