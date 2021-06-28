<?php

class Pregled
{

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select * from pregled where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        return $izraz->fetch();
    }

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

    public static function promjeniPostojeci($pregled)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
           update pregled set 
           naziv=:naziv,trajanje=:trajanje,
           cijena=:cijena,placanje=:placanje
           where sifra=:sifra
        
        ');
        $izraz->execute((array)$pregled);
    }

}