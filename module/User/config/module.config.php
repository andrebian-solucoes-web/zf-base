<?php

namespace User;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use User\Controller\AdminAuthController;
use User\Controller\AdminPasswordRecoveryController;
use User\Controller\AuthController;
use User\Controller\PasswordRecoveryController;
use Zend\I18n\Translator\TranslatorServiceFactory;
use Zend\Router\Http\Literal;

$ormCacheEngine = 'array';
if (defined('ORM_CACHE_ENGINE')) {
    $ormCacheEngine = ORM_CACHE_ENGINE;
}

return [
    'router' => [
        'routes' => [
            'admin-login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/login',
                    'defaults' => [
                        'controller' => AdminAuthController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin-logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/logout',
                    'defaults' => [
                        'controller' => AdminAuthController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'admin-password-recovery' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/user/password-recovery',
                    'defaults' => [
                        'controller' => AdminPasswordRecoveryController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin-recovery-password-action' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/user/recovery-password-action',
                    'defaults' => [
                        'controller' => AdminPasswordRecoveryController::class,
                        'action' => 'recoverPassword',
                    ],
                ],
            ],
            'admin-password-recovery-error' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/user/password-recovery-error',
                    'defaults' => [
                        'controller' => AdminPasswordRecoveryController::class,
                        'action' => 'error',
                    ],
                ],
            ],


            // public area
            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'password-recovery' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/password-recovery',
                    'defaults' => [
                        'controller' => PasswordRecoveryController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'recovery-password-action' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/recovery-password-action',
                    'defaults' => [
                        'controller' => PasswordRecoveryController::class,
                        'action' => 'recoverPassword',
                    ],
                ],
            ],
            'password-recovery-error' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/password-recovery-error',
                    'defaults' => [
                        'controller' => PasswordRecoveryController::class,
                        'action' => 'error',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            AuthController::class => AuthController::class,
            PasswordRecoveryController::class => PasswordRecoveryController::class,
            AdminAuthController::class => AdminAuthController::class,
            AdminPasswordRecoveryController::class => AdminPasswordRecoveryController::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => $ormCacheEngine,
                'paths' => [dirname(__DIR__) . '/src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
        'fixture' => [
            __NAMESPACE__ => __DIR__ . '/../src/Fixture'
        ]
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'translator' => TranslatorServiceFactory::class
        ],
    ],
    'translator' => [
        'locale' => 'pt_BR',
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ],
        ],
    ],
];
