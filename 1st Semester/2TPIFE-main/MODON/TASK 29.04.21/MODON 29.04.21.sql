--1
select * from d_play_list_items natural join d_play_list_items
--2
select AVG(salary) from employees where job_id='sa_rep'
--3
select ROUND(AVG(salary),2) from employees where job_id='ad_vp'
--4
select MAX(hire_date) from employees where department_id=90
--5
select MAX(first_name) from employees
--6
select MAX(first_name) from employees order by first_name asc
--7
select salary*0.1+salary as New_Salary, first_name, last_name from employees where job_id='AD_VP'
--8
select MIN(salary) from employees 
--9
select MAX(salary) from employees where department_id=90
--10
select * from employees where hire_date>'01-Jul-1990'
--11
select first_name, last_name, salary from EMPLLPEM where manager_id=103
--12
select * from employees where last_name like 'a%'
--13
select concat(concat(first_name,' '),last_name)  as Name from employees
--14
select initcap(last_name) from employees
--15
select * from employees order by employee_id
--16
select * from employees order by hire_date
--17
select first_name, last_name from employees where COMMISSION_PCT is null
--18
select AVG(salary) from employees inner join DEPARTMENTS on employees.department_id=DEPARTMENTS.department_id group by department_name
--19
select salary from employees inner join DEPARTMENTS on employees.department_id=DEPARTMENTS.department_id group by department_name
--20
select MIN(hire_date) from employees inner join DEPARTMENTS on employees.department_id=DEPARTMENTS.department_id group by department_name
--21
select MIN(first_name) from employees inner join DEPARTMENTS on employees.department_id=DEPARTMENTS.department_id group by department_name
--22
select MIN(salary) from employees inner join DEPARTMENTS on employees.department_id=DEPARTMENTS.department_id group by department_name
--23
select MAX(salary) from employees inner join DEPARTMENTS on employees.department_id=DEPARTMENTS.department_id group by department_name
--24
select * from employees natural join DEPARTMENTS
--25
select * from employees natural join DEPARTMENTS where department_id=90