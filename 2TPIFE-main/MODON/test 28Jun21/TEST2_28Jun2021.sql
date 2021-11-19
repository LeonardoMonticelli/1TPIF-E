--SA2:
--Exercise A:
--1
    create table EMPL_NEW(
        EMPLOYEE_ID number(6),
        FIRST_NAME  VARCHAR2(20),
        LAST_NAME VARCHAR(25),
        HIRE_DATE DATE,
        JOB_ID VARCHAR2(10),
        SALARY NUMBER(8),
        BONUS VARCHAR2(5),
        MANAGER_ID NUMBER(4),
        LOCATION_ID NUMBER(4) ,
        PRIMARY KEY (EMPLOYEE_ID)
    )

    INSERT ALL
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(300,'Steven','King','17-Jun-87','PRES',24000,200,101,20)
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(101,'Neena','Kochhar','21-Sep-89','VP',17000,100,100,50)
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(102,'Lex','Haan','13-Jan-93','VP',17000,NULL,100,50)
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(103,'Jill','Miller','17-Sep-87','VP',4400,300,100,50)
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(505,'James','Borg','07-Jan-94','MAN',12000,500,102,80)
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(206,'Lynn','Brown','07-Jun-94','ACCOUNT',8300,100,105,90)
        INTO EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(500,'Curtis','Hugh','29-Jan-98','MAN',10500,NULL,104,80)
    SELECT 1 FROM DUAL;
--2
    create table LOC_NEW(
        LOCATION_ID NUMBER(4),
        STREET_ADDRESS VARCHAR2(40),
        POSTAL_CODE VARCHAR2(12),
        CITY VARCHAR2(30),
        PRIMARY KEY (LOCATION_ID)
    )

    INSERT ALL
        INTO LOC_NEW(LOCATION_ID, STREET_ADDRESS, POSTAL_CODE, CITY) VALUES(20,'460 Bloor St. W.','98199','Seattle')
        INTO LOC_NEW(LOCATION_ID, STREET_ADDRESS, POSTAL_CODE, CITY) VALUES(50,'The Oxford Science Park','OX9 9ZB','Seattle')
        INTO LOC_NEW(LOCATION_ID, STREET_ADDRESS, POSTAL_CODE, CITY) VALUES(80,'460 Bloor St. W.','WA 567','Seattle')
        INTO LOC_NEW(LOCATION_ID, STREET_ADDRESS, POSTAL_CODE, CITY) VALUES(90,'460 Bloor St. W.','SAF 875','Seattle')
    SELECT 1 FROM DUAL;

--Exercise B:
--1 
    select * from EMPL_NEW order by hire_date;
--2
    select min(salary), sum(salary) from EMPL_NEW;
--3
    select * from EMPL_NEW where between 10000 and 20000;
--4 
    select FIRST_NAME, LAST_NAME, SALARY from EMPL_NEW where MANAGER_ID=100;
--5
    select * from EMPL_NEW where first_name like 'J%';
--6
    select salary+salary*0.2 "New_Salary", EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID from EMPL_NEW where JOB_ID='VP';

--SA3
--Exercise C:
--1
    select FIRST_NAME, LAST_NAME, SALARY from EMPL_NEW where salary=(select min(salary) from EMPL_NEW);
--2
    select * from EMPL_NEW where salary AND LOCATION_ID=50;
--3
    select * from EMPL_NEW natural join LOC_NEW;
--4
    select first_name, last_name, salary, STREET_ADDRESS from EMPL_NEW join LOC_NEW using(location_id);
--5
    select first_name, last_name, hire_date, city from EMPL_NEW join LOC_NEW using(location_id);
--6 
    select first_name, last_name, job_id, hire_date, location_id from EMPL_NEW join LOC_NEW using(location_id) where location_id=50;
--7
    create table copy_EMPL_NEW AS SELECT * FROM EMPL_NEW;
--8
    INSERT ALL
        INTO copy_EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(402,'Ellen', 'Abel', '11-May-96', 'REP', 11000, NULL, 103, 40)
        INTO copy_EMPL_NEW(EMPLOYEE_ID, FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, SALARY, BONUS, MANAGER_ID, LOCATION_ID) VALUES(403,'Jonathon', 'Taylor', '24-Mar-98', 'REP', 8600, NULL, 103, 40)
    SELECT 1 FROM DUAL;
--9
    create view view_EMPL_NEW AS SELECT first_name, last_name, salary FROM EMPL_NEW;
--10
    create view view_EMPL_NEW2 AS SELECT first_name, last_name FROM EMPL_NEW where location_ID=50;
--11 
    create view view_EMPL_NEW3 as SELECT first_name, last_name, location_id FROM EMPL_NEW natural join LOC_NEW;
--12
    create view view_EMPL_NEW4 as SELECT first_name, last_name, salary FROM EMPL_NEW where last_name like 'K%';
