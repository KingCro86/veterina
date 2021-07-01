<?php

class Ordinacija
{

    public static function ucitaj($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select * from ordinacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        $ordinacija= $izraz->fetch();

        $izraz=$veza->prepare('
        
        select b.sifra, c.ime, c.prezime 
        from osoblje a inner join radnik b
        on a.radnik =b.sifra 
        inner join osoba c on
        b.osoba =c.sifra 
        where a.ordinacija =:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
        $ordinacija->radnici = $izraz->fetchAll();

        return $ordinacija;
    }

    public static function ucitajSve()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            select b.naziv as pregled, a.naziv,
            concat(d.ime, \' \', d.prezime) as veterinar,
            a.datumpocetka, a.sifra, count(e.radnik) as radnika
            from ordinacija a inner join pregled b
            on a.pregled=b.sifra 
            left join veterinar c 
            on a.veterinar=c.sifra
            left join osoba d
            on c.osoba=d.sifra
            left join osoblje e
            on a.sifra=e.ordinacija
            group by b.naziv, a.naziv,
            concat(d.ime, \' \', d.prezime),
            a.datumpocetka, a.sifra 
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function dodajNovi($ordinacija)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            insert into ordinacija (naziv,pregled,veterinar,datumpocetka)
            values (:naziv,:pregled,:veterinar,:datumpocetka)
        
        ');
        $izraz->execute((array)$ordinacija);
        return $veza->lastInsertId();
    }

    public static function promjeniPostojeci($ordinacija)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
           update ordinacija set 
           naziv=:naziv,pregled=:pregled,
           veterinar=:veterinar,datumpocetka=:datumpocetka 
           where sifra=:sifra
        
        ');
        $izraz->execute((array)$ordinacija);
    }

    public static function obrisiPostojeci($sifra)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
            delete from ordinacija where sifra=:sifra
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
    }


}