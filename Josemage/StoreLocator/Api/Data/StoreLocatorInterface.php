<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Api\Data;


interface StoreLocatorInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return StoreLocatorInterface
     */
    public function setName(string $name): StoreLocatorInterface;

    /**
     * @return string
     */
    public function getHours(): string;

    /**
     * @param string $hours
     * @return StoreLocatorInterface
     */
    public function setHours(string $hours): StoreLocatorInterface;

    /**
     * @return string
     */
    public function getLatitude(): string;

    /**
     * @return string
     */
    public function getLongitude():string;

    /**
     * @param string $latitude
     * @return StoreLocatorInterface
     */
    public function setLatitude(string $latitude):StoreLocatorInterface;

    /**
     * @param string $longitude
     * @return StoreLocatorInterface
     */
    public function setLongitude(string $longitude):StoreLocatorInterface;

}
