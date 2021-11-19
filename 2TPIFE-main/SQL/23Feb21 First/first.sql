create or replace database wsers2;
use wsers2;

CREATE TABLE PPL(
    ID_PERSON int NOT NULL AUTO_INCREMENT,
    FirstName varchar(50),
    LastName varchar(50),
    Age int,
    primary key (ID_PERSON)
);

INSERT INTO PPL (LastName, FirstName,Age) VALUES(
    ("Perez","Pepe",32),
);