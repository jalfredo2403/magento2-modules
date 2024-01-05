<?php

namespace Josemage\Controllers\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RawFactory;


/**
 * Raw Class
 */
class Raw implements HttpGetActionInterface
{

    /**
     * @var RawFactory
     */
    protected $rawFactory;

    /**
     * @param RawFactory $rawFactory
     */
    public function __construct(RawFactory $rawFactory)
    {
        $this->rawFactory = $rawFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Raw|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->rawFactory->create()
            ->setHeader('Content-type', 'text/xml')
            ->setContents('<root><name>Jose A Hernandez</name><job>Adobe Commerce Developer</job></root>');
    }
}
