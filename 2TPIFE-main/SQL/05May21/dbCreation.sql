drop database wsers2;

CREATE database wsers2;
use wsers2;

CREATE TABLE COUNTRIES (
    C_ID int not null AUTO_INCREMENT,
    C_Name varchar(50) UNIQUE,
    C_Population int,
    primary key (C_ID)
);

CREATE TABLE PEOPLE (
    P_ID int NOT NULL AUTO_INCREMENT,
    LName varchar(50),
    FName varchar(50),
    UsrName varchar(20) NOT NULL UNIQUE,
    Psw varchar(100) NOT NULL,
    primary key (P_ID),
    C_ID int,
    UserRole varchar(10),
        foreign key (C_ID) references COUNTRIES(C_ID)
        ON DELETE SET NULL
);

CREATE TABLE PRODUCTS(
    Pr_ID int not null AUTO_INCREMENT,
    Pr_Name varchar(50),
    Pr_Price int,
    Pr_ItemsInStock int,
    primary key (Pr_ID)
);

CREATE TABLE ORDERSTATUS(
    Status_ID int not null AUTO_INCREMENT,
    Order_Status varchar(20),
    primary key (Status_ID)
);

CREATE TABLE ORDERS(
    PersonID int, 
    O_ID int not null AUTO_INCREMENT,
    Order_Status int not null,
    primary key (O_ID),
    foreign key (PersonID) references PEOPLE(P_ID),
    foreign key (Order_Status) references ORDERSTATUS(Status_ID)
);


insert into ORDERSTATUS(Order_Status) values("Order sent");
insert into ORDERSTATUS(Order_Status) values("Order processed");
insert into ORDERSTATUS(Order_Status) values("Order in transit");
insert into ORDERSTATUS(Order_Status) values("Order delivered");

CREATE TABLE ORDERCONTENTS(
    OC_ID int not null AUTO_INCREMENT,
    OrderID int,
    ItemToBuy int,
    HowMany int,
    primary key (OC_ID),
    foreign key (OrderID) references ORDERS(O_ID),
    foreign key (ItemToBuy) references PRODUCTS(Pr_ID)
);

Insert into COUNTRIES(C_Name, C_Population) values ("Luxembourg", 250000);
Insert into PRODUCTS(Pr_Name, Pr_Price, Pr_ItemsInStock) values ("Potato", 69, 420);