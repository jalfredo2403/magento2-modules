<?php

namespace Josemage\StoreLocator\Api;

use \Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface StoreLocatorRepositoryInterface
{
    /**
     * @param \Josemage\StoreLocator\Api\Data\StoreLocatorInterface|\Magento\Framework\Model\AbstractModel $storeLocator
     * @return StoreLocatorInterface
     * @throws CouldNotSaveException
     */
    public function save(StoreLocatorInterface $storeLocator): StoreLocatorInterface;

    /**
     * @param int $locatorId
     * @return \Josemage\StoreLocator\Api\Data\StoreLocatorInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $locatorId): StoreLocatorInterface;

    /**
     * @param \Josemage\StoreLocator\Api\Data\StoreLocatorInterface|\Magento\Framework\Model\AbstractModel $storeLocator
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(StoreLocatorInterface $storeLocator): bool;

    /**
     * @param int $locatorId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $locatorId): bool;

}
