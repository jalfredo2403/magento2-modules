<?php
declare(strict_types=1);

namespace Josemage\StoreIntegration\Controller\Index;

use Josemage\StoreIntegration\Action\GetIntegrationFromWebservices;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    private PageFactory $pageFactory;
    private RequestInterface $request;
    private GetIntegrationFromWebservices $integrationFromWebservices;

    /**
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     * @param GetIntegrationFromWebservices $integrationFromWebservices
     */
    public function __construct(
        PageFactory $pageFactory,
        RequestInterface $request,
        GetIntegrationFromWebservices $integrationFromWebservices
    )
    {

        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->integrationFromWebservices = $integrationFromWebservices;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
       $page = $this->pageFactory->create();
       $response = $this->integrationFromWebservices->execute();
       $page->getConfig()->getTitle()->set($response);
       return  $page;
    }
}
