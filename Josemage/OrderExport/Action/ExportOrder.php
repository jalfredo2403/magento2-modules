<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Action;

use Josemage\OrderExport\Model\Config;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\ScopeInterface;
use Josemage\OrderExport\Action\PushDetailsToWebservice;

/**
 *
 */
class ExportOrder
{

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var CollectOrderData
     */
    private CollectOrderData $collectOrderData;

    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var \Josemage\OrderExport\Action\PushDetailsToWebservice
     */
    private PushDetailsToWebservice $pushDetailsToWebservice;
    private SaveExportDetailsToOrder $saveExportDetailsToOrder;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param Config $config
     * @param CollectOrderData $collectOrderData
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Config                   $config,
        CollectOrderData         $collectOrderData,
        PushDetailsToWebservice  $pushDetailsToWebservice,
        SaveExportDetailsToOrder $saveExportDetailsToOrder
    )
    {
        $this->config = $config;
        $this->collectOrderData = $collectOrderData;
        $this->orderRepository = $orderRepository;
        $this->pushDetailsToWebservice = $pushDetailsToWebservice;
        $this->saveExportDetailsToOrder = $saveExportDetailsToOrder;
    }

    /**
     * @param int $orderId
     * @param HeaderData $headerData
     * @return array
     */
    public function execute(int $orderId, HeaderData $headerData): array
    {
        $order = $this->orderRepository->get($orderId);

        if (!$this->config->isEnabled(ScopeInterface::SCOPE_STORE, $order->getStoreId())) {
            throw new LocalizedException(__('Order export is disabled'));
        }

        $results = ['success' => false, 'error' => null];
        $exportData = $this->collectOrderData->execute($order, $headerData);
        try {
            $results['success'] = $this->pushDetailsToWebservice->execute($exportData, $order);
            $this->saveExportDetailsToOrder->execute($order, $headerData, $results);
        } catch (\Throwable $ex) {
            $results['error'] = $ex->getMessage();
        }

        return $results;
    }

}
