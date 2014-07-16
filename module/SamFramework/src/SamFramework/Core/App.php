<?php
namespace SamFramework\Core;

use Zend\Authentication\AuthenticationService;
class App
{
    protected static $AuthenticationService;


    public static function getAuthenticationService()
    {
        if (!self::$AuthenticationService) {
        	self::$AuthenticationService = new AuthenticationService();
        }
        return self::$AuthenticationService;
    }

    public static function isGuest()
    {
        return self::getAuthenticationService()->hasIdentity();
    }

    public static function getUser()
    {
        return self::getAuthenticationService()->getIdentity();
    }
}

