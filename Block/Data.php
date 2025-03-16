<?php
/**
 * @author magefast@gmail.com www.magefast.com
 */

declare(strict_types=1);

namespace Dragonfly\BootstrapCheckout\Block;

use Magento\Checkout\Helper\Data as CheckoutHelper;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Magento\Quote\Model\QuoteIdMaskFactory;
use Magento\Theme\Block\Html\Header\Logo;

class Data extends AbstractBlock implements IdentityInterface
{
    /**
     * @var CheckoutHelper
     */
    private CheckoutHelper $checkoutHelper;

    /**
     * @var QuoteIdMaskFactory
     */
    private QuoteIdMaskFactory $quoteIdMaskFactory;

    /**
     * @var Logo
     */
    private Logo $logo;

    /**
     * @param Context $context
     * @param CheckoutHelper $checkoutHelper
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param Logo $logo
     * @param array $data
     */
    public function __construct(
        Context            $context,
        CheckoutHelper     $checkoutHelper,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        Logo $logo,
        array              $data = [])
    {
        $this->checkoutHelper = $checkoutHelper;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->logo = $logo;

        parent::__construct($context, $data);
    }

    /**
     * @return string|null
     */
    public function getCartMaskedId(): ?string
    {
        try {
            $cartId = $this->checkoutHelper->getQuote()->getId();
            $maskedQuote = $this->quoteIdMaskFactory->create()->load($cartId, 'quote_id');

            return $maskedQuote->getMaskedId() ?: null;
        } catch (LocalizedException $exception) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getCartUrl(): string
    {
        return $this->getUrl('checkout/cart', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getOrderSuccessUrl(): string
    {
        return $this->getUrl('order/success', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getUrl();
    }

    public function getNovaPoshtaDetailsShippingUrl(): string
    {
        return $this->getUrl('npb', ['_secure' => true]);
    }

    /**
     * @return string
     */
    public function getRestUrl(): string
    {
        return $this->getUrl('rest/*/V1/', ['_secure' => true]);
    }

    /**
     * Get unique page cache identities
     */
    public function getIdentities(): array
    {
        return [];
    }

    /**
     * @return null
     */
    public function getCacheLifetime()
    {
        return null;
    }

    /**
     * Retrieve base content
     */
    protected function _toHtml(): string
    {
        $content = '';

        return $content . PHP_EOL;
    }

    /**
     * @return string
     */
    public function getLogoSrc(): string
    {
        return $this->logo->getLogoSrc();
    }

    /**
     * @return string
     */
    public function getLogoAlt(): string
    {
        return $this->logo->getLogoAlt();
    }
}
