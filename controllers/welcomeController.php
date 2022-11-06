<?php

class welcomeController extends Controller{

    public function index(){

        return $this->view('welcome.php');
    }

    public function test(){

        return $this->view('test.php');
    }
}
?>