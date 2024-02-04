<?php

namespace Josemage\StoreLocator\Api\Data;


use Magento\Framework\Api\SearchResultsInterface;

interface StoreLocatorSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Josemage\StoreLocator\Api\Data\StoreLocatorInterface[]
     */
    public function getItems();

    /**
     * @param \Josemage\StoreLocator\Api\Data\StoreLocatorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);

}
