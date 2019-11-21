<?php
namespace Fr;

use \Fr\Exceptions\ConfigException;

class Config {

    private static $config = array();
    
    public static function error($msg) {
        //trigger_error($msg);
        throw new ConfigException($msg);
    }

    //public static function load($file, $group = null, $reload = false, $overwritten = false) {
    public static function load($file, $group = null, $reload = false) {
        if (is_string($file)) {
            if (is_file($file)) {
                if (is_readable($file)) {
                    $config = include $file;
                    if (! is_array($config)) {
                        static::error("Config file '{$file}' must return an array.");
                        return false;
                    }
                } else {
                    static::error("Config file '{$file}' not readable.");
                    return false;
                }
            } else {
                static::error("Config file '{$file}' not found or is not a file.");
                return false;
            }
        } elseif (is_array($file)) {
            $config = $file;
        } else {
            static::error("Expecting a valid filename or an array.");
            return false;
        }
        if ($group) {
            $config = array($group => $config);
        }
        if ($reload) {
            self::$config = $config;
        } else {
            self::$config = array_merge(self::$config, $config);
        }
        return self::$config;
    }

    public static function set($name, $value) {
        $name = trim($name);
        self::$config[$name] = $value;
    }

    public static function get($name = null, $default = null) {
        $name = trim($name);
        if ($name == null) {
            $value = self::$config;
        } elseif (! isset(self::$config[$name])) {
            $value = $default;
        } else {
            $value = self::$config[$name];
        }
        return $value;
    }

    private function __construct() {
    }
    
}
