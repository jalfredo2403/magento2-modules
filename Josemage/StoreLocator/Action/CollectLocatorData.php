<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Action;

use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Josemage\StoreLocator\Api\StoreLocatorRepositoryInterface;

/**
 *
 */
class CollectLocatorData
{
    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $locatorRepository;

    /**
     * @param StoreLocatorRepositoryInterface $locatorRepository
     */
    public function __construct(
        StoreLocatorRepositoryInterface $locatorRepository
    )
    {
        $this->locatorRepository = $locatorRepository;
    }

    /**
     * @param int $id
     * @return StoreLocatorInterface
     */
    public function execute(int $id): StoreLocatorInterface
    {
        return $this->locatorRepository->getById($id);

    }

}
