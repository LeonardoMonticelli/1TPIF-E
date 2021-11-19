create or replace database wsers2;
use wsers2;

CREATE TABLE PPL (
    ID_PERSON int NOT NULL AUTO_INCREMENT,
    LastName varchar(50),
    FirstName varchar(50),
    Age int,
    primary key (ID_PERSON)
);

INSERT INTO PPL (LastName, FirstName, Age) VALUES
    ("John", "Wayne", 120),
    ("Bruce", "Lee", 90),
    ("Angelina", "Jolie", 40),
    ("John", "Doe", 0);



CREATE TABLE Products (
    PRODUCT_ID int NOT NULL AUTO_INCREMENT,
    ProductName varchar(50),
    Price int,
    primary key (PRODUCT_ID)
);

INSERT INTO Products (ProductName, Price) VALUES
    ("Blue shoes", 120),
    ("Yellow shoes", 10),
    ("Red shoes", 100),
    ("Brown shoes", 50),
    ("Green house", 5000),
    ("Little red ridinghood", 10000),
    ("Barbie", 1),
    ("Broken toy", 16),
    ("Car", 55000),
    ("Desk", 524),
    ("Computer", 123),
    ("Movie ticket", 1);