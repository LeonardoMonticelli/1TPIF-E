--1
CREATE TABLE BOOKS(
    ISBN int NOT NULL,
    ID_Author int NOT NULL ,
    ID_Publisher int NOT NULL,
    Title varchar(50),
    B_year number(4),
    Price int NOT NULL,
    Code_w int NOT NULL
)

CREATE TABLE WAREHOUSES(
    CODE int NOT NULL,
    W_Address varchar(100),
    W_Phone number(9)
)

CREATE TABLE STOCK(
    Title varchar(50),
    Number_Copies int NOT NULL,
    Code_w int NOT NULL,
)

CREATE TABLE CUSTOMERS(
    C_ID int NOT NULL,
    First_Name varchar(50),
    Last_Name varchar(50),
    C_Address varchar(100),
    C_Email varchar(50),
    C_Phone number(9)
)

CREATE TABLE PUBLISHERS(
    P_Name varchar(50),
    P_Address varchar(50),
    P_Phone number(9),
    P_URL varchar(100)
)

INSERT ALL
    INTO BOOKS(Title, ISBN, B_year, price, ID_Author, ID_Publisher, Code_w) VALUES('THE GIRL ON THE TRAIN',23890001,2010,31.00,2356,2561789,720)
    INTO BOOKS(Title, ISBN, B_year, price, ID_Author, ID_Publisher, Code_w) VALUES('SWORD CATCHER',56783975,2018,45.00,1357,3489015,730)
    INTO BOOKS(Title, ISBN, B_year, price, ID_Author, ID_Publisher, Code_w) VALUES('INTO THE WATER',25677890,2012,28.70,2356,3489015,730)
    INTO BOOKS(Title, ISBN, B_year, price, ID_Author, ID_Publisher, Code_w) VALUES('CHAIN OF IRON',34165789,2019,25.90,1357,2561789,720)
    INTO BOOKS(Title, ISBN, B_year, price, ID_Author, ID_Publisher, Code_w) VALUES('NEVER',45673219,2021,60.89,2289,3489015,730)
    INTO BOOKS(Title, ISBN, B_year, price, ID_Author, ID_Publisher, Code_w) VALUES('THE REUNION',34512347,2015,35.28,2356,3489015,720)
select 1 from dual;

INSERT ALL
    INTO WAREHOUSES(CODE, W_Address, W_Phone) VALUES(720,'Luxembourg, 56',352621778)
    INTO WAREHOUSES(CODE, W_Address, W_Phone) VALUES(730,'London, 43',456728190)
select 1 from dual;


INSERT ALL
    INTO AUTHORS(A_ID,First_Name,Last_Name,A_Address,A_URL) VALUES(2289,'KEN','FOLLETT','Cardiff, 56','https://ken-follett.com/')
    INTO AUTHORS(A_ID,First_Name,Last_Name,A_Address,A_URL) VALUES(1357,'CASSANDRA','CLARE','London, 123','https://www.cassandraclare.com/')
    INTO AUTHORS(A_ID,First_Name,Last_Name,A_Address,A_URL) VALUES(2356,'PAULA','HAWKINS','London,345','http://paulahawkinsbooks.com/')
select 1 from dual;

INSERT ALL
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('THE GIRL ON THE TRAIN',23,730)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('SWORD CATCHER',3,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('INTO THE WATER',34,730)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('CHAIN OF IRON',6,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('NEVER',4,730)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('THE REUNION',5,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('THE GIRL ON THE TRAIN',9,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('SWORD CATCHER',15,730)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('INTO THE WATER',0,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('CHAIN OF IRON',1,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('NEVER',5,720)
    INTO STOCK(Title, Number_Copies, Code_w) VALUES('THE REUNION',0,730)
select 1 from dual;

INSERT ALL
    INTO CUSTOMERS(C_ID,First_Name,Last_Name,C_Address,C_Email,C_Phone) VALUES(120,'JACK','SMITH','Route de Luxembourg, Luxembourg,14B','jsmith@post.lu',621867564)
    INTO CUSTOMERS(C_ID,First_Name,Last_Name,C_Address,C_Email,C_Phone) VALUES(130,'NOAH','AUDRY','JFK, 23, Luxembourg','naudry@post.lu',621456321)
    INTO CUSTOMERS(C_ID,First_Name,Last_Name,C_Address,C_Email,C_Phone) VALUES(125,'RHONDA','TAYLOR','Belval, 35','rtaylor@online.lu',621890564)
    INTO CUSTOMERS(C_ID,First_Name,Last_Name,C_Address,C_Email,C_Phone) VALUES(341,'ROBERT','BEN','Luxembourg, 2566','rben@london.uk',621867778)
    INTO CUSTOMERS(C_ID,First_Name,Last_Name,C_Address,C_Email,C_Phone) VALUES(143,'JEANNE','BEN','London, 2341','jben@london.uk',621867555)
    INTO CUSTOMERS(C_ID,First_Name,Last_Name,C_Address,C_Email,C_Phone) VALUES(242,'MILLS','CARMEN','Belval, 45','mcarmen@post.lu',621866561)
select 1 from dual;

INSERT ALL
    INTO PUBLISHERS(P_Name,P_Address,P_Phone,P_URL) VALUES('CAMBRIDGE UNIVERSITY PRESS','Cambridge CB2 8BS United Kingdom',1223358331,'https://www.cambridge.org/core/login')
    INTO PUBLISHERS(P_Name,P_Address,P_Phone,P_URL) VALUES('HACHETTE','59893 Lille Cedex, 9',0160396514,'https://www.hachette-collections.com/fr-fr/')
    INTO PUBLISHERS(P_Name,P_Address,P_Phone,P_URL) VALUES('HUEBER','D-80973 München',49899602,'https://www.hueber.de/')
select 1 from dual;

--4
select * from customer where first_name = 'Jack' and last_name = 'Smith';
--5
select * from books where title = 'THE GIRL ON THE TRAIN';
--6
select * from customer ORDER BY last_name ASC;
--7
select * from books b LEFT JOIN authors a ON b.id_authors = a.id where first_name = 'Paula' and last_name = 'Hawkins';
--8
select * from stock where code_w = 720;
--9
select * from books where year > 2018;
--10
select title, isbn, first_name, last_name from books NATURAL JOIN authors;
--11
select b.title, b.isbn, a.first_name, a.last_name from books b LEFT JOIN authors a ON b.id_authors = a.id;
--12
select * from books NATURAL JOIN warehouse;
--13
select * from books b LEFT JOIN warehouse w ON b.code_w = w.code;
--14
select w.* from stock s LEFT JOIN warehouse w ON s.code_w = w.code where title = 'INTO THE WATER' and number_copies = 0;
--15
select SUM(number_copies) from stock where title = 'SWORD CATCHER'
--16
select w.* from stock s LEFT JOIN warehouse w ON s.code_w = w.code where title = 'INTO THE WATER' and number_copies = 0;
--17
select b.* from books b LEFT JOIN stock s ON b.title = s.title where s.number_copies= 0;
--18
select * from books b LEFT JOIN warehouse w ON b.code_w = w.code LEFT JOIN stock s ON w.code = s.code_w where s.number_copies = 0;
--19
select * from books where price > 30;
--20
select (price+(price/100*10)) "New_Price" from books where code_w = 720;