<?php

namespace Josemage\OrderExport\Action\OrderDataCollector;

use Josemage\OrderExport\Action\GetOrderExportItems;
use Josemage\OrderExport\Api\OrderDataCollectorInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 *
 */
class OrderItemData implements OrderDataCollectorInterface
{
    /**
     * @var GetOrderExportItems
     */
    private GetOrderExportItems $exportItems;
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;


    /**
     * @param GetOrderExportItems $exportItems
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        GetOrderExportItems        $exportItems,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder      $searchCriteriaBuilder,
    )
    {

        $this->exportItems = $exportItems;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {

        $orderItems = $this->exportItems->execute($order);
        $skus = $this->getSkusFromOrderItems($orderItems);
        $productsBySku = $this->loadProducts($skus);
        $mapItems = array();
        foreach ($orderItems as $orderItem) {
            $product = $productsBySku[$orderItem->getSku()] ?? null;
            $mapItems[] = $this->mapOrderItem($orderItem, $product);
        }
        return [
            'items' => $mapItems,
        ];

    }

    /**
     * @param OrderItemInterface $orderItem
     * @return array
     */
    private function mapOrderItem(OrderItemInterface $orderItem, ?ProductInterface $product)
    {
        return [
            'sku' => $this->getSku($orderItem,$product),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getBaseRowTotal()
        ];
    }

    /**
     * @param OrderItemInterface[] $orderItems
     * @return array
     */
    private function getSkusFromOrderItems(array $orderItems): array
    {
        $skus = [];
        foreach ($orderItems as $orderItem) {
            $skus[] = $orderItem->getSku();
        }
        return $skus;
    }

    /**
     * @param array $skus
     * @return ProductInterface[]
     */
    private function loadProducts(array $skus): array
    {
        $this->searchCriteriaBuilder->addFilter('sku', $skus, 'in');
        /** @var  ProductInterface[] $prducts */
        $products = $this->productRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        $productBySku = [];
        foreach ($products as $product) {
            $productBySku[$product->getSku()] = $product;
        }
        return $productBySku;
    }

    private function getSku(OrderItemInterface $orderItem, ?ProductInterface $product): string
    {
        $sku = $orderItem->getSku();
        if ($product === null) {
            return $sku;
        }

        $skuOverride = $product->getCustomAttribute('sku_override');
        $skuOverrideVal = ($skuOverride !== null) ? $skuOverride->getValue() : null;

        if (!empty($skuOverrideVal)) {
            $sku = $skuOverrideVal;
        }
        return $sku;
    }

}
