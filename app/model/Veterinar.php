<?php

class Veterinar
{

    public static function ucitajSve()
    {

        $veza = DB::getInstanca();
        $izraz=$veza->prepare('
        
        select a.sifra, a.iban,b.ime,b.prezime,
        b.oib,b.email, count(c.sifra) as ukupnoordinacija from veterinar a 
        inner join osoba b on a.osoba =b.sifra 
        left join ordinacija c on a.sifra =c.veterinar 
        group by a.sifra, a.iban,b.ime,b.prezime,
        b.oib,b.email;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();


    }


    public static function dodajNovi($entitet)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz=$veza->prepare('
        
            insert into osoba 
            (ime, prezime, email, oib) values
            (:ime, :prezime, :email, :oib)
            
        ');
        $izraz->execute([
            'ime'=>$entitet->ime,
            'prezime'=>$entitet->prezime,
            'email'=>$entitet->email,
            'oib'=>$entitet->oib
        ]);
        $zadnjaSifra=$veza->lastInsertId();
        $izraz=$veza->prepare('
        
            insert into veterinar 
            (osoba, iban) values
            (:osoba, :iban)
        
        ');
        $izraz->execute([
            'osoba'=>$zadnjaSifra,
            'iban'=>$entitet->iban
        ]);

        $veza->commit();
    }





}