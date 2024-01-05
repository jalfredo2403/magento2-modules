<?php

namespace Josemage\Controllers\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;


/**
 * Redirect Class
 */
class Redirect implements HttpGetActionInterface
{
    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(RedirectFactory $redirectFactory)
    {
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->redirectFactory->create()->setUrl('/controllers/index/page');
    }
}
