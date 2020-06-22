<?php

class Controller{
    protected function model($model){
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }

    public function view($view,$data = []){
        require_once __DIR__.'/../views/' . $view . '.php';
    }
}