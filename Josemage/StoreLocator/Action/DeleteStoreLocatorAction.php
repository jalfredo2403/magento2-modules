<?php
declare(strict_types=1);

namespace Josemage\StoreLocator\Action;


use Josemage\StoreLocator\Api\StoreLocatorRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;


/**
 *
 */
class DeleteStoreLocatorAction
{

    /**
     * @var StoreLocatorRepositoryInterface
     */
    private $locatorRepository;
    /**
     * @var StoreLocatorInterfaceFactory
     */
    private StoreLocatorInterfaceFactory $storeLocatorInterfaceFactory;

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
     * @param int $storeLocatorId
     * @return array
     * @throws CouldNotDeleteException
     */
    public function execute(int $storeLocatorId): array
    {
        $results = ['success' => false, 'error' => null];

        try {
            $this->locatorRepository->deleteById($storeLocatorId);
            $results['success'] = true;
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return $results;
    }
}
