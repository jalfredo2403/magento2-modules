<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StoreLocator extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('store_locator_data', 'id');
    }
}
