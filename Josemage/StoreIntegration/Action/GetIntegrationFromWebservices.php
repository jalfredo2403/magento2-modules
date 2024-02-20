<?php
declare(strict_types=1);

namespace Josemage\StoreIntegration\Action;

use GuzzleHttp\Exception\GuzzleException;
use Josemage\StoreIntegration\Api\IntegrationProcessResponseInterface;
use Josemage\StoreIntegration\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class GetIntegrationFromWebservices
{
    private Config $config;
    private LoggerInterface $logger;
    private IntegrationProcessResponseInterface $integrationProcessResponse;

    /**
     * @param Config $config
     * @param LoggerInterface $logger
     * @param IntegrationProcessResponseInterface $integrationProcessResponse
     */
    public function __construct(
        Config          $config,
        LoggerInterface $logger,
        IntegrationProcessResponseInterface $integrationProcessResponse
    )
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->integrationProcessResponse = $integrationProcessResponse;
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws LocalizedException
     */
    public function execute(): string
    {
        $apiUrl = $this->config->getApiUrl();
        // Use GuzzleHttp (http://docs.guzzlephp.org/en/stable/)
        $client = new Client();
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ];

        try {
            $response = $client->get($apiUrl, $options);
            return $this->integrationProcessResponse->formatResponse($response);
        } catch (GuzzleException|LocalizedException $ex) {
            $this->logger->error($ex->getMessage(), [
                'details' => 'Error called' . $apiUrl
            ]);
            throw  $ex;
        }
    }

}
