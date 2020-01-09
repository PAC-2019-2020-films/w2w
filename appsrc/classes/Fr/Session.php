<?php
namespace Fr;

class Session {
    
    
    private static $instance;

    public static function getSession() 
    {
        if (! self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        session_start();
    }
    
    public function has($name)
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    public function get($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return $default;
        }
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
        return $this;
    }

    /**
     * https://www.php.net/manual/fr/function.session-destroy.php
     */
    public static function destroy() 
    {
        
        // Détruit toutes les variables de session
        $_SESSION = array();
        
        // Si vous voulez détruire complètement la session, effacez également
        // le cookie de session.
        // Note : cela détruira la session et pas seulement les données de session !
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Finalement, on détruit la session.
        session_unset();
        session_destroy();    
    }

}
