<?php
return array(
    'm.wds.local' => array(
        'type' => 'Zend\Mvc\Router\Http\Hostname',
        'options' => array(
            'route' => ':4th.[:3rd.]:2nd.:1st', // domain levels from right to left
            'constraints' => array(
                '4th' => 'm',
                '3rd' => '.*?', // optional 3rd level domain such as .ci, .dev or .test
                '2nd' => 'wds',
                '1st' => 'local'
            ),

            // Purposely omit default controller and action
            // to let the child routes control the route match
            'defaults' => array(
                'module' => 'Admin',
                'action' => 'index'
            )
        ),
        'child_routes' => require (__DIR__ . "/child.router.config.php")
    ),

);
