--4
SELECT * FROM new_students where first_name='JACK' and last_name='SMITH'
--5
SELECT * FROM new_students where first_name like 'R%'
--6
SELECT * FROM new_students order by reg_year
--7
SELECT * FROM new_courses where building='BUILDING A'
--8
SELECT * FROM new_courses where dept_id=10
--9
SELECT * FROM new_students where reg_year>'01-Sep-2012'
--10
SELECT * FROM new_students where id_cours=190
--11
SELECT s.first_name, s.last_name, s.reg_year, c.room FROM new_students s join new_courses c using (id_cours)
--12
SELECT s.first_name, s.last_name, s.reg_year, c.room FROM new_students s, new_courses c
--13
SELECT * FROM new_students join new_courses using (id_cours)
--14
SELECT s.first_name, s.last_name, s.reg_year, c.name, c.session_id FROM new_students s join new_courses c using (id_cours) where id_cours=190