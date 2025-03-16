<?php
/**
 * @author magefast@gmail.com www.magefast.com
 */

declare(strict_types=1);

namespace Dragonfly\BootstrapCheckout\Controller;

use Dragonfly\BootstrapCheckout\Api\BoostrapCheckoutInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Route\ConfigInterface;
use Magento\Framework\App\Router\ActionList;
use Magento\Framework\App\RouterInterface;
use ReflectionException;

/**
 * Class Router
 */
class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private ActionFactory $actionFactory;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $routeConfig;

    /**
     * @var ActionList
     */
    private ActionList $actionList;

    /**
     * @param ActionFactory $actionFactory
     * @param ConfigInterface $routeConfig
     * @param ActionList $actionList
     */
    public function __construct(
        ActionFactory   $actionFactory,
        ConfigInterface $routeConfig,
        ActionList      $actionList
    )
    {
        $this->actionFactory = $actionFactory;
        $this->routeConfig = $routeConfig;
        $this->actionList = $actionList;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     * @throws ReflectionException
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $modules = $this->routeConfig->getModulesByFrontName('bootstrapcheckout');
        if (empty($modules)) {
            return null;
        }

        $identifier = trim($request->getPathInfo(), '/');

        $item = $this->isCheckoutPage($identifier);
        if ($item !== null) {
            $actionClassName = $this->actionList->get($modules[0], null, 'index', 'index');
            return $this->actionFactory->create($actionClassName);
        }

        $item = $this->isCheckoutSuccessPage($identifier);
        if ($item !== null) {
            $actionClassName = $this->actionList->get($modules[0], null, 'success', 'index');
            return $this->actionFactory->create($actionClassName);
        }

        return null;
    }

    /**
     * @param null $string
     * @return true|null
     */
    private function isCheckoutPage($string = null): ?bool
    {
        if (!is_string($string) || empty($string)) {
            return null;
        }

        $string = ltrim($string, '/');
        $string = rtrim($string, '/');

        if ($string === BoostrapCheckoutInterface::URL_KEY) {
            return true;
        }

        return null;
    }

    private function isCheckoutSuccessPage($string = null): ?bool
    {
        if (!is_string($string) || empty($string)) {
            return null;
        }

        $string = ltrim($string, '/');
        $string = rtrim($string, '/');

        if ($string === BoostrapCheckoutInterface::URL_KEY_ORDER_SUCCESS) {
            return true;
        }

        return null;
    }
}
