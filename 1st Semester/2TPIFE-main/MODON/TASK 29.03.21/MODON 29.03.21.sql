--1
CREATE TABLE GRAD_CANDIDATES(
    Column_Name varchar(20), 
    student_id number(6),
    last_name varchar(50),
    first_name varchar(50),
    credits number(3),
    graduation_date date,
    primary key (student_id),
    foreign key (credits) references REQUIREMENTS(credits)
)

--3
INSERT INTO GRAD_CANDIDATES(Column_Name) VALUES('Key Type', 'Nulls/Unique','FK Column', 'Datatype','Length');
INSERT ALL{
    INTO GRAD_CANDIDATES(student_id) VALUES('PK','Unique','-','NUMBER',6)
    INTO GRAD_CANDIDATES(last_name) VALUES('-','NOT NULL','-','VARCHAR2',50)
    INTO GRAD_CANDIDATES(first_name) VALUES('-','NOT NULL','-','VARCHAR2',50)
    INTO GRAD_CANDIDATES(credits) VALUES('-','NOT NULL','from REQUIREMENTS(credits)','NUMBER',3)
    INTO GRAD_CANDIDATES(graduation_date) VALUES('-','NOT NULL','-','DATE','-')
}
select * from dual;

INSERT INTO GRAD_CANDIDATES(student_id,last_name,first_name,credits,graduation_date) VALUES(190312, 'Monticelli', 'Leonardo', 100, 'Jul-2022');

-- 4
CREATE TABLE o_jobs AS (SELECT * FROM jobs); 
CREATE TABLE o_employees AS (SELECT * FROM employees);
CREATE TABLE o_departments  AS (SELECT * FROM departments); 

--5
INSERT INTO o_jobs (job_id, job_title, min_salary, max_salary) VALUES('HR_MAN', 'Human Resources Manager', 4500, 5500); 

--6
INSERT   ALL {
    INTO   o_employees   (employee_id,   first_name,   last_name,   email, hire_date, job_id) VALUES(210, 'Ramón', 'Sanchez', 'RSANCHEZ', SYSDATE, 'HR_MAN'); 
    INTO   o_employees   (employee_id,   first_name,   last_name,   email, hire_date, job_id) VALUES(220, 'José', 'Sanchez', 'JSANCHEZ', SYSDATE, 'SUPP_IT'); 
    INTO   o_employees   (employee_id,   first_name,   last_name,   email, hire_date, job_id) VALUES(230, 'Pedro', 'Sanchez', 'PSANCHEZ', SYSDATE, 'IT_TECH'); 
}
select * from dual;

--7
INSERT    INTO    o_departments(department_id,    department_name) VALUES (210,'Human Resources'); 

--8
'It is important to modify tables in the case that we make a mistake';

--9
CREATE TABLE ARTISTS(
    artist_id number(6),
    first_name varchar(50),
    last_name varchar(50),
    band_name varchar(50),
    email varchar(50),
    hourly_rate number(3),
    song_id number(6),
    foreign key(song_id) references d_songs(ID)
);

INSERT INTO ARTISTS(band_name,song_id) from ('The Hobbits',45);

INSERT INTO ARTISTS(artist_id,first_name,last_name,band_name,email,hourly_rate,song_id) VALUES('Billie Eilish','Billie','Eilish','','',999,'43')

ALTER TABLE artists
ADD age number(2);

DROP TABLE not_artists;

ALTER TABLE artists   
RENAME TO new_artists;  

TRUNCATE TABLE not_artists;

COMMENT ON COLUMN ARTISTS.first_name 
   IS 'this is a comment';

--10
ALTER TABLE o_employees
ADD Termination date SET DEFAULT  'February 20th, 2003';

--11
ALTER TABLE o_employees
ADD o_start_date AT TIME ZONE;

--12
ALTER TABLE o_jobs    
RENAME TO o_job_description;  