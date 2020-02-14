<?php

namespace w2w\Utils;

/**
 * Fait un peu doublon par rapport à Utils::message, 
 * mais permet d'envoyer plusieurs messages "flash" en même temps.
 */
class FlashManager
{

    const INFO    = "info";
    const SUCCESS = "success";
    const WARNING = "warning";
    const ERROR   = "error";
    protected $sessionKey = "flashes";
    protected $infoHtmlFormat = '<div class="alert alert-info" role="alert">%s</div>';
    protected $successHtmlFormat = '<div class="alert alert-success" role="alert">%s</div>';
    protected $warningHtmlFormat = '<div class="alert alert-warning" role="alert">%s</div>';
    protected $errorHtmlFormat = '<div class="alert alert-danger" role="alert">%s</div>';


    public function __construct()
    {
        if (! isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
        foreach ($this->getTypes() as $type) {
            if (! isset($_SESSION[$this->sessionKey][$type])) {
                $_SESSION[$this->sessionKey][$type] = [];
            }
        }
    }
 
    public function getTypes()
    {
        return [
            self::INFO,
            self::SUCCESS,
            self::WARNING,
            self::ERROR,
        ];
    }

    public function clear()
    {
        foreach ($this->getTypes() as $type) {
            $_SESSION[$this->sessionKey][$type] = [];
        }
    }

    public function info($message)
    {
        return $this->add(self::INFO, $message);
    }
    
    public function success($message)
    {
        return $this->add(self::SUCCESS, $message);
    }
    
    public function warning($message)
    {
        return $this->add(self::WARNING, $message);
    }
    
    public function error($message)
    {
        return $this->add(self::ERROR, $message);
    }

    public function add($type, $message)
    {
        $_SESSION[$this->sessionKey][$type][] = $message;
    }
    
    public function hasInfos()
    {
        return count($_SESSION[$this->sessionKey][self::INFO]) > 0;
    }
    
    public function hasSuccesses()
    {
        return count($_SESSION[$this->sessionKey][self::SUCCESS]) > 0;
    }
    
    public function hasWarnings()
    {
        return count($_SESSION[$this->sessionKey][self::WARNING]) > 0;
    }
    
    public function hasErrors()
    {
        return count($_SESSION[$this->sessionKey][self::ERROR]) > 0;
    }
    
    public function getInfos()
    {
        return $_SESSION[$this->sessionKey][self::INFO];
    }
    
    public function getSuccesses()
    {
        return $_SESSION[$this->sessionKey][self::SUCCESS];
    }
    
    public function getWarnings()
    {
        return $_SESSION[$this->sessionKey][self::WARNING];
    }
    
    public function getErrors()
    {
        return $_SESSION[$this->sessionKey][self::ERROR];
    }
    
    public function display()
    {
        if ($this->hasErrors()) {
            foreach ($this->getErrors() as $error) {
                echo sprintf($this->errorHtmlFormat, escape($error));
            }
        }
        if ($this->hasWarnings()) {
            foreach ($this->getWarnings() as $warning) {
                echo sprintf($this->warningHtmlFormat, escape($warning));
            }
        }
        if ($this->hasSuccesses()) {
            foreach ($this->getSuccesses() as $success) {
                echo sprintf($this->successHtmlFormat, escape($success));
            }
        }
        if ($this->hasInfos()) {
            foreach ($this->getInfos() as $info) {
                echo sprintf($this->infoHtmlFormat, escape($info));
            }
        }
        $this->clear();
    }

}
