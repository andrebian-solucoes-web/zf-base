<?php

namespace BaseApplication;

use BaseApplication\Controller\AdminIndexController;
use BaseApplication\Controller\IndexController;
use BaseApplication\Controller\SearchController;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => AdminIndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'default' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/index/:action[/:id]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'search' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/search',
                    'defaults' => [
                        'controller' => SearchController::class,
                        'action' => 'index',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'invokables' => [
            IndexController::class => IndexController::class,
            SearchController::class => SearchController::class,
            AdminIndexController::class => AdminIndexController::class
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.twig',
            'application/index/index' => __DIR__ . '/../view/application/index/index.twig',
            'error/404' => __DIR__ . '/../view/error/404.twig',
            'error/index' => __DIR__ . '/../view/error/index.twig',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
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
