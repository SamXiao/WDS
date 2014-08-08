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
            'wds.admin.local' => array(
                'type' => 'Zend\Mvc\Router\Http\Hostname',
                'options' => array(
                    'route' => ':4th.[:3rd.]:2nd.:1st', // domain levels from right to left
                    'contraints' => array(
                        '4th' => 'wds',
                        '3rd' => '.*?', // optional 3rd level domain such as .ci, .dev or .test
                        '2nd' => 'admin',
                        '1st' => 'local',
                    ),

                    // Purposely omit default controller and action
                    // to let the child routes control the route match
                    'defaults' => array(
                        'module' => 'Admin',
                        'action' => 'index',
                    )
                ),
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'index',
                                '__NAMESPACE__' => 'Admin\Controller'
                            ),
                        ),
                    ),
                    'product' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/product[/][:controller[/][:action[/][:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'product',
                                '__NAMESPACE__' => 'Admin\Controller\Product'
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
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\User' => 'Admin\Controller\UserController',
            'Admin\Controller\Product\Product' => 'Admin\Controller\Product\ProductController'
        ),
    ),
    'view_manager' => array(

        // The TemplatePathStack takes an array of directories. Directories
        // are then searched in LIFO order (it's a stack) for the requested
        // view script. This is a nice solution for rapid application
        // development, but potentially introduces performance expense in
        // production due to the number of static calls necessary.
        //
        // The following adds an entry pointing to the view directory
        // of the current module. Make sure your keys differ between modules
        // to ensure that they are not overwritten -- or simply omit the key!

        'template_map' => array(
            'admin/layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
             'admin' =>__DIR__ . '/../view',
        ),
    ),

    'system_params' => array(
        'upload' => array(
    	   'upload_file_path' => '/asserts/product/images',
    	   'hostname' => 'http://wds.admin.local'
        )
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
