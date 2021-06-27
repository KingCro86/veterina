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

}