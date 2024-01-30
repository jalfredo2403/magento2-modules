<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface OrderExportDetailsSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return \Josemage\OrderExport\Api\Data\OrderExportDetailsInterface[]
     */
    public function getItems();

    /**
     * @param \Josemage\OrderExport\Api\Data\OrderExportDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}
