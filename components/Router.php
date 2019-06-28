<?php

class Router
{

    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = include(ROOT . '/config/routes.php');
    }


    /**
     * @return string
     */
    private function getURI()
    {
        $uri = '';

        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI'], '/');
        }

        return $uri;
    }


    public function run()
    {
        $uri = $this->getURI() ? $this->getURI() : "index";

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);
                $controllerName = ucfirst(array_shift($segments) . 'Controller');
                $actionName = 'action' . (!$segments ? 'Index' : ucfirst(array_shift($segments)));
                $controllerFile = ROOT . "/controllers/" . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $contrellerObject = new $controllerName;

                $result = $contrellerObject->$actionName();
                if (!$result) {
                    echo $result;
                    break;
                }
            }
        }
    }
}