--1
SELECT last_name, department_name FROM employees natural join departments;

--2
SELECT DEPARTMENT_ID, DEPARTMENT_NAME, LOCATION_ID, CITY FROM departments natural join locations;

--3
SELECT DEPARTMENT_ID, DEPARTMENT_NAME, LOCATION_ID, CITY FROM departments natural join locations WHERE department_id = 20 OR department_id = 50;

--4
SELECT * FROM locations l LEFT JOIN departments d ON l.location_id = d.DEPARTMENT_ID WHERE l.location_id = 1400;

--5
SELECT DEPARTMENT_NAME, CITY, LOCATION_ID, DEPARTMENT_ID FROM departments natural join locations WHERE DEPARTMENT_ID IN (10, 20, 30);

--6
SELECT FIRST_NAME, LAST_NAME, HIRE_DATE, JOB_ID, JOB_TITLE, MAX_SALARY FROM employees natural join jobs WHERE salary > 12000;

--7
SELECT e.employee_id, e.first_name, e.last_name, m.employee_id "manager_employee_id", m.first_name "manager_first_name", m.last_name "manager_last_name" FROM employees e, employees m WHERE e.manager_id = m.employee_id;

--8
SELECT * FROM locations l LEFT JOIN departments d ON l.COUNTRY_ID = d.COUNTRY_ID WHERE COUNTRY_ID = 'CA';

--9
SELECT e.employee_id, e.first_name, e.last_name, m.employee_id "manager_employee_id", m.first_name "manager_first_name", m.last_name "manager_last_name", e.department_id FROM employees e, employees m WHERE e.manager_id = m.employee_id and e.department_id in (80, 90, 110, 190);

--10
SELECT * FROM employees WHERE hire_date > TO_DATE('June 7 1994', 'MM DD YYYY');

--11
SELECT e.EMPLOYEE_ID, e.LAST_NAME, e.DEPARTMENT_ID, d.department_NAME, e.hire_date FROM employees e LEFT JOIN departments d ON e.department_id = d.department_id WHERE e.hire_date > TO_DATE('June 7 1994', 'MM DD YYYY');

--12
SELECT title, TYPE_CODE, description, artist FROM D_SONGS natural join D_TYPES;

--13
SELECT title, TYPE_CODE, description, artist FROM D_SONGS natural join D_TYPES WHERE type_code in (47, 48);

--14
SELECT * FROM d_clients, d_events, d_job_assignments;

--15
SELECT NAME, code FROM D_EVENTS natural join d_packages;