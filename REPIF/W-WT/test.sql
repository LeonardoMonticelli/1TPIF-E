use wt2;
-- select users.UserName, manage.HostName from users, manage where users.UserNo=manage.UserNo and users.UserNo=1;
SELECT * from smartboxes, manage where smartboxes.HostName=manage.HostName and manage.UserNo=1;