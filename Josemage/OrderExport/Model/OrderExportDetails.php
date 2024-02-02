<?php

namespace Josemage\OrderExport\Model;

use Josemage\OrderExport\Api\Data\OrderExportDetailsInterface;
use Magento\Framework\Model\AbstractModel;

class OrderExportDetails extends AbstractModel implements OrderExportDetailsInterface
{


    protected function _construct()
    {
        $this->_init(\Josemage\OrderExport\Model\ResourceModel\OrderExportDetails::class);
    }

    /**
     * @return int|null
     */
    public function getOrderId(): ?int
    {
        return ($this->hasData('order_id')) ? (int) $this->getData('order_id') : null;
    }

    /**
     * @param int $orderId
     * @return OrderExportDetailsInterface
     */
    public function setOrderId(int $orderId): OrderExportDetailsInterface
    {
        $this->setData('order_id', $orderId);
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getShipOn(): ?\DateTime
    {
        $dateStr = $this->getData('ship_on');
        return ($dateStr) ? new \DateTime($dateStr) : null;
    }

    /**
     * @param \DateTime $shipOn
     * @return OrderExportDetailsInterface
     */
    public function setShipOn(\DateTime $shipOn): OrderExportDetailsInterface
    {
        $this->setData('ship_on', $shipOn->format('Y-m-d'));
        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantNotes(): string
    {
        return (string) $this->getData('merchant_notes');
    }

    /**
     * @param string $notes
     * @return OrderExportDetailsInterface
     */
    public function setMerchantNotes(string $notes): OrderExportDetailsInterface
    {
        $this->setData('merchant_notes', $notes);
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExportedAt(): ?\DateTime
    {
        $dateStr = $this->getData('exported_at');
        return ($dateStr) ? new \DateTime($dateStr) : null;
    }

    /**
     * @param \DateTime $exportedAt
     * @return OrderExportDetailsInterface
     */
    public function setExportedAt(\DateTime $exportedAt): OrderExportDetailsInterface
    {
        $this->setData('exported_at', $exportedAt->format('Y-m-d H:i:s'));
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBeenExported(): bool
    {
        return (bool) $this->getData('exported_at');
    }
}
