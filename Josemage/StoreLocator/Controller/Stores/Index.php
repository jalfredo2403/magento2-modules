<?php

namespace Josemage\StoreLocator\Controller\Stores;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     */
    public function __construct(
        PageFactory      $pageFactory,
        RequestInterface $request,
    )
    {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $page = $this->pageFactory->create();
        $page->getConfig()->getTitle()->set(__('Store Locator'));
        return $page;
    }
}
