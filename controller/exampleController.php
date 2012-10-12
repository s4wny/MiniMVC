<?php

class exampleController extends mainController
{
    function __construct()
    {
        parent::__construct();
        
        $this->exampleM = $this->load->model('exampleModel');
        
        //Ingen speciell funktion önskad, ladda viewn
        if($_SERVER['QUERY_STRING'] == null) {
            $this->load->view("exampleView");
        }
    }
    
    function hello($name = "world")
    {
        $this->load->view("exampleView", array('name' => $name));
    }
    
    function profile($name = null)
    {
        if($name == null) {
            $data = array('error' => 'Ange ett namn');
        }
        else {
            $data = $this->exampleM->getProfile(strtolower($name));
        }
        
        $this->load->view("exampleView", $data);
    }
}

?>