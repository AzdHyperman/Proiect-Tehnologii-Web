<?php

class Home extends Controller{

    public function index()
    {
        $this->view('home');
    }

    public function try2(){
        echo 'hello from try2';
    }
}