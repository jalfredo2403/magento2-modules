<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Action;

use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Josemage\StoreLocator\Api\Data\StoreLocatorInterfaceFactory;
use Josemage\StoreLocator\Api\StoreLocatorRepositoryInterface;
use Josemage\StoreLocator\Model\LocatorData;
use Magento\Framework\Exception\TemporaryState\CouldNotSaveException;


/**
 *
 */
class SaveStoreLocatorToDataBase
{


    private $locatorRepository;
    private StoreLocatorInterfaceFactory $storeLocatorInterfaceFactory;

    public function __construct(
        StoreLocatorInterfaceFactory    $storeLocatorInterfaceFactory,
        StoreLocatorRepositoryInterface $locatorRepository
    )
    {
        $this->locatorRepository = $locatorRepository;
        $this->storeLocatorInterfaceFactory = $storeLocatorInterfaceFactory;
    }


    /**
     * @param LocatorData $locatorData
     * @return array
     */
    public function execute(LocatorData $locatorData): array
    {
        $results = ['success' => false, 'error' => null];

        /** @var StoreLocatorInterface $storeLocator */
        $storeLocator = $this->storeLocatorInterfaceFactory->create();

        if ($name = $locatorData->getName()) {
            $storeLocator->setName($name);
        }

        if ($hours = $locatorData->getHours()) {
            $storeLocator->setHours($hours);
        }

        if ($status = $locatorData->getStatus()) {
            $storeLocator->setStatus($status);
        }

        if ($latitude = $locatorData->getLatitude()) {
            $storeLocator->setLatitude($latitude);
        }

        if ($longitude = $locatorData->getLongitude()) {
            $storeLocator->setLongitude($longitude);
        }

        try {
            $this->locatorRepository->save($storeLocator);
            $results['success'] = true;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $results;

    }
}
