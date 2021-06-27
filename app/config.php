<?php

+$dev=$_SERVER['REMOTE_ADDR']==='127.0.0.1' ? true : false;
if($dev){
    $baza=[
        'server'=>'localhost',
        'baza'=>'specijalna__veterinarska_ambulanta_happyvet',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    
    ];
}else{
    $baza=[
        'server'=>'localhost',
        'baza'=>'xxxxx',
        'korisnik'=>'xxxxx',
        'lozinka'=>'xxxxx'
    ];
}
return [
    'url'=>'http://polaznik33.edunova.hr/',
    'nazivApp'=>'Happy Vet',
    'baza'=>$baza
];