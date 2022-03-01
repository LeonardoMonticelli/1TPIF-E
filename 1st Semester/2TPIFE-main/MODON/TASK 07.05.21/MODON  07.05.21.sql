--1
CREATE TABLE copy_d_songs AS SELECT * FROM d_songs; 
CREATE VIEW view_copy_d_songs AS SELECT * FROM copy_d_songs;
--2
INSERT INTO view_copy_d_songs (ID, TITLE, DURATION, ARTIST, TYPE_CODE) VALUES(88, 'Mello Jello', 2, 'The What', 4);
SELECT * FROM copy_d_songs WHERE ID = 88;
--3
CREATE TABLE COPY_D_CDS AS SELECT * FROM D_CDS;
CREATE VIEW read_copy_d_cds AS SELECT * FROM COPY_D_CDS WHERE year = 2000 with read only;
--4
DELETE FROM read_copy_d_cds WHERE cd_number = 90;
--5
CREATE OR REPLACE VIEW read_copy_d_cds AS SELECT * FROM copy_d_cds WHERE year = 2000 WITH CHECK OPTION CONSTRAINT ck_read_copy_d_cds;
--6
DELETE FROM read_copy_d_cds WHERE year = 2000;
--7
DELETE FROM read_copy_d_cds WHERE cd_number = 90;
--8
DELETE FROM read_copy_d_cds WHERE year = 2001;
--9
SELECT * FROM copy_d_cds;
--10
CREATE OR REPLACE VIEW view_copy_d_songs AS SELECT title, artist FROM copy_d_songs;
SELECT * FROM view_copy_d_songs;
--11
DROP VIEW view_copy_d_songs;
SELECT * FROM view_copy_d_songs;
--12
SELECT * FROM (SELECT last_name, salary FROM employees ORDER BY salary DESC);
--13
CREATE TABLE copy_employees AS SELECT * FROM employees;
CREATE VIEW view_copy_employees AS SELECT name, salary, department_ID, and maximum salary FROM copy_employees;
--14
SELECT * FROM f_staffs ORDER BY salary ASC;
--15
CREATE TABLE my_departments AS SELECT * FROM departments;
SELECT * FROM my_departments;
--16
CREATE VIEW view_my_departments AS SELECT department_id, department_name FROM my_departments;
--17
INSERT INTO view_my_departments (department_id, department_name) VALUES(105, 'Advertising');
INSERT INTO view_my_departments (department_id, department_name) VALUES(120, 'Custodial');
INSERT INTO view_my_departments (department_id, department_name) VALUES(130, 'Planning');
SELECT * FROM view_my_departments;
--18
ALTER TABLE my_departments ADD CONSTRAINT my_departments_id_pk  PRIMARY KEY (department_id);
--19
INSERT INTO view_my_departments (department_name) VALUES('Human Resources');
--20
INSERT INTO view_my_departments (department_id, department_name) VALUES(220, 'Human Resources');
--21
CREATE OR REPLACE VIEW view_my_departments AS SELECT department_id , department_name, location_id FROM my_departments;
SELECT * FROM view_my_departments;
--22
ALTER TABLE my_departments MODIFY (location_id NUMBER(4,0) CONSTRAINT my_departments_loc_id_notnull NOT NULL); 
--23
CREATE OR REPLACE VIEW view_dpt_loc AS SELECT dpt.department_name, loc.street_address, loc.city, loc.state_province FROM departments dpt LEFT JOIN locations loc ON dpt.location_id = loc.location_id LEFT JOIN countries con ON loc.country_id = con.country_id WHERE con.country_name = 'United States of America';
SELECT * FROM view_dpt_loc;