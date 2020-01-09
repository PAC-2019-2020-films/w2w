<?php

namespace controller;

use \Fr\Config;
use \Fr\LayoutAware;
use \Fr\Response;
use \Fr\Session;
use \Fr\View;
use \w2w\Model\User;
use \w2w\Service\ServiceFactory;
use \Fr\Log\Loggable;

/**
 */
abstract class BaseController implements LayoutAware
{
    
    use Loggable;
 
    const LAYOUT_NAME_CONFIG = "fr.layout.name";
    const LAYOUT_NAME_DEFAULT = "layouts/layout";
    const LAYOUT_CLASSNAME_CONFIG = "fr.layout.classname";
    const LAYOUT_CLASSNAME_DEFAULT = "\\Fr\\View";
    
    protected $layout;
    protected $layoutViewClassName;
    protected $layoutView;
    protected $user;
    protected $publicService;
    
    public function __construct()
    {
        if ($session = Session::getSession()) {
            if ($session->has("user")) {
                $userId = $session->get("user");
                $user = $this->getPublicService()->getUserById($userId);
                $this->setUser($user);
            }
        }
    }

    public function getPublicService()
    {
        if (! $this->publicService) {
            if ($serviceFactory = ServiceFactory::getServiceFactory()) {
                $this->publicService = $serviceFactory->getPublicService();
            }
        }
        return $this->publicService;
    }
    
    public function getParameter($name, $default = null, $filter = true)
    {
        foreach (array($_POST, $_GET, $_COOKIE) as $superglobal) {
            if (isset($superglobal[$name])) {
                $value = $superglobal[$name];
                if ($filter) {
                    if ($value !== null && $value !== 0) {
                        if (is_array($value)) {
                            array_map('strip_tags', $value);
                            array_map('trim', $value);
                        } else {
                            $value = strip_tags($value);
                            $value = trim($value);
                        }
                    }
                }
                return $value;
            }
        }
        return $default;
    }
    
    public function getMethod()
    {
        return isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : null;
    }
    
    public function isGet()
    {
        return "GET" == $this->getMethod() ? true : false;
    }
 
    public function isPost()
    {
        return "POST" == $this->getMethod() ? true : false;
    }
 
    public function getConfig($name = null, $default = null)
    {
        return Config::get($name, $default);
    }

    public function forgeView($name = null, $data = null, $filter = null) 
    {
        return View::forge($name, $data, $filter);
    }
    
    public function forgeResponse($body = null, $status = 200, $headers = []) 
    {
        return Response::forge($body, $status, $headers);
    }

    public function getUser()
    {
        return $this->user;
    }
    
    public function hasUser()
    {
        return $this->user instanceof User;
    }
    
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    public function prepareLayout()
    {
        if (! $this->layout) {
            $this->layout = Config::get(self::LAYOUT_NAME_CONFIG, self::LAYOUT_NAME_DEFAULT);
        }
        if (! $this->layoutViewClassName) {
            $this->layoutViewClassName = Config::get(self::LAYOUT_CLASSNAME_CONFIG, self::LAYOUT_CLASSNAME_DEFAULT);
        }
        if (class_exists($this->layoutViewClassName)) {
            $this->layoutView = new $this->layoutViewClassName($this->layout);
        } else {
            throw new \Fr\Exceptions\ClassNotFoundException("'{$this->layoutClassName}'");
        }
        return $this;
    }
    
    public function renderLayout($content)
    {
        if ($this->layoutView instanceof View) {
            if ($this->user instanceof User) {
                $this->layoutView->set("user", $this->user);
            }
            $this->layoutView->set("content", $content);
            $this->layoutView->render(); # ?
            return $this->layoutView;
        }
    }

    public function getLayout()
    {
        return $this->layoutView;
    }

    public function setLayoutProperty($name, $value) 
    {
        if ($this->layoutView instanceof View) {
            $this->layoutView->set($name, $value);
        }
    }

    public function setLayoutTitle($title) 
    {
        return $this->setLayoutProperty("headTitle", $title);
    }

}
