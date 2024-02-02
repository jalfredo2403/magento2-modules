<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Model;

use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Josemage\StoreLocator\Api\StoreLocatorRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Josemage\StoreLocator\Model\StoreLocator;
use Josemage\StoreLocator\Model\StoreLocatorFactory;
use Josemage\StoreLocator\Model\ResourceModel\StoreLocator\Collection as StoreLocatorCollection;
use Josemage\StoreLocator\Model\ResourceModel\StoreLocator\CollectionFactory as StoreLocatorCollectionFactory;
use Magento\Framework\Model\AbstractModel;


class StoreLocatorRepository implements StoreLocatorRepositoryInterface
{

    private \Josemage\StoreLocator\Model\StoreLocatorFactory $storeLocatorFactory;

    private StoreLocatorCollectionFactory $storeLocatorcollectionFactory;
    private ResourceModel\StoreLocator $storeLocatorResource;

    public function __construct(
        StoreLocatorFactory                                     $storeLocatorFactory,
        \Josemage\StoreLocator\Model\ResourceModel\StoreLocator $storeLocatorResource,
        StoreLocatorCollectionFactory                           $storeLocatorcollectionFactory

    )
    {

        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->storeLocatorcollectionFactory = $storeLocatorcollectionFactory;
        $this->storeLocatorResource = $storeLocatorResource;
    }

    /**
     *  {@inheritDoc}
     */
    public function save(StoreLocatorInterface $storeLocator): StoreLocatorInterface
    {
        if (!($storeLocator instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of StoreLocationInterface changed'));
        }

        try {
            $this->storeLocatorResource->save($storeLocator);
            return $storeLocator;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $locatorId): StoreLocatorInterface
    {
        $locator = $this->storeLocatorFactory->create();
        $this->storeLocatorResource->load($locator, $locatorId);

        if (!$locator->getId()) {
            throw new NoSuchEntityException(__('The Store Locator not be found'));
        }

        return $locator;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(StoreLocatorInterface $storeLocator): bool
    {
        if (!($storeLocator instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('The implementation of StoreLocationInterface changed'));
        }
        try {
            $this->storeLocatorResource->delete($storeLocator);
            return true;
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $locatorId): bool
    {
        return $this->delete($this->getById($locatorId));
    }
}
