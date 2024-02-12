<?php
declare(strict_types=1);

namespace Josemage\OrderExport\ViewModel;

use Josemage\OrderExport\Api\Data\OrderExportDetailsInterface;
use Josemage\OrderExport\Api\Data\OrderExportDetailsInterfaceFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderExportView implements ArgumentInterface
{
    /** @var null|OrderInterface */
    private $order = null;

    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;
    /**
     * @var TimezoneInterface
     */
    private TimezoneInterface $timezone;
    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;
    /**
     * @var PageConfig
     */
    private PageConfig $pageConfig;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    private OrderExportDetailsInterfaceFactory $orderExportDetailsFactory;


    /**
     * @param RequestInterface $request
     * @param OrderRepositoryInterface $orderRepository
     * @param TimezoneInterface $timezone
     * @param UrlInterface $urlBuilder
     * @param PageConfig $pageConfig
     * @param OrderExportDetailsInterfaceFactory $orderExportDetailsFactory
     */
    public function __construct(
        RequestInterface $request,
        OrderRepositoryInterface $orderRepository,
        TimezoneInterface $timezone,
        UrlInterface $urlBuilder,
        PageConfig $pageConfig,
        OrderExportDetailsInterfaceFactory $orderExportDetailsFactory
    )
    {
        $this->orderRepository = $orderRepository;
        $this->timezone = $timezone;
        $this->urlBuilder = $urlBuilder;
        $this->pageConfig = $pageConfig;
        $this->request = $request;
        $this->orderExportDetailsFactory = $orderExportDetailsFactory;

        $order = $this->getOrder();
        if ($order) {
            $this->pageConfig->getTitle()->set(__('Order # %1', $order->getRealOrderId()));
        }

    }

    /**
     * @return OrderExportDetailsInterface|null
     */
    public function getOrderExportDetails(): ?OrderExportDetailsInterface
    {
       $order = $this->getOrder();
       if($order=== null){
           return null;
       }
       return $order->getExtensionAttributes()->getExportDetails();
    }

    /**
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface
    {
        if ($this->order === null) {
            $orderId = (int)$this->request->getParam('order_id');
            if (!$orderId) {
                return null;
            }

            try {
                $order = $this->orderRepository->get($orderId);
            } catch (NoSuchEntityException $e) {
                return null;
            }

            $this->order = $order;
        }

        return $this->order;
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function formatDate(\DateTime $dateTime): string
    {
        return $this->timezone->formatDate($dateTime, \IntlDateFormatter::LONG);
    }

    /**
     * @return string
     */
    public function getOrderViewUrl(): string
    {
        $order = $this->getOrder();
        if (!$order) {
            return '';
        }

        return $this->urlBuilder->getUrl(
            'sales/order/view',
            [
                'order_id' => $order->getEntityId()
            ]
        );
    }



}
