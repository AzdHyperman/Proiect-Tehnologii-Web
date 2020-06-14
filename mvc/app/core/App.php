<?php

class App{

    protected $controller = 'BookController';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){
        //print_r($_GET);
        
        $url = $this->parseUrl();

        /*$database = new Database();
        $db = $database->connect();
        */

        if(isset($url[0])){
            if(file_exists('../app/controllers/' . $url[0] . '.php'))
            {
                $this->controller = $url[0];
                unset($url[0]);
                #stergem $url[0] din $_GET
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller,$url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url? array_values($url) : [] ;
        #initializam cu un obiect null daca nu exista parametri
        #altfel array_values va da eroare

        call_user_func_array([$this->controller, $this->method],$this->params);
    }

    public function parseUrl(){
        if(isset($_GET['url']))
            return $url = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
    }


}