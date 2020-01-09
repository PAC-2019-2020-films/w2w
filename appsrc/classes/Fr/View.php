<?php
namespace Fr;

use Fr\Config;
use Fr\Exceptions\Exception;
use Fr\Exceptions\ViewNotFoundException;
use Fr\Exceptions\TemplateNotFoundException;
use Fr\View\ViewHelper;
use Fr\Escaper;

class View {

    protected $_dirname = "views"; // in FR_APPPATH
    protected $_name = "index";
    protected $_extension = ".php";
    protected $_viewPath;
    protected $_data = array();
    protected $_filter;
    
    /*
     * $_content will hold the result of rendering the view :
     * 
     * (not to be confused with possible $_data["content"],
     * used by layout/template views)
     */
    protected $_content; 
    
    

    public static function forge($name = null, $data = null, $filter = null) {
        $view = new static($name, $data, $filter);
        $view->render();
        return $view;
    }

    public function __construct($name = null, $data = null, $filter = null) {
        $this->_name = $name;
        if (is_array($data)) {
                $this->_data = $data;
        }
        $this->_filter = $filter;
        $this->_viewPath = $this->getPath() . $this->_name . $this->_extension;
    }

    public function __toString() {
        return (string) $this->_content;
    }
    
    public function getPath() {
        return FR_SRCPATH . ($this->_dirname ? DIRECTORY_SEPARATOR . $this->_dirname : '') . DIRECTORY_SEPARATOR;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($value) {
        $this->_name = $value;
        return $this;
    }

    public function getContent() {
        return $this->_content;
    }

    public function setContent($value) {
        $this->_content = $value;
        return $this;
    }



    public function get($name) {
        if (isset($this->_data[$name])) {
                return $this->_data[$name];
        }
        return null;
    }
    
    public function set($name, $value) {
        $this->_data[$name] = $value;
        return $this;
    }
    
    public function push($name, $value) {
        $this->_data[$name][] = $value;
        return $this;
    }
    
    public function __get($name) {
        return $this->get($name);
    }
    
    public function __set($name, $value) {
        return $this->set($name, $value);
    }



    public function renderViewFile($contentPath, $data = array()) {
        if (! is_file($contentPath)) {
            throw new ViewNotFoundException($contentPath);
        }
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include $contentPath;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function render() {
        $this->_content = $this->renderViewFile($this->_viewPath, $this->_data);
        return $this->_content;
    }

    /**
     * inspiré de Zend pour appel à aides de vues
     */ 
    public function __call($method, $argv)
    {
        $helper = $this->plugin($method);
        if (is_callable($helper)) {
            return call_user_func_array($helper, $argv);
        }
        return $helper;
    }

    public function plugin($name, array $options = null)
    {
        $view_helpers = Config::get("fr.view_helpers");
        if (is_array($view_helpers) && isset($view_helpers[$name])) {
            $className = $view_helpers[$name];
        } else {
            $className = "\\Fr\\View\\Helper\\" . $name;
        }
        if (class_exists($className)) {
            $helper = new $className($options);
            if (! $helper instanceof ViewHelper) {
                throw new Exception("Helper not an instance of ViewHelper");
            }
            $helper->setView($this);
        } else {
            throw new Exception("Helper class not found");
        }
        return $helper;
    }

    /**
     * appel à un template/une 'sous-vue' 
     */
    public function template($name, $data = array()) {
        $templatePath = $this->getPath() . "templates/" . $name . ".php";
        if (! is_file($templatePath)) {
            throw new TemplateNotFoundException($templatePath);
        }
        return $this->renderViewFile($templatePath, $data);
    }

    public function escape($string, $flags = false, $encoding = "utf-8", $double_encode = true) {
        return Escaper::escapeHTML($string, $flags, $encoding, $double_encode);
    }

}
