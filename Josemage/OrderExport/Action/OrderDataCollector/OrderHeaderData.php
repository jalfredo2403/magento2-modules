<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Action\OrderDataCollector;

use Josemage\OrderExport\Api\OrderDataCollectorInterface;
use Josemage\OrderExport\Model\HeaderData;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;

class OrderHeaderData implements OrderDataCollectorInterface
{

    /**
     * @var OrderAddressRepositoryInterface
     */
    private OrderAddressRepositoryInterface $orderAddressRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param OrderAddressRepositoryInterface $orderAddressRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderAddressRepositoryInterface $orderAddressRepository,
        SearchCriteriaBuilder           $searchCriteriaBuilder
    )
    {

        $this->orderAddressRepository = $orderAddressRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param OrderInterface $order
     * @param HeaderData $headerData
     * @return array
     */
    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $output = [
            'id' => $order->getIncrementId(),
            'currency' => $order->getBaseCurrencyCode(),
            'discount' => $order->getBaseDiscountAmount(),
            'total' => $order->getBaseGrandTotal(),
        ];

        $shippingAddress = $this->getShippingAddress($order);
        if($shippingAddress){
            $output['shipping'] = [
                'name' => $shippingAddress->getFirstname(). ' '. $shippingAddress->getLastname(),
                'address' => $shippingAddress->getStreet() ? implode(', ', $shippingAddress->getStreet()): '',
                'city' => $shippingAddress->getCity(),
                'state' => $shippingAddress->getRegionCode(),
                'postcode' => $shippingAddress->getPostcode(),
                'country' => $shippingAddress->getCountryId(),
                'amount' => $order->getBaseShippingAmount(),
                'method' => $order->getShippingDescription()
            ];
        }

        return $output;
    }

    /**
     * @param OrderInterface $order
     * @return OrderAddressInterface|null
     */
    protected function getShippingAddress(OrderInterface $order): ?OrderAddressInterface
    {
        $this->searchCriteriaBuilder->addFilter('parent_id', $order->getEntityId())
            ->addFilter('address_type', 'shipping');
        $orderShipping = $this->orderAddressRepository->getList($this->searchCriteriaBuilder->create());

        $items = $orderShipping->getItems();
        if (count($items) === 0) {
            return null;
        }
        return reset($items);
    }


}
