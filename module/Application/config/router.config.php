<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'default' => array(
        'type' => 'Segment',
        'options' => array(
            'route' => '/[:controller[/:action]]',
            'constraints' => array(
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
            ),
            'defaults' => array(
                '__NAMESPACE__' => 'Application\Controller',
                'controller'    => 'index',
                'action'        => 'index',
            )
        )
    ),
    'product' => array(
        'type' => 'Segment',
        'options' => array(
            'route' => '/product[/][:controller[/][:action[/][:id]]]',
            'constraints' => array(
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'id' => '[0-9]+'
            ),
            'defaults' => array(
                'controller' => 'product',
                '__NAMESPACE__' => 'Application\Controller\Product'
            )
        )
    ),
    'oauth' => array(
        'type' => 'Segment',
        'options' => array(
            'route' => '/oauth[/:action][/:channel]',
            'constraints' => array(
                'channel' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
            ),
            'defaults' => array(
                'controller' => 'oauth',
                '__NAMESPACE__' => 'Application\Controller'
            )
        )
    ),
)
;

