DROP DATABASE IF EXISTS korvin_repif;
create database korvin_repif;
use korvin_repif;

CREATE TABLE `users` (
  id int not null auto_increment,
  username varchar(50),
  pwd varchar(255),
  first_name varchar(255),
  last_name varchar(255),
  email varchar(255),
  technician boolean,
  primary key (id)
);

CREATE TABLE `smartboxes` (
  HostName varchar(255) UNIQUE,
  Description varchar(255),
  Location varchar(255),
  userId int,
  PRIMARY KEY (HostName),
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `boxgroups` (
  id int not null auto_increment,
  gname varchar(255),
  gdesc varchar(255),
  hostname varchar(255),
  PRIMARY KEY (id),
  FOREIGN KEY (hostname) REFERENCES smartboxes(hostname) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `boxleds` (id int not null AUTO_INCREMENT, pinid int, groupid int, action varchar(50), PRIMARY KEY (id), FOREIGN KEY (groupId) REFERENCES boxgroups(id) on delete cascade on update cascade);
CREATE TABLE `boxswitches` (id int not null AUTO_INCREMENT, pinid int, hostname varchar(255), groupid int, PRIMARY KEY (id), FOREIGN KEY (hostname) REFERENCES smartboxes(hostname) on delete cascade on update cascade, FOREIGN KEY (groupId) REFERENCES boxgroups(id) on delete cascade on update cascade);


INSERT INTO users (username, pwd) VALUES ('admin', '$2y$10$L.MK2NHnt/dJGQhxJE8uL.fTP22kjLNQ3s53IVVJMYgH4b.Zl7.W6');