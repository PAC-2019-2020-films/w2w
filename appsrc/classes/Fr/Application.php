<?php
namespace Fr;

use \Fr\Config;
use \Fr\Exceptions\ConfigException;
use \Fr\LayoutAware;
use \Fr\Response;
use \Fr\Log\Logger;

class Application {
   
        
    public function __construct($config = null) {
        
        if (is_array($config)) {
            Config::load($config);
        }
        # config file in application-specific source code dir : 
        try {
            Config::load(FR_SRCPATH . "/config/config.php");
        } catch (ConfigException $e) {
        }
        # config file in installation-specific dir :
        try {
            Config::load(FR_VARPATH . "/config/config.php");
        } catch (ConfigException $e) {
        }
        # environment-specific config file in installation-specific dir :
        try {
            Config::load(sprintf(FR_VARPATH . "/config/config.%s.php", FR_ENV));
        } catch (ConfigException $e) {
        }
        if ($logLevel = Config::get("fr.log.level")) {
            Logger::getInstance()->setLogLevel($logLevel);
        }
    }



    /**
     * routage très simple, analyse l'URI de la requête HTPP
     * et renvoie un tableau contenant un nom de contrôleur
     * et un nom d'action correspondant à une méthode du contrôleur
     * 
     * ex : 
     * "/film/add" => [film, add] => filmController::action_add()
     * "/add" => [null, add] => indexController::action_add()
     * "/film/" => [film, null] => filmController::action_index()
     * 
     */
    public function getControllerAndMethodNames($requestURI) {
        $request = $requestURI;
        if ($request == null || $request[0] !== "/") {
            return array(null, null);
        }
        if (strpos($request, "../") !== false) {
            return array(null, null);
        }
        if ($pos = strpos($request, "?")) {
            $request = substr($request, 0, $pos);
        }
        if (($pos = strrpos($request, "/")) > 0) {
            $controllerName = substr($request, 1, $pos - 1);
            $controllerName = str_replace("/", "\\", $controllerName);
            $methodName = substr($request, $pos + 1);
        } else {
            $controllerName = null;
            $methodName = substr($request, 1);
        }
        return array($controllerName, $methodName);
    }
    
    





    public function run() {
        # valeurs par défauts :
        $defaultControllerName = "Index";
        $defaultMethodName = "index";
        $controllerFullQualifiedNameFormat = "\\controller\\%sController";
        $methodFullNameFormat = "action_%s";

        # récupération de la request uri :
        $requestURI = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";

        # appel méthode d'analyse de l'uri de request pour routage :
        list($controllerName, $methodName) = $this->getControllerAndMethodNames($requestURI);

        # affectation des valeurs par défaits si valeurs nulles retournées :
        if (! $controllerName) $controllerName = $defaultControllerName;
        if (! $methodName) $methodName = $defaultMethodName;
        
        # construction noms complets du contrôleur et de la méthode :
        $controllerFullQualifiedName = sprintf($controllerFullQualifiedNameFormat, $controllerName);
        $methodFullName = sprintf($methodFullNameFormat, $methodName);
        
        # instanciation contrôleur :
        if (! class_exists($controllerFullQualifiedName)) {
            throw new \Exception("controller not found ('$controllerFullQualifiedName')");
        }
        $controller = new $controllerFullQualifiedName();
        
        # si le contrôleur implémente l'interface LayoutAware, 
        # on appelle la méthode de préparation d'un objet Layout
        if ($controller instanceof LayoutAware) {
            $controller->prepareLayout();
        }
        
        # optional pre-processing "before" method :
        if (method_exists($controller, "before")) {
            $controller->before();
        }

        # appel de la methode correspondant à l'action:
        if (! method_exists($controller, $methodFullName)) {
            throw new \Exception("action not found");
        }
        $result = $controller->{$methodFullName}();
        
        # optional post-processing "after" method :
        if (method_exists($controller, "after")) {
            $controller->after();
        }

        # si le résultat est une Response (réponse Http), il n'y a plus qu'à l'envoyer :
        if ($result instanceof Response) {
            return $result->send();
        }

        # si le contrôleur implémente l'interface LayoutAware, 
        # on appelle le layout en espérant obtenir un objet Response
        if ($controller instanceof LayoutAware) {
            $result = $controller->renderLayout($result);
        }

        # si ce n'est toujours pas un obvjet response valide, on tente d'en créer un 
        if (! $result instanceof Response) {
            $result = new Response($result);
        }
        return $result->send();
    }
    
}
