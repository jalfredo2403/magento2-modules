<?php

namespace Josemage\StoreLocator\Block\Stores;


use Josemage\StoreLocator\Action\CollectLocatorData;
use Josemage\StoreLocator\Api\Data\StoreLocatorInterface;
use Josemage\StoreLocator\Model\Config;
use Magento\Framework\View\Element\Template;

/**
 *
 */
class ListStoresDetails extends Template
{

    /**
     * @var Template\Context
     */
    private Template\Context $context;
    /**
     * @var Config
     */
    private Config $config;
    /**
     * @var CollectLocatorData
     */
    private CollectLocatorData $locatorData;


    /**
     * @param CollectLocatorData $locatorData
     * @param Template\Context $context
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        CollectLocatorData $locatorData,
        Template\Context   $context,
        Config             $config,
        array              $data = []
    )
    {
        parent::__construct($context, $data);

        $this->context = $context;
        $this->config = $config;
        $this->locatorData = $locatorData;
    }

    /**
     * @return string
     */
    public function getStoreName(): string
    {
        return __('Test test and test');

    }

    /**
     * @return array|mixed|null
     */
    public function getMapApiKey()
    {
        if ($this->config->isEnabled()) {
            if (!$this->getData('api_key')) {
                $this->setData('api_key', $this->config->getApiKey() ?? null);
            }
        }
        return $this->getData('api_key');
    }

    /**
     * @return string
     */
    public function getApiError()
    {
        return 'The google Api Key is empty.';
    }

    /**
     * @param int $id
     * @return StoreLocatorInterface|null
     */
    public function loadLocatorById(int $id): ?StoreLocatorInterface
    {
        if ($this->config->isEnabled()) {
            try {
                return $this->locatorData->execute($id);
            } catch (\Throwable $e) {
                $this->setData('error', $e->getMessage());
            }
        }
        return null;
    }

    public function getError():string
    {
        if(!$this->getData('error')){
            $this->setData('error', 'We are having trouble showing your locator, please try more later');
        }
        return $this->getData('error');
    }
 
}
