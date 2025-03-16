<?php

namespace Dragonfly\BootstrapCheckout\Controller\Checkout;

use Dragonfly\BootstrapCheckout\Api\BoostrapCheckoutInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends \Magento\Checkout\Controller\Index\Index
{
    /**
     * @return ResultInterface
     */
    public function execute()
    {
        if (!$this->isSecureRequest()) {
            $this->_customerSession->regenerateId();
        }

        $this->getOnepage()->initCheckout();
        return $this->resultRedirectFactory->create()->setPath(BoostrapCheckoutInterface::URL_KEY);
    }

    private function isSecureRequest(): bool
    {
        $request = $this->getRequest();

        $referrer = $request->getHeader('referer');
        $secure = false;

        if ($referrer) {
            $scheme = parse_url($referrer, PHP_URL_SCHEME);
            $secure = $scheme === 'https';
        }

        return $secure && $request->isSecure();
    }
}
