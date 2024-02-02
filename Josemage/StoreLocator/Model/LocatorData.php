<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Model;

class LocatorData
{

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $hours;

    /**
     * @var
     */
    private $longitude;

    /**
     * @var
     */
    private $latutude;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): LocatorData
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHours(): ?string
    {
        return $this->hours;
    }


    /**
     * @param $hours
     * @return $this
     */
    public function setHours($hours): LocatorData
    {
        $this->hours = $hours;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLatitude(): ?string
    {
        return $this->latutude;
    }

    /**
     * @param string|null $latitudes
     * @return $this
     */
    public function setLatitude(?string $latitudes): LocatorData
    {
        $this->latutude = $latitudes;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string|null $longitude
     * @return $this
     */
    public function setLongitude(?string $longitude): LocatorData
    {
        $this->longitude = $longitude;
        return $this;
    }

}
