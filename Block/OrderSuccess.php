<?php

namespace Dragonfly\BootstrapCheckout\Block;

use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order;

class OrderSuccess extends Template
{
    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * @param Session $checkoutSession
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Session          $checkoutSession,
        Template\Context $context,
        array            $data = [])
    {
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    /**
     * Initialize data and prepare it for output
     *
     * @return OrderSuccess
     */
    protected function _beforeToHtml()
    {
        $this->prepareBlockData();
        return parent::_beforeToHtml();
    }

    /**
     * Prepares block data
     *
     * @return void
     */
    protected function prepareBlockData(): void
    {
        $incrementId = null;

        if ($order = $this->getLastOrder()) {
            $incrementId = $order->getIncrementId();
        }

        if (empty($incrementId) && $this->getOrderNumberIncrementIdFromParam()) {
            $incrementId = $this->getOrderNumberIncrementIdFromParam();
        }

        $this->addData(
            [
                'order_id' => $incrementId
            ]
        );
    }

    /**
     * @return Order
     */
    public function getLastOrder(): Order
    {
        return $this->checkoutSession->getLastRealOrder();
    }

    /**
     * @return string|null
     */
    public function getOrderNumberIncrementIdFromParam(): ?string
    {
        return $this->checkoutSession->getLiqPayLastOrder() ?? null;
    }
}
