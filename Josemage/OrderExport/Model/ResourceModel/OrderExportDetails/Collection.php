<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Model\ResourceModel\OrderExportDetails;

use Josemage\OrderExport\Model\OrderExportDetails;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 *
 */
class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(OrderExportDetails::class, \Josemage\OrderExport\Model\ResourceModel\OrderExportDetails::class);
    }
}
