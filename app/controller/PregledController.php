<?php

class PregledController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'pregled'
                        . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'pregledi'=>Pregled::ucitajSve()
        ]);
    }

    public function novo()
    {
        $this->view->render($this->viewDir . 'novo');
    }

}