<?php
/**
 * @author magefast@gmail.com www.magefast.com
 */

declare(strict_types=1);

namespace Dragonfly\BootstrapCheckout\Controller\Index;

use Dragonfly\BootstrapCheckout\Api\BoostrapCheckoutInterface;
use Magento\Checkout\Helper\Data as CheckoutHelper;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Model\QuoteIdMaskFactory;

/**
 * Processes request
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var CheckoutHelper
     */
    private CheckoutHelper $checkoutHelper;

    /**
     * @var QuoteIdMaskFactory
     */
    private QuoteIdMaskFactory $quoteIdMaskFactory;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CheckoutHelper $checkoutHelper
     * @param QuoteIdMaskFactory $quoteIdMaskFactory
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context            $context,
        PageFactory        $resultPageFactory,
        CheckoutHelper     $checkoutHelper,
        QuoteIdMaskFactory $quoteIdMaskFactory,
        RedirectFactory    $redirectFactory,
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->checkoutHelper = $checkoutHelper;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->redirectFactory = $redirectFactory;
        $this->context = $context;

        parent::__construct($context);
    }

    /**
     * @return Page|ResultInterface|ResponseInterface|Redirect
     */
    public function execute()
    {

        if ($this->getCartMaskedId() === null) {
            return $this->redirectFactory->create()->setPath('checkout/cart');
        }

        $resultPage = $this->resultPageFactory->create(true);
        $resultPage->addHandle(BoostrapCheckoutInterface::HANDLE_NAME);
        $resultPage->setHeader('Content-Type', 'text/html');
        $resultPage->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0', true);
        return $resultPage;
    }

    /**
     * @return string|null
     */
    private function getCartMaskedId(): ?string
    {
        try {
            $cartId = $this->checkoutHelper->getQuote()->getId();

            $maskedQuote = $this->quoteIdMaskFactory->create()->load($cartId, 'quote_id');
            $this->redirectFactory->create()->setPath('checkout/cart');

            return $maskedQuote->getMaskedId() ?: null;
        } catch (LocalizedException $exception) {
            return null;
        }
    }
}


