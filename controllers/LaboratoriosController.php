<?php

class LaboratoriosController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('laboratorios/index');
    }

}