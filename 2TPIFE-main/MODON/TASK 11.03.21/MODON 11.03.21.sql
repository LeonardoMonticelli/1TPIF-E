CREATE TABLE CUSTOMER(
    ID_PERSON int NOT NULL,
    ID_Email int NOT NULL,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    CustomerAddress varchar(50) NOT NULL,
    PhoneNumber number(9) NOT NULL,
    CurrentBalance money(9) NOT NULL,
    Team number,
    primary key (ID_PERSON)
)

CREATE TABLE ORDER(
    ID int NOT NULL,
    DateOrder date NOT NULL,
    TimeOrder time NOT NULL,
    ItemsPurchased int NOT NULL,
    Price number(9) NOT NULL,
    NumOfUnits number(2) NOT NULL,
    TotalOrderPrice number(9) NOT NULL,
    ItemSize number ,
    Color varchar(20),
    primary key(ID)
)

CREATE TABLE ITEM(
    ID_Number int NOT NULL,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    ItemDescription varchar(50) NOT NULL,
    Price number(9) NOT NULL,
    Category varchar(50) NOT NULL,
    Color varchar(50) NOT NULL,
    Size varchar(50),
    primary key(ID_Number) 
)

CREATE TABLE INVENTORY(
    ID_List int NOT NULL,
    CostOfUnit int NOT NULL,
    Unit int NOT NULL,
    primary key(ID_List)
)

CREATE TABLE TEAM(
    ID_Team int NOT NULL,
    TeamName varchar(50) NOT NULL,
    NumOfPlayers int NOT NULL,
    Discount int,
    primary key(ID_Team)
)

CREATE TABLE SALES_REP(
    ID_Rep int NOT NULL,
    ID_Email NOT NULL,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    Address varchar(50) NOT NULL,
    PhoneNumber number(9) NOT NULL,
    Discount int,
    primary key(ID_Rep)
)

INSERT INTO TEAM(ID_Team,TeamName,NumOfPlayers,Discount) VALUES(
    ("ID1","JhonDoe'sTeam",6,33%)
)