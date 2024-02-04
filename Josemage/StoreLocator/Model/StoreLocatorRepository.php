<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Model;

use Josemage\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;
use Josemage\OrderExport\Model\ResourceModel\OrderExportDetails\Collection as OrderExportDetailsCollection;
use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Josemage\StoreLocator\Api\Data\StoreLocatorSearchResultInterface;
use Josemage\StoreLocator\Api\Data\StoreLocatorSearchResultInterfaceFactory;
use Josemage\StoreLocator\Api\StoreLocatorRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Josemage\StoreLocator\Model\StoreLocator;
use Josemage\StoreLocator\Model\StoreLocatorFactory;
use Josemage\StoreLocator\Model\ResourceModel\StoreLocator\Collection as StoreLocatorCollection;
use Josemage\StoreLocator\Model\ResourceModel\StoreLocator\CollectionFactory as StoreLocatorCollectionFactory;
use Josemage\StoreLocator\Model\ResourceModel\StoreLocator as StoreLocatorResource;
use Magento\Framework\Model\AbstractModel;


class StoreLocatorRepository implements StoreLocatorRepositoryInterface
{

    private \Josemage\StoreLocator\Model\StoreLocatorFactory $storeLocatorFactory;

    private StoreLocatorCollectionFactory $storeLocatorcollectionFactory;
    private ResourceModel\StoreLocator $storeLocatorResource;
    private CollectionProcessorInterface $collectionProcessor;
    private StoreLocatorSearchResultInterfaceFactory $storeLocatorSearchResultFactory;

    public function __construct(
        StoreLocatorFactory           $storeLocatorFactory,
        StoreLocatorResource          $storeLocatorResource,
        StoreLocatorCollectionFactory $storeLocatorcollectionFactory,
        CollectionProcessorInterface  $collectionProcessor,
        StoreLocatorSearchResultInterfaceFactory $storeLocatorSearchResultFactory,
    )
    {
        $this->storeLocatorFactory = $storeLocatorFactory;
        $this->storeLocatorcollectionFactory = $storeLocatorcollectionFactory;
        $this->storeLocatorResource = $storeLocatorResource;
        $this->collectionProcessor = $collectionProcessor;
        $this->storeLocatorSearchResultFactory = $storeLocatorSearchResultFactory;
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

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria):StoreLocatorSearchResultInterface
    {
        /** @var StoreLocatorCollection $collection */
        $collection = $this->storeLocatorcollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var StoreLocatorSearchResultInterface $searchResults */
        $searchResults = $this->storeLocatorSearchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;

    }
}
