use wt;
SELECT * from groups where HostName=(select HostName from smartboxes where UserNo=(select UserNo from users where UserName='user'))