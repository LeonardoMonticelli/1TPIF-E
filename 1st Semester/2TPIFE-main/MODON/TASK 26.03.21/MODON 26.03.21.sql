CREATE TABLE P_CONTRACT(
    Signing_date not null date,
    Expiration_date not null date,
    Contract_description varchar(100)
)

CREATE TABLE COMPANY(
    Company_name varchar(50) NOT NULL,
    Company_Address varchar(50) NOT NULL,
    Telephone_Number number(9) NOT NULL,
)

CREATE TABLE PHARMACY(
    Pharmacy_name varchar(50) NOT NULL,
    Pharmacy_Address varchar(50) NOT NULL,
    Telephone_Number number(9) NOT NULL,
)

CREATE TABLE DRUG(
    Drug_name varchar(50) NOT NULL,
    Composition varchar(50) NOT NULL,
    Price int NOT NULL,
    primary key (Drug_name)
)

CREATE TABLE DOCTOR(
    Doctor_name varchar(50) NOT NULL,
    Speciality varchar(50) NOT NULL,
    Years_of_exp int NOT NULL,
    ID_Doctor int NOT NULL,
    primary key (ID_Doctor)
)

CREATE TABLE PATIENT(
    Patient_name varchar(50) NOT NULL,
    Patient_address varchar(50) NOT NULL,
    Age int NOT NULL,
    ID_Patient int NOT NULL,
    primary key (ID_Doctor)
)

CREATE TABLE PHARMACY(
    Issued_date date NOT NULL,
    Drug_list varchar NOT NULL,
    Required_amout int NOT NULL, 
    ID_Doctor int NOT NULL,
    Doctor_name varchar(50) NOT NULL,
    ID_Patient int NOT NULL,
    Patient_name varchar(50) NOT NULL,
    foreign key (ID_Doctor) references DOCTOR(ID_Doctor),
    foreign key (Doctor_name) references DOCTOR(Doctor_name),
    foreign key (ID_Patient) references PATIENT(ID_Patient),
    foreign key (Patient_name) references PATIENT(Patient_name),
)
