--1
SELECT * FROM d_play_list_items, d_track_listings;

--2
SELECT title, type_code, description, artist FROM D_SONGS NATURAL JOIN D_THEMES;

--3
SELECT title, type_code, description, artist FROM D_SONGS NATURAL JOIN D_THEMES WHERE ID IN (47, 48);

--4
SELECT * FROM D_CLIENTS, D_EVENTS, D_JOB_ASSIGNMENTS;

--5
SELECT song_id, title FROM D_TRACK_LISTINGS NATURAL JOIN D_CDS;

--6
SELECT last_name, first_name, salary, department_name FROM employees, departments

--7
SELECT department_id, department_name, location_id, city FROM locations NATURAL JOIN departments;

--8
SELECT department_id, department_name, location_id, city FROM locations NATURAL JOIN departments WHERE department_id = 110;

--9
SELECT * FROM locations JOIN departments USING (location_id) WHERE location_id = 1700;

--10
SELECT e.first_name, e.last_name, e.salary, j.job_title FROM employees e JOIN jobs j USING (job_id);

--11
SELECT e.first_name, e.last_name, e.salary, j.MIN_SALARY, j.MAX_SALARY FROM employees e JOIN jobs j USING (JOB_ID);

--12
SELECT e.first_name, e.last_name, e.salary, j.start_date, j.end_date FROM employees e JOIN job_history j using (employee_id); (ex.13)

--13
SELECT first_name, last_name, salary, start_date, end_date FROM employees NATURAL JOIN job_history; (ex.12)

--14
SELECT e.first_name, e.last_name, e.salary, j.start_date, j.end_date FROM employees e JOIN job_history j USING (EMPLOYEE_ID) WHERE employee_id = 100;

--15
SELECT * FROM new_students NATURAL JOIN new_courses;

--16
SELECT s.first_name, s.last_name, c.session_id, c.building FROM new_students s JOIN new_courses c USING (ID_COURS);

--17
SELECT s.first_name, s.last_name, c.session_id, c.building, c.room FROM new_students s JOIN new_courses c USING (ID_COURS) WHERE c.room = 401;

--18
SELECT s.first_name, s.last_name, s.reg_year, c.building, c.room FROM new_students s JOIN new_courses c USING (ID_COURS) WHERE (dept_id) = (10);

--19
SELECT s.first_name, s.last_name, s.reg_year, c.name, c.session_id FROM new_students s JOIN new_courses c USING (ID_COURS) WHERE id_cours = 193; (ex.20)

--20
SELECT first_name, last_name, reg_year, name, session_id FROM new_students NATURAL JOIN new_courses WHERE id_cours = 193; (ex.19)
