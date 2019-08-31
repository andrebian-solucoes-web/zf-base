<?php

namespace BaseApplication;

use BaseApplication\Mail\Mail;
use BaseApplication\View\Helper\AuthUserViewHelper;
use BaseApplication\View\Helper\BrazilianStateHelperComboViewHelper;
use BaseApplication\View\Helper\CPFMaskViewHelper;
use BaseApplication\View\Helper\CpfViewHelper;
use BaseApplication\View\Helper\JsonDecodeViewHelper;
use BaseApplication\View\Helper\NextNetworkDayViewHelper;
use BaseApplication\View\Helper\PhpVersionViewHelper;
use BaseApplication\View\Helper\ProductionEnvViewHelper;
use BaseApplication\View\Helper\RefererViewHelper;
use BaseApplication\View\Helper\S3ViewHelper;
use BaseApplication\View\Helper\SlugifyViewHelper;
use Exception;
use Traversable;
use Zend\Cache\StorageFactory;
use Zend\Mail\Transport\Sendmail;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class Module
 * @package BaseApplication
 * @codeCoverageIgnore
 */
class Module implements
    ViewHelperProviderInterface,
    InitProviderInterface,
    ServiceProviderInterface,
    ConfigProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Mail::class => function (ServiceManager $serviceManager) {
                    $emailConfig = $serviceManager->get('config')['mail'];
                    $transport = new Sendmail();

                    try {
                        $renderer = $serviceManager->get('ViewRenderer');
                    } catch (Exception $e) {
                        $renderer = new PhpRenderer();
                    }

                    return new Mail($transport, $emailConfig, $renderer, 'contact');
                },
                'cache' => function (ServiceManager $serviceManager) {
                    $config = $serviceManager->get('config')['cache'];
                    $cache = StorageFactory::factory([
                        'adapter' => $config['adapter'],
                        'options' => [
                            'ttl' => $config['ttl']
                        ],
                        'plugins' => [
                            'exception_handler' => [
                                'throw_exceptions' => $config['throw_exceptions']
                            ],
                            'serializer'
                        ]
                    ]);
                    return $cache;
                }
            ]
        ];
    }

    /**
     * Initialize workflow
     *
     * @param ModuleManagerInterface $moduleManager
     * @return void
     */
    public function init(ModuleManagerInterface $moduleManager)
    {
        // Uncomment this if you need that all actions for this module were authenticated
//        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
//        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function (MvcEvent $event) {
//
//            $auth = new AuthenticationService();
//            $auth->setStorage(new Session(SessionNamespace::NAME));
//
//            /** @var AbstractActionController $controller */
//            $controller = $event->getTarget();
//            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
//
//            $config = __DIR__ . '/../config/module.config.php';
//            $publicRoutes = new PublicRoutes();
//            $whitelist = $publicRoutes->getPublicRoutes($config);
//
//            /** @var AbstractActionController $controller */
//            $controller = $event->getTarget();
//
//            if (! $auth->hasIdentity()) {
//                return $controller->redirect()->toRoute('login');
//            }
//
//            // if you want to bypass for public routes, comment the 3 lines above and uncomment
//            // the following lines
////            if (! $auth->hasIdentity() && ! in_array($matchedRoute, $whitelist)) {
////                return $controller->redirect()->toRoute('login');
////            }
//
//        }, 100);
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|Config
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'zapLoading' => View\Helper\ZapLoadingViewHelper::class,
                'jsonDecode' => JsonDecodeViewHelper::class,
                'slugify' => SlugifyViewHelper::class,
                'brazilianStateCombo' => BrazilianStateHelperComboViewHelper::class,
                'user' => AuthUserViewHelper::class,
                'authUser' => AuthUserViewHelper::class,
                'isProductionEnv' => ProductionEnvViewHelper::class,
                'isProd' => ProductionEnvViewHelper::class,
                'phpversion' => PhpVersionViewHelper::class,
                'cpfMask' => CPFMaskViewHelper::class,
                'cpf' => CpfViewHelper::class,
                's3Url' => S3ViewHelper::class,
                'referer' => RefererViewHelper::class,
                NextNetworkDayViewHelper::class => NextNetworkDayViewHelper::class
            ],
            'aliases' => [
                'proximoDiaUtil' => NextNetworkDayViewHelper::class,
                'nextNetworkDay' => NextNetworkDayViewHelper::class
            ]
        ];
    }
}
