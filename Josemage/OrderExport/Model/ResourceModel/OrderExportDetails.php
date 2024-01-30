<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 *
 */
class OrderExportDetails extends AbstractDb
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sales_order_export', 'id');
    }
}
