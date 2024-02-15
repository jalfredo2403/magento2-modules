<?php

namespace Josemage\StoreIntegration\Model;

use Josemage\StoreIntegration\Api\IntegrationProcessResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Http\Message\ResponseInterface;

class CheckoutNoticeFormatResponse implements IntegrationProcessResponseInterface
{

    /**
     * @param ResponseInterface $response
     * @return string
     */
    public function formatResponse(ResponseInterface $response): string
    {
        $responseBody = (string)$response->getBody();
        try {
            $responseData = \json_decode($responseBody, true);
        } catch (\Exception $e) {
            $responseData = [];
        }

        $success = $responseData['message'] ?? false;
        if ($success) {
            return $success;
        }

        $errorMsg = __($responseData['error']) ?? __('There was a problem: %1', $responseBody);

        if ($response->getStatusCode() !== 200 || !$success) {
            throw new LocalizedException($errorMsg);
        }
    }
}
