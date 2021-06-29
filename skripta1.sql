# c:\xampp\mysql\bin\mysql -uedunova -pedunova <D:\pp22\polaznik33.edunova.hr\skripta1.sql
drop database if exists happyvet;
create database happyvet character set utf8mb4;
use happyvet;

alter database nikta_happyvet default character set utf8mb4;


create table operater(
    sifra int not null primary key auto_increment,
    email varchar(50) not null,
    lozinka char(60) not null,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    uloga varchar(10) not null
);
# lozinka je i
insert into operater values(null,'ivan.puhovski@hotmail.com',
'$2y$10$6ZPMQsSKUNkeDL8elh.cluD4eQtCfMrb2rzrGPNq88vomgqMGbHQq',
'Ivan','Puhovski','admin');
# lozinka je k
insert into operater values(null,'king86@edunova.hr',
'$2y$10$sgpLyFe/CDE1s8fclSngU.TCScIDRBh1uUZOhRXpZByhChZ8I0yGe',
'King','Edunova','oper');

create table pregled(
    sifra int not null primary key auto_increment,
    naziv varchar(60) not null,
    trajanje int not null,
    cijena decimal(18,2),
    placanje boolean
);

create table ordinacija(
    sifra int not null primary key auto_increment,
    naziv varchar(20) not null,
    pregled int not null, # FK
    veterinar int, #FK
    datumpocetka datetime,
    brojradnika int
);

create table osoba(
    sifra int not null primary key auto_increment,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    oib char(11),
    email varchar(50) not null
);
create table veterinar(
    sifra int not null primary key auto_increment,
    osoba int not null, #FK
    iban varchar(50)
);
create table radnik(
    sifra int not null primary key auto_increment,
    osoba int not null, #FK
    brojugovora varchar(20)
);

create table osoblje(
    ordinacija int not null, #FK
    radnik int not null #FK
);

alter table ordinacija add foreign key (pregled) references pregled (sifra);
alter table ordinacija add foreign key (veterinar) references veterinar(sifra);

alter table veterinar add foreign key (osoba) references osoba(sifra);
alter table radnik add foreign key (osoba) references osoba(sifra);

alter table osoblje add foreign key (ordinacija) references ordinacija(sifra);
alter table osoblje add foreign key (radnik) references radnik(sifra);

#1
insert into pregled (sifra,naziv,trajanje,cijena,placanje)
values (null,'Osnovni pregled',10,null,true);

insert into pregled (sifra,naziv,trajanje,cijena,placanje)
values (null,'operativni zahvat',30,null,true);

#2
insert into osoba(sifra,ime,prezime,oib,email)
values (null,'Marija','Arnautović',null,'marija,arnautovic@happyvet.hr'),
       (null,'Petar','Varivoda',null,'varivoda.p@happyvet.hr'),
       (null,'Kristian','Lugar',null,'kiki.lugar@happyvet.hr'),
       (null,'Josipa','Bobek',null,'josipa.bobek@happyvet.hr'),
       (null,'Mario','Šipek',null,'mario.sipek@happyvet.hr'),
       (null,'Albert','Finta',null,'albert.finta.happyvet.hr'),
       (null,'Marina','Finta',null,'marina.finta@happyvet.hr');
      
#3

insert into veterinar (sifra,osoba,iban)
values (null,6,null),(null,7,null);

#4

insert into ordinacija (sifra,naziv,pregled,veterinar,datumpocetka,brojradnika)
values (null,'Srce',1,1,'2021-06-06 14:00:00',5);

insert into ordinacija (sifra,naziv,pregled,veterinar,datumpocetka,brojradnika)
values (null,'Oblak',2,2,'2021-06-06 13:00:00',5);

#5

insert into radnik (sifra,osoba,brojugovora)
values (null,1,null),(null,2,null),(null,3,null),(null,4,null),(null,5,null);

#6

insert into osoblje (ordinacija,radnik)
values (1,1),(1,2),(1,3),(1,4),(1,5);

update ordinacija set veterinar=1 where sifra=1;
