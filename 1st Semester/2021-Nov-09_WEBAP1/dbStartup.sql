create database firstAjax;

use firstAjax;

CREATE TABLE Countries (
    CountryID int unique not null AUTO_INCREMENT,
    CountryName varchar(255) unique,
    PRIMARY KEY (CountryID)
);

create table Cities(
    CityId int unique not null AUTO_INCREMENT,
    CityName varchar(255) unique,
    PRIMARY KEY (CityId),
    Country int not null,
    FOREIGN KEY (Country) REFERENCES Countries(CountryID)
);

insert into Countries(CountryName) VALUES("Germany");
insert into Countries(CountryName) VALUES("France");
insert into Countries(CountryName) VALUES("Romania");
insert into Countries(CountryName) VALUES("UK");


insert into Cities(CityName,Country) VALUES("Hambourg",1);
insert into Cities(CityName,Country) VALUES("Berlin",1);
insert into Cities(CityName,Country) VALUES("Trier",1);

insert into Cities(CityName,Country) VALUES("Paris",2);
insert into Cities(CityName,Country) VALUES("Dijon",2);
insert into Cities(CityName,Country) VALUES("Nice",2);

insert into Cities(CityName,Country) VALUES("Bucharest",3);
insert into Cities(CityName,Country) VALUES("Cluj-Napoca",3);
insert into Cities(CityName,Country) VALUES("Iasi",3);

insert into Cities(CityName,Country) VALUES("London",4);
insert into Cities(CityName,Country) VALUES("York",4);
insert into Cities(CityName,Country) VALUES("Unknown",4);
