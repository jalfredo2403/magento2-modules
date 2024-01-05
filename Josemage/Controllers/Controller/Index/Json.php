<?php

namespace Josemage\Controllers\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;


/**
 * Json Class
 */
class Json implements HttpGetActionInterface
{

    /**
     * @var JsonFactory
     */
    protected $jsonFactory;


    /**
     * @param JsonFactory $jsonFactory
     */
    public function __construct(JsonFactory $jsonFactory)
    {
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->jsonFactory->create()
            ->setHeader('Content-type', 'application/json')
            ->setData([
                'Name' => 'Jose A Hernandez',
                'Job' => 'Adobe Commerce Developer'
            ]);
    }
}
