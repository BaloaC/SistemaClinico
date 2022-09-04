<?php

class homepageController extends Controller{

    public function index(){

        return $this->view('homepage.php', ['welcome' => ['Hello' => 'Hello', 'Hi' => 'Hi']]);
    }
}
?>