<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Model\ResourceModel\StoreLocator;

use Josemage\StoreLocator\Model\StoreLocator;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 *
 */
class Collection extends AbstractCollection
{
    /**
     *
     */
    public function _construct()
    {
        $this->_init(StoreLocator::class, \Josemage\StoreLocator\Model\ResourceModel\StoreLocator::class);
    }

}
