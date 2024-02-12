<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Plugin;

use Josemage\OrderExport\Api\Data\OrderExportDetailsInterface;
use Josemage\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use Josemage\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class LoadExportDetailsIntoOrder
{
    /**
     * @var OrderExportDetailsRepositoryInterface
     */
    private OrderExportDetailsRepositoryInterface $exportDetailsRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var OrderExportDetailsInterfaceFactory
     */
    private OrderExportDetailsInterfaceFactory $exportDetailsInterfaceFactory;

    /**
     * @param OrderExportDetailsRepositoryInterface $exportDetailsRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param OrderExportDetailsInterfaceFactory $exportDetailsInterfaceFactory
     */
    public function __construct(
        OrderExportDetailsRepositoryInterface $exportDetailsRepository,
        SearchCriteriaBuilder                 $searchCriteriaBuilder,
        OrderExportDetailsInterfaceFactory    $exportDetailsInterfaceFactory
    )
    {
        $this->exportDetailsRepository = $exportDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->exportDetailsInterfaceFactory = $exportDetailsInterfaceFactory;
    }


    /**
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @param int $id
     * @return OrderInterface
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface           $order,
        int                      $id
    )
    {
        $this->setExportDetails($order);
        return $order;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     */
    public function afterGetList(
        OrderRepositoryInterface   $subject,
        OrderSearchResultInterface $result,
        SearchCriteriaInterface    $searchCriteria
    )
    {
        foreach ($result->getItems() as $order) {
            $this->setExportDetails($order);
        }
        return $result;
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    protected function setExportDetails(OrderInterface $order): void
    {
        $exportDetails = $this->getOrderExportExtensionAttributes($order);
        if ($exportDetails) {
            return;
        }

        $this->searchCriteriaBuilder->addFilter('order_id', $order->getEntityId());
        $exportDetailsList = $this->exportDetailsRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        if (count($exportDetailsList) > 0) {
            $order->getExtensionAttributes()->setExportDetails(reset($exportDetailsList));
        } else {
            /** @var OrderExportDetailsInterface $exportDetails */
            $exportDetails = $this->exportDetailsInterfaceFactory->create();
            $order->getExtensionAttributes()->setExportDetails($exportDetails);
        }

    }


    /**
     * @param OrderInterface $order
     * @return OrderExportDetailsInterface|null
     */
    protected function getOrderExportExtensionAttributes(OrderInterface $order): ?OrderExportDetailsInterface
    {
        $extensionAttributes = $order->getExtensionAttributes();

        $exportDetails = $extensionAttributes->getExportDetails();
        if ($exportDetails) {
            return $exportDetails;
        }
        return null;
    }

}
