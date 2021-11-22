create database cars;

use cars;

create table Cars(
    CarId int unique not null AUTO_INCREMENT,
    CarName varchar(50),
    CarPrice int,
    CarDescription varchar(255),
    CarImage varchar(50),
    PRIMARY KEY (CarId)
);

Insert into Cars(CarName,CarPrice,CarDescription,CarImage) Values("Dacia",5000,"Good economical car","dacia.jpg");
Insert into Cars(CarName,CarPrice,CarDescription,CarImage) Values("BMW",75000,"Nice car","bmw.jpg");
Insert into Cars(CarName,CarPrice,CarDescription,CarImage) Values("Skoda",40000,"Perfect equilibrium between price and performance","skoda.jpg");
Insert into Cars(CarName,CarPrice,CarDescription,CarImage) Values("Volvo",100000,"Safe car","volvo.jpg");
