<?php

class VeterinarController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'veterinar'
                        . DIRECTORY_SEPARATOR;
    
    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>Veterinar::ucitajSve()
        ]);
    }

  

}