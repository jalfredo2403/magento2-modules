<?php
declare(strict_types=1);


namespace Josemage\OrderExport\Api\Data;

interface OrderExportDetailsInterface
{
    public function getId();

    public function getOrderId(): ?int;

    public function setOrderId(int $orderId): OrderExportDetailsInterface;

    public function getShipOn(): ?\DateTime;

    public function setShipOn(\DateTime $shipOn): OrderExportDetailsInterface;

    public function getMerchantNotes(): string;

    public function setMerchantNotes(string $notes): OrderExportDetailsInterface;

    public function getExportedAt(): ?\DateTime;

    public function setExportedAt(\DateTime $exportedAt): OrderExportDetailsInterface;

    public function hasBeenExported(): bool;

}
