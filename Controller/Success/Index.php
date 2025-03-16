<?php
/**
 * @author magefast@gmail.com www.magefast.com
 */

declare(strict_types=1);

namespace Dragonfly\BootstrapCheckout\Controller\Success;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Model\Order;

/**
 * Processes request
 */
class Index extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $redirectFactory
     * @param Session $session
     */
    public function __construct(
        Context         $context,
        PageFactory     $resultPageFactory,
        RedirectFactory $redirectFactory,
        Session         $session
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->checkoutSession = $session;
        $this->redirectFactory = $redirectFactory;

        parent::__construct($context);
    }

    /**
     * @return Page|ResultInterface|ResponseInterface|Redirect
     */
    public function execute()
    {
        $orderIncrementId = false;
        if ($this->checkoutSession->getLiqPayLastOrder()) {
            $orderIncrementId = $this->checkoutSession->getLiqPayLastOrder();
        }

        if ($this->getLastOrder() && $this->getLastOrder()->getId() || $orderIncrementId) {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->addHandle('bootstrapcheckout_success_index');
            $resultPage->getConfig()->setRobots('NOINDEX, NOFOLLOW, NOARCHIVE, NOSNIPPET');
            $resultPage->getConfig()->getTitle()->set(
                __('Order Created')
            );
            return $resultPage;
        }

        return $this->redirectFactory->create()->setPath('checkout/cart');
    }

    /**
     * @return Order
     */
    private function getLastOrder(): Order
    {
        return $this->checkoutSession->getLastRealOrder();
    }

}


