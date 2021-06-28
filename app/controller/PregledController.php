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
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $pregled = new stdClass();
            $pregled->naziv='';
            $pregled->trajanje=10;
            $pregled->cijena=1000;
            $pregled->placanje='0';
            $this->view->render($this->viewDir . 'novo',[
                'pregled'=>$pregled,
                'poruka'=>'Popunite sve podatke'
            ]);
            return;
        }


        $pregled = (object) $_POST;

        if(strlen(trim($pregled->naziv))===0){
            $this->view->render($this->viewDir . 'novo',[
                'pregled'=>$pregled,
                'poruka'=>'Naziv obavezno'
            ]);
            return;
        }



       
    }

}