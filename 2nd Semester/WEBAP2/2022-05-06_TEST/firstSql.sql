drop database countries;
create database countries;
use countries;


CREATE TABLE Countries (
    CountryID int not null AUTO_INCREMENT,
    CountryName varchar(255),
    PRIMARY KEY (CountryID)
);


CREATE TABLE Cities (
    CityId int not null AUTO_INCREMENT,
    CityName varchar(255) unique,
    Inhabitants int,
    CountryID int not null,
    PRIMARY KEY (CityId),
    FOREIGN KEY (CountryID) REFERENCES Countries(CountryID)
);


INSERT INTO Countries (CountryName) VALUES("Luxembourg");
INSERT INTO Countries (CountryName) VALUES("France");
INSERT INTO Countries (CountryName) VALUES("Germany");
INSERT INTO Countries (CountryName) VALUES("Romania");


INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Luxembourg",1,100);
INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Esch",1,50);

INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Paris",2,1000);
INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Dijon",2,500);

INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Berlin",3,1500);
INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Frankfurt",3,500);

INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Bucharest",4,500);
INSERT INTO Cities (CityName,CountryID,Inhabitants) VALUES("Cluj-Napoca",4,50);