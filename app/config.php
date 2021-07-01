<?php

+$dev=$_SERVER['REMOTE_ADDR']==='127.0.0.1' ? true : false;
if($dev){
    $baza=[
        'server'=>'localhost',
        'baza'=>'happyvet',
        'korisnik'=>'edunova',
        'lozinka'=>'edunova'
    
    ];
}else{
    $baza=[
        'server'=>'localhost',
        'baza'=>'nikta_happyvet',
        'korisnik'=>'nikta_nikta',
        'lozinka'=>'ivan1986.'
    ];
}
return [
    'url'=>'http://polaznik33.edunova.hr/',
    'nazivApp'=>'Happy Vet',
    'baza'=>$baza,
    'rezultataPoStranici'=>4
];