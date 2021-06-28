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
           // $this->view->render($this->viewDir . 'novo',[
                //'pregled'=>$pregled,
               // 'poruka'=>'Popunite sve podatke'
            //]);
            $this->novoView($pregled,'Popunite sve podatke');
            return;
        }


        $pregled = (object) $_POST;

        if(strlen(trim($pregled->naziv))===0){
            //$this->view->render($this->viewDir . 'novo',[
                //'pregled'=>$pregled,
                //'poruka'=>'Naziv obavezno'
            //]);
            $this->novoView($pregled,'Naziv obavezno');
            return;
        }

        if(strlen(trim($pregled->naziv))>50){
            $this->novoView($pregled,'Naziv ne može imati više od 50 znakova');
            return;
        }
        
        if(!is_numeric($pregled->trajanje)
            || ((int)$pregled->trajanje)<=0){
            $this->novoView($pregled,'Trajanje mora biti cijeli pozitivni broj');
            return;
      }

      $pregled->cijena=str_replace(',','.',$pregled->cijena);
      if(!is_numeric($pregled->cijena)
            || ((float)$pregled->cijena)<=0){
            $this->novoView($pregled,'Cijena mora biti pozitivni broj');
            return;
      }

      // npr. svojstvu verificiran ne treba kontrola

      // ovdje sam siguran da je sve OK prije odlaska u bazu
      Pregled::dodajNovi($pregled);
      $this->index();
       
    }

    private function novoView($pregled, $poruka)
    {
        $this->view->render($this->viewDir . 'novo',[
            'pregled'=>$pregled,
            'poruka'=>$poruka
        ]);
    }
}