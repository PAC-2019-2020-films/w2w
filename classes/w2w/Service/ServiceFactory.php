<?php

namespace w2w\Service;

class ServiceFactory
{
    
    protected static $serviceFactory;
    
    /**
     * UserService constructor.
     */
    public static function getServiceFactory()
    {
        if (! self::$serviceFactory) {
            self::$serviceFactory = new static();
        }
        return self::$serviceFactory;
    }
    
    public function getPublicService()
    {
        return new PublicService();
    }
    
}
