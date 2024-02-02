<?php

namespace Josemage\OrderExport\Action;

use Josemage\OrderExport\Api\Data\OrderExportDetailsInterface;
use Josemage\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use Josemage\OrderExport\Api\OrderExportDetailsRepositoryInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Exception\CouldNotSaveException;
/**
 *
 */
class SaveExportDetailsToOrder
{
    /**
     * @var OrderExportDetailsInterfaceFactory
     */
    private  $exportDetailsFactory;
    /**
     * @var OrderExportDetailsRepositoryInterface
     */
    private $orderExportDetailsRepository;

    /**
     * @param OrderExportDetailsInterfaceFactory $orderExportDetailsInterfaceFactory
     * @param OrderExportDetailsRepositoryInterface $orderExportDetailsRepository
     */
    public function __construct(
        OrderExportDetailsInterfaceFactory $exportDetailsFactory,
        OrderExportDetailsRepositoryInterface $orderExportDetailsRepository,
    )
    {
        $this->exportDetailsFactory = $exportDetailsFactory;
        $this->orderExportDetailsRepository = $orderExportDetailsRepository;
    }


    /**
     * @throws CouldNotSaveException
     */
    public function execute(OrderInterface $order, HeaderData $headerData, array $results): void
    {
        /** @var OrderExportDetailsInterface $exportDetails */
        $exportDetails = $this->exportDetailsFactory->create();

        $exportDetails->setOrderId((int) $order->getEntityId());

        $success = $results['success'] ?? false;
        if ($success) {
            $time = (new \DateTime())->setTimezone(new \DateTimeZone('UTC'));
            $exportDetails->setExportedAt($time);
        }

        if ($merchantNotes = $headerData->getMerchantNote()) {
            $exportDetails->setMerchantNotes($merchantNotes);
        }
        if ($shipOn = $headerData->getShipDate()) {
            $exportDetails->setShipOn($shipOn);
        }

        $this->orderExportDetailsRepository->save($exportDetails);
    }


}
