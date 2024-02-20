<?php
declare(strict_types=1);

namespace Josemage\StoreIntegration\Model\Layout\Checkout;

use GuzzleHttp\Exception\GuzzleException;
use Josemage\StoreIntegration\Action\GetIntegrationFromWebservices;
use Josemage\StoreIntegration\Model\Config;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Framework\Exception\LocalizedException;

class IntegrationProcessor implements LayoutProcessorInterface
{
    private Config $config;
    private GetIntegrationFromWebservices $integrationFromWebservices;

    /**
     * @param Config $config
     * @param GetIntegrationFromWebservices $integrationFromWebservices
     */
    public function __construct(
        Config                        $config,
        GetIntegrationFromWebservices $integrationFromWebservices
    )
    {

        $this->config = $config;
        $this->integrationFromWebservices = $integrationFromWebservices;
    }

    /**
     * {@inheritdoc}
     */
    public function process($jsLayout)
    {
        if (!$this->config->isEnabled()) {
            return $jsLayout;
        }
        try {
            $response = $this->integrationFromWebservices->execute();
        } catch (GuzzleException|LocalizedException $ex) {
            return $jsLayout;
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['webServiceNotice']['config']['integrationContent'] = $response;

        return $jsLayout;
    }
}
