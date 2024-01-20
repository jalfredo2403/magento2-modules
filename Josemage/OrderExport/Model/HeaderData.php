<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Model;

class HeaderData
{
    /** @var ?\DateTime */
    private $shipDate;

    /** @var string */
    private $merchantNote;

    public function getShipDate(): ?\DateTime
    {
        return $this->shipDate;
    }

    public function setShipDate(?\DateTime $shipDate): HeaderData
    {
        $this->shipDate = $shipDate;
        return $this;
    }

    public function getMerchantNote(): string
    {
        return (string)$this->merchantNote;
    }

    public function setMerchantNote(string $merchantNote): HeaderData
    {
        $this->merchantNote = $merchantNote;
        return $this;
    }

}
