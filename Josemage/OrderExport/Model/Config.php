<?php

namespace Josemage\OrderExport\Model;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 *
 */
class Config
{

    const CONFIG_ENABLED_PATH = 'sales/order_export/enabled';
    const CONFIG_API_TOKEN_PATH = 'sales/order_export/api_token';
    const CONFIG_API_URL_PATH = 'sales/order_export/api_url';
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {

        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_ENABLED_PATH,$scopeType,(int) $scopeCode);
    }

    /**
     * @return string
     */
    public function getApiToken(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
       $value = $this->scopeConfig->getValue(self::CONFIG_API_TOKEN_PATH,$scopeType,$scopeCode);
       return  ($value !== null) ? (string) $value : '';
    }

    public function getApiUrl(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_API_URL_PATH,$scopeType,$scopeCode);
        return  ($value !== null) ? (string) $value : '';
    }
}

