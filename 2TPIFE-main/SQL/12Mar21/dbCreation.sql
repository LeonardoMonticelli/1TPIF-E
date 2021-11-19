create or replace database wsers2;
use wsers2;

create table USERS(
    ID_PERSON int NOT NULL AUTO_INCREMENT,
    LastName varchar(50) NOT NULL,
    FirstName varchar(50) NOT NULL,
    Age int NOT NULL,
    Username varchar(20) NOT NULL UNIQUE,
    Pswd varchar(100) NOT NULL,
    primary key (ID_PERSON)
);

-- INSERT INTO USERS(LastName, FirstName, Age, Username, Pswd) VALUES(
--     ("Doe","Jhon",33,"Usertest","password")
-- );