<?php

namespace Josemage\StoreLocator\Model;

use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Magento\Framework\Model\AbstractModel;

class StoreLocator extends AbstractModel implements StoreLocatorInterface
{

    /**
     *
     */
    public function _construct()
    {
        $this->_init(\Josemage\StoreLocator\Model\ResourceModel\StoreLocator::class);

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->getData('name');
    }

    /**
     * @param string $name
     * @return StoreLocatorInterface
     */
    public function setName(string $name): StoreLocatorInterface
    {
        $this->setData('name', $name);
        return $this;
    }

    /**
     * @return string
     */
    public function getHours(): string
    {
        return (string)$this->getData('hours');
    }

    /**
     * @param string $hours
     * @return StoreLocatorInterface
     */
    public function setHours(string $hours): StoreLocatorInterface
    {
        $this->setData('hours', $hours);
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude(): string
    {
        return (string)$this->getData('latitude');
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return (string)$this->getData('longitude');
    }

    /**
     * @param string $latitude
     * @return StoreLocatorInterface
     */
    public function setLatitude(string $latitude): StoreLocatorInterface
    {
        $this->setData('latitude', $latitude);
        return $this;
    }

    /**
     * @param string $longitude
     * @return StoreLocatorInterface
     */
    public function setLongitude(string $longitude): StoreLocatorInterface
    {
        $this->setData('longitude', $longitude);
        return $this;
    }
}
