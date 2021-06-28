<?php

class Pregled
{

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select * from pregled
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($pregled)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            insert into pregled (naziv,trajanje,cijena,placanje)
            values (:naziv,:trajanje,:cijena,:placanje)
        
        ');
        $izraz->execute((array)$pregled);
    }

}