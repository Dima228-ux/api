<?php

/**
 * Class Router
 */
class Router
{
    private $url;

    /**
     * Router constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return void
     */
    public function route()
    {
        $urlParts = explode("/", $this->url);
        if ($urlParts[1] == "") {
            $controllerName = "GroupController";
            $actionName = "index";
        } else {
            $controllerName = ucfirst($urlParts[1]) . "Controller";
            $actionName = explode("?", $urlParts[2])[0] . "Action";
        }

        $controllerPath = "./controllers/" . ucfirst($controllerName) . ".php";

        if (file_exists($controllerPath) === false) {
            echo json_encode(['status' => '404', 'message' => 'Error 404']);
            die();
        }


        require_once $controllerPath;

        $controller = new $controllerName;
        $action = $actionName;

        if (method_exists($controller, $action) == false) {
            echo json_encode(['status' => '404', 'message' => 'Error 404']);
            die();
        }

        $controller->$action();
    }
}