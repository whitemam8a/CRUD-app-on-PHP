CREATE TABLE users(
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  SecondName varchar(25) not null,
  FirstName	varchar(25) not null,
  isikukood	varchar(11) not null,
  grade int(10) not null,
  email	varchar(25) not null,
  message	varchar(250)
)