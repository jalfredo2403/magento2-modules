<?php

namespace Josemage\OrderExport\Api;

use  Josemage\OrderExport\Api\Data\OrderExportDetailsInterface;
use Josemage\OrderExport\Api\Data\OrderExportDetailsSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 *
 */
interface OrderExportDetailsRepositoryInterface
{
    /**
     * @param \Josemage\OrderExport\Api\Data\OrderExportDetailsInterface|\Magento\Framework\Model\AbstractModel $exportDetails
     * @return OrderExportDetailsInterface
     * @throws CouldNotSaveException
     */
    public function save(OrderExportDetailsInterface $exportDetails): OrderExportDetailsInterface;

    /**
     * @param int $detailsId
     * @return \Josemage\OrderExport\Api\Data\OrderExportDetailsInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $detailsId): OrderExportDetailsInterface;

    /**
     * @param \Josemage\OrderExport\Api\Data\OrderExportDetailsInterface|\Magento\Framework\Model\AbstractModel$exportDetails
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(OrderExportDetailsInterface $exportDetails): bool;

    /**
     * @param int $detailsId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $detailsId): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderExportDetailsSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria):OrderExportDetailsSearchResultsInterface;
}
