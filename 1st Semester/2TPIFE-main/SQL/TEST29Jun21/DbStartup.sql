drop database WSERS2_TEST;
create database WSERS2_TEST;
use WSERS2_TEST;

Create table Products (
    ID_Product int not null AUTO_INCREMENT,
    ProductName varchar(50),
    ItemsAvailable int,  
    primary key (ID_Product)
);
 
Create table Orders (
    ID_Order int not null AUTO_INCREMENT,
    primary key (ID_Order),
    NameOfBuyer VARCHAR(20),
    OrderItem int,
    HowMany int,
    foreign key (OrderItem) references Products(ID_Product)
);

insert into Products(ProductName, ItemsAvailable) values('Shoes', 5);
insert into Products(ProductName, ItemsAvailable) values('Jeans', 4);
insert into Products(ProductName, ItemsAvailable) values('Jacket', 2);
