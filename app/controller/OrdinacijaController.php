<?php


class OrdinacijaController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'ordinacija'
                        . DIRECTORY_SEPARATOR;
    
    private $entitet=null;
    private $poruka='';
    private $pregledi=null;
    private $veterinari=null;

    public function __construct()
    {
        parent::__construct();
        $this->pregledi=Pregled::ucitajSve();
        
        $s=new stdClass();
        $s->sifra=-1;
        $s->naziv='Odaberite pregled';
        array_unshift($this->pregledi,$s);


        $this->veterinari=Veterinar::ucitajSve();
        $s=new stdClass();
        $s->sifra=-1;
        $s->ime='Odabrite';
        $s->prezime='Veterinara';
        array_unshift($this->veterinari,$s);
    }

    public function index()
    {

        $ordinacije=Ordinacija::ucitajSve();

        foreach($ordinacije as $o){
            //https://www.php.net/manual/en/datetime.format.php
            $o->datumpocetka=date('d.m.Y. H:i', strtotime($o->datumpocetka));
            if($o->veterinar==null){
                $o->veterinar='[nije postavljeno]';
            }
        }

        $this->view->render($this->viewDir . 'index',[
            'entiteti'=>$ordinacije
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->noviEntitet();
            return;
        }
        $this->entitet = (object) $_POST;
        try {
            $this->kontrola();
            $zadnjaSifraOrdinacije=Ordinacija::dodajNovi($this->entitet);
            header('location: ' . App::config('url') . 
            'grupa/promjena?sifra=' . $zadnjaSifraOrdinacije);
        } catch (Exception $e) {
            $this->poruka=$e->getMessage();
            $this->novoView();
        }       
    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['sifra'])){
               $ic = new IndexController();
               $ic->logout();
               return;
            }
            $this->entitet = Ordinacija::ucitaj($_GET['sifra']);
            $datum=date('Y-m-d\TH:i', strtotime($this->entitet->datumpocetka));
            $this->entitet->datumpocetka=$datum;
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }
        $this->entitet = (object) $_POST;
        try {
            $this->kontrola();
            Ordinacija::promjeniPostojeci($this->entitet);
            $this->index();
        } catch (Exception $e) {
            $this->poruka=$e->getMessage();
            $this->promjenaView();
        }       
    }


    public function brisanje()
    {
        if(!isset($_GET['sifra'])){
            $ic = new IndexController();
            $ic->logout();
            return;
        }
        Ordinacija::obrisiPostojeci($_GET['sifra']);
        header('location: ' . App::config('url') . 'ordinacija/index');
       
    }

    public function dodajradnika()
    {
        Ordinacija::dodajRadnika();
        echo 'OK';
    }

    public function obrisiradnika()
    {
        Ordinacija::obrisiRadnika();
        echo 'OK';
    }







    

    private function noviEntitet()
    {
        $this->entitet = new stdClass();
        $this->entitet->naziv='';
        $this->entitet->pregled=-1;
        $this->entitet->veterinar=-1;
        $this->entitet->datumpocetka=date('Y-m-d\TH:i');;
        $this->poruka='Unesite tražene podatke';
        $this->novoView();
    }

    private function promjenaView()
    {
        $this->view->render($this->viewDir . 'promjena',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka,
            'pregledi'=>$this->pregledi,
            'veterinari'=>$this->veterinari,
            'css'=>'<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">',
            'js'=>'<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script src="' . App::config('url') . 'public/js/ordinacija/promjena.js"></script>'
        ]);
        
    }


    private function novoView()
    {
        $this->view->render($this->viewDir . 'novo',[
            'entitet'=>$this->entitet,
            'poruka'=>$this->poruka,
            'smjerovi'=>$this->pregledi,
            'predavaci'=>$this->veterinari
        ]);
    }

    private function kontrola()
    {
        $this->kontrolaNaziv();
        $this->kontrolaPregled();
        $this->kontrolaVeterinar();
    }

    private function kontrolaNaziv()
    {
        if(strlen(trim($this->entitet->naziv))==0){
            throw new Exception('Naziv obavezno');
        }

        if(strlen(trim($this->entitet->naziv))>20){
            throw new Exception('Naziv predugačko');
        }
    }

    private function kontrolaPregled()
    {
        if($this->entitet->pregled==-1){
            throw new Exception('Pregled obavezno');
        }
    }

    private function kontrolaVeterinar()
    {
        if($this->entitet->veterinar==-1){
            throw new Exception('Veterinar obavezno');
        }
    }



}