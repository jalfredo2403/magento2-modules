<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Action;

use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Josemage\StoreLocator\Api\StoreLocatorRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 *
 */
class CollectLocatorData
{
    const ENABLED_STATUS = 1;
    /**
     * @var StoreLocatorRepositoryInterface
     */
    private StoreLocatorRepositoryInterface $locatorRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param StoreLocatorRepositoryInterface $locatorRepository
     */
    public function __construct(
        StoreLocatorRepositoryInterface $locatorRepository,
        SearchCriteriaBuilder           $searchCriteriaBuilder,
    )
    {
        $this->locatorRepository = $locatorRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param int $id
     * @return StoreLocatorInterface
     */
    public function execute(int $id): StoreLocatorInterface
    {
        return $this->locatorRepository->getById($id);

    }

    /**
     * @return StoreLocatorInterface[]
     */
    public function collect(): array
    {
        $this->searchCriteriaBuilder->addFilter('status', self::ENABLED_STATUS);
        /** @var  StoreLocatorInterface[] $prducts */
        return $this->locatorRepository->getList($this->searchCriteriaBuilder->create())->getItems();
    }

}
