<?php

namespace Dragonfly\BootstrapCheckout\Observer;

use Magento\Catalog\Api\ProductRepositoryInterfaceFactory as ProductRepository;
use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Area;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\Data\CartItemExtensionFactory;
use Magento\Store\Model\App\Emulation as AppEmulation;
use Magento\Store\Model\StoreManagerInterface as StoreManager;

class SalesQuoteLoadAfter implements ObserverInterface
{
    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * @var ProductImageHelper
     */
    protected ProductImageHelper $productImageHelper;

    /**
     * @var StoreManager
     */
    protected StoreManager $storeManager;

    /**
     * @var AppEmulation
     */
    protected AppEmulation $appEmulation;

    /**
     * @var CartItemExtensionFactory
     */
    protected CartItemExtensionFactory $extensionFactory;

    /**
     * @param ProductRepository $productRepository
     * @param ProductImageHelper $productImageHelper
     * @param StoreManager $storeManager
     * @param AppEmulation $appEmulation
     * @param CartItemExtensionFactory $extensionFactory
     */
    public function __construct(
        ProductRepository        $productRepository,
        ProductImageHelper       $productImageHelper,
        StoreManager             $storeManager,
        AppEmulation             $appEmulation,
        CartItemExtensionFactory $extensionFactory
    )
    {
        $this->productRepository = $productRepository;
        $this->productImageHelper = $productImageHelper;
        $this->storeManager = $storeManager;
        $this->appEmulation = $appEmulation;
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer, string $imageType = NULL): void
    {
        $quote = $observer->getEvent()->getData('quote');

        /**
         * Code to add the items attribute to extension_attributes
         */
        foreach ($quote->getAllItems() as $quoteItem) {
            $product = $this->productRepository->create()->getById($quoteItem->getProductId());
            $itemExtAttr = $quoteItem->getExtensionAttributes();
            if ($itemExtAttr === null) {
                $itemExtAttr = $this->extensionFactory->create();
            }

            $imgUrl = $this->getImageUrl($product, 'product_thumbnail_image');
            $itemExtAttr->setImageUrl($imgUrl);
            $itemExtAttr->setRowTotal($quoteItem->getRowTotal());
            $quoteItem->setExtensionAttributes($itemExtAttr);
        }
    }

    /**
     * Helper function that provides full cache image url
     * @param Product
     * @param string|null $imageType
     * @return string
     * @throws NoSuchEntityException
     */
    protected function getImageUrl(Product $product, string $imageType = NULL): string
    {
        $storeId = $this->storeManager->getStore()->getId();

        $this->appEmulation->startEnvironmentEmulation($storeId, Area::AREA_FRONTEND, true);
        $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->getUrl();

        $this->appEmulation->stopEnvironmentEmulation();

        return $imageUrl;
    }

}
