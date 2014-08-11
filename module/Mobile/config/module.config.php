<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'mobile' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Mobile\Controller',
                        'controller'    => 'index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'module' => 'Mobile',
                                'action' => 'index',
                                '__NAMESPACE__' => 'Mobile\Controller'
                            ),
                        ),
                    ),
                    'g' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => 'g/:identity',
                            'defaults' => array(
                                'controller' => 'product',
                                'action' => 'list',
                                '__NAMESPACE__' => 'Mobile\Controller\Product'
                            ),
                        ),
                    ),
                    'p' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => 'p/:identity',
                            'defaults' => array(
                                'controller' => 'product',
                                'action' => 'single',
                                '__NAMESPACE__' => 'Mobile\Controller\Product'
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Mobile\Controller\Index' => 'Mobile\Controller\IndexController',
            'Mobile\Controller\Product\Product' => 'Mobile\Controller\Product\ProductController',
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'mobile/layout/layout'          => __DIR__ . '/../view/layout/layout.phtml',
            'mobile/layout/nav'             => __DIR__ . '/../view/layout/nav.phtml',
            'mobile/layout/breadcrumbs'     => __DIR__ . '/../view/layout/breadcrumbs.phtml',
        ),
        'template_path_stack' => array(
            'mobile' =>__DIR__ . '/../view',
        ),
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
