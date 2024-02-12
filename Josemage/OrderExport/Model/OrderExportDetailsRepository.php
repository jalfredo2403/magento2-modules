<?php

namespace Josemage\OrderExport\Model;

use Josemage\OrderExport\Api\Data\OrderExportDetailsInterface;
use Josemage\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;
use Josemage\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterfaceFactory;
use Josemage\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use Josemage\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResource;
use Josemage\OrderExport\Model\OrderExportDetails;
use Josemage\OrderExport\Model\OrderExportDetailsFactory;
use Josemage\OrderExport\Model\ResourceModel\OrderExportDetails\Collection as OrderExportDetailsCollection;
use Josemage\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory as OrderExportDetailsCollectionfactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;

/**
 *
 */
class OrderExportDetailsRepository implements OrderExportDetailsRepositoryInterface
{
    /**
     * @var OrderExportDetailsResource
     */
    private $orderExportDetailsResoruce;

    /**
     * @var \Josemage\OrderExport\Model\OrderExportDetailsFactory
     */
    private $orderExportDetailsFactory;

    /**
     * @var OrderExportDetailsCollectionfactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    private OrderExportDetailsSearchResultsInterfaceFactory $exportDetailsSearchResultsInterfaceFactory;

    /**
     * @param OrderExportDetailsResource $orderExportDetailsResoruce
     * @param \Josemage\OrderExport\Model\OrderExportDetailsFactory $orderExportDetailsFactory
     * @param OrderExportDetailsCollectionfactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        OrderExportDetailsResource   $orderExportDetailsResoruce,
        OrderExportDetailsFactory    $orderExportDetailsFactory,
        OrderExportDetailsCollectionfactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        OrderExportDetailsSearchResultsInterfaceFactory $exportDetailsSearchResultsInterfaceFactory,
    )
    {
        $this->orderExportDetailsResoruce = $orderExportDetailsResoruce;
        $this->orderExportDetailsFactory = $orderExportDetailsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->exportDetailsSearchResultsInterfaceFactory = $exportDetailsSearchResultsInterfaceFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function save(OrderExportDetailsInterface $exportDetails): OrderExportDetailsInterface
    {
        if (!($exportDetails instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('The implementation of OrderExportDetailsInterface has changed'));
        }

        try {
            $this->orderExportDetailsResoruce->save($exportDetails);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $exportDetails;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(int $detailsId): OrderExportDetailsInterface
    {
        $details = $this->orderExportDetailsFactory->create();
        $this->orderExportDetailsResoruce->load($details, $detailsId);

        if(!$details->getId()){
            throw  new NoSuchEntityException(__('The order export details  not be found' ));
        }

        return $details;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(OrderExportDetailsInterface $exportDetails): bool
    {
        if (!($exportDetails instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('The implementation of OrderExportDetailsInterface has changed'));
        }

        try {
              $this->orderExportDetailsResoruce->delete($exportDetails);
        }catch (\Exception $e){
            throw new CouldNotDeleteException(__($e->getMessage()));

        }

    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $detailsId): bool
    {
       $this->delete($this->getById($detailsId));
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria):OrderExportDetailsSearchResultsInterface
    {
        /** @var OrderExportDetailsCollection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var OrderExportDetailsSearchResultsInterface $searchResults */
        $searchResults = $this->exportDetailsSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;


    }
}
