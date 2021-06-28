<?php

class PregledController extends AutorizacijaController
{
    private $viewDir = 'privatno'
                        . DIRECTORY_SEPARATOR
                        . 'pregled'
                        . DIRECTORY_SEPARATOR;

    private $pregled=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
            'pregledi'=>Pregled::ucitajSve()
        ]);
    }

    public function novo()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $this->noviPregled();
            return;
        }

        $this->pregled = (object) $_POST;
        if(!$this->kontrolaNaziv()){return;}
        if(!$this->kontrolaTrajanje()){return;}
        if(!$this->kontrolaCijena()){return;}
        Pregled::dodajNovi($this->pregled);
        $this->index();
    }

    public function promjena()
    {
        if($_SERVER['REQUEST_METHOD']==='GET'){
            if(!isset($_GET['sifra'])){
               $ic = new IndexController();
               $ic->logout();
               return;
            }
            $this->pregled = Pregled::ucitaj($_GET['sifra']);
            $this->poruka='Promjenite željene podatke';
            $this->promjenaView();
            return;
        }
        $this->pregled = (object) $_POST;
        if(!$this->kontrolaNaziv()){return;}
        if(!$this->kontrolaTrajanje()){return;}
        // neću odraditi na promjeni kontrolu cijene
        Pregled::promjeniPostojeci($this->pregled);
        $this->index();
        }

        public function brisanje()
        {
            if(!isset($_GET['sifra'])){
                $ic = new IndexController();
                $ic->logout();
                return;
            }
            Pregled::obrisiPostojeci($_GET['sifra']);
            header('location: ' . App::config('url') . 'pregled/index');
           
        }
      
        private function noviPregled()
        {
            $this->pregled = new stdClass();
            $this->pregled->naziv='';
            $this->pregled->trajanje=10;
            $this->pregled->cijena=1000;
            $this->pregled->placanje='0';
            $this->poruka='Unesite tražene podatke';
            $this->novoView();
        }
       
        private function novoView()
        {
            $this->view->render($this->viewDir . 'novo',[
                'pregled'=>$this->pregled,
                'poruka'=>$this->poruka
            ]);
        }
    
        private function promjenaView()
        {
            $this->view->render($this->viewDir . 'promjena',[
                'pregled'=>$this->pregled,
                'poruka'=>$this->poruka
            ]);
        }
    
    
        private function kontrolaNaziv()
        {
            if(strlen(trim($this->pregled->naziv))===0){
                $this->poruka='Naziv obavezno';
                $this->novoView();
                return false;
             }
     
             if(strlen(trim($this->pregled->naziv))>50){
                $this->poruka='Naziv ne može imati više od 50 znakova';
                $this->novoView();
                return false;
             }
             return true;
        }

        private function kontrolaTrajanje()
        {
            if(!is_numeric($this->pregled->trajanje)
                || ((int)$this->pregled->trajanje)<=0){
                    $this->poruka='Trajanje mora biti cijeli pozitivni broj';
                $this->novoView();
                return false;
          }
             return true;
        }
        
        private function kontrolaCijena()
        {
            $this->pregled->cijena=str_replace(',','.',$this->pregled->cijena);
        if(!is_numeric($this->pregled->cijena)
              || ((float)$this->pregled->cijena)<=0){
                $this->poruka='Cijena mora biti pozitivni broj';
              $this->novoView();
              return false;
        }
         return true;
    }

      

   
}