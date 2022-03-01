--1
select * from job_history
--2
select * from job_history order by start_date
--3
select * from job_history where start_date>'01-Jan-1990'
--4
select salary*0.1+salary from employees where department_id=110
--5
select * from employees where job_id='AC_ACCOUNT'
--6
select * from employees where salary between 17000 and 30000
--7
select * from employees where hire_date<'01-Jan-1998'
--8
select first_name, last_name from employees where department_id=50
--9
select * from employees where last_name like 'H%'
--10
select first_name, last_name, salary, department_name from employees join job_history using(job_id)
--11
select first_name, last_name, salary, department_id from employees natural join job_history where employee_id>150
--12
select * from employees natural join job_history
--13
select first_name, last_name, salary, start_date, end_date from employees cross join job_history
--14
SELECT e.first_name, e.last_name, e.salary, j.start_date FROM employees e JOIN job_history j USING (job_id)
--15
SELECT e.first_name, e.last_name, e.salary, j.start_date FROM employees e JOIN job_history j USING (job_id) WHERE department_id=80 OR department_id=90
--16
SELECT e.first_name, e.last_name, e.salary, j.start_date FROM employees e JOIN job_history j USING (job_id) WHERE job_id = 'ST_CLERK'
--17
select * from employees natural join job_history natural join departments
--18
select * from job_history natural join departments
--19
select department_name, manager_id, start_date, end_date from job_history natural join departments
--20
select department_name, manager_id, start_date, end_date from job_history natural join departments where manager_id=100
