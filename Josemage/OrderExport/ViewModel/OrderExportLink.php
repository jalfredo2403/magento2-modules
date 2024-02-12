<?php
declare(strict_types=1);

namespace Josemage\OrderExport\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 *
 */
class OrderExportLink implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;

    /**
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        RequestInterface $request,
        UrlInterface     $urlBuilder
    )
    {

        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @return string
     */
    public function getOrderExportUrl(): string
    {
        $orderId = $this->request->getParam('order_id');
        return $this->urlBuilder->getUrl(
            'order_export/view/index',
            [
                'order_id' => (int)$orderId,
            ]
        );
    }

}
