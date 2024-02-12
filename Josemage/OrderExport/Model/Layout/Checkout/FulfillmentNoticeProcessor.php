<?php
declare(strict_types=1);

namespace Josemage\OrderExport\Model\Layout\Checkout;

use Josemage\OrderExport\Model\Config;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Cms\Block\BlockByIdentifier;
use Magento\Framework\View\LayoutInterface;

class FulfillmentNoticeProcessor implements LayoutProcessorInterface
{
    private Config $config;
    private LayoutInterface $layout;

    /**
     * @param Config $config
     * @param LayoutInterface $layout
     */
    public function __construct(
        Config $config,
        LayoutInterface $layout

    )
    {
        $this->config = $config;
        $this->layout = $layout;
    }

    /**
     * {@inheritdoc}
     */
    public function process($jsLayout)
    {
        if (!$this->config->isEnabled()) {
            return $jsLayout;
        }

        $fulfillmentBlock = $this->layout->createBlock(BlockByIdentifier::class);
        $fulfillmentBlock->setData('identifier', 'fulfillment-notice');
        $fulfillmentBlockOutput = $fulfillmentBlock->toHtml();

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['fulfillmentNotice']['config']['noticeContent'] = $fulfillmentBlockOutput;

        return $jsLayout;
    }
}
