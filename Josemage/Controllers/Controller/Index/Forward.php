<?php

namespace Josemage\Controllers\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\ForwardFactory;


/**
 * Forward Class
 */
class Forward implements HttpGetActionInterface
{

    /**
     * @var fowardFactory
     */
    protected $fowardFactory;

    /**
     * @param ForwardFactory $fowardFactory
     */
    public function __construct(ForwardFactory $fowardFactory)
    {
        $this->fowardFactory = $fowardFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->fowardFactory->create()->forward('page');
    }
}
