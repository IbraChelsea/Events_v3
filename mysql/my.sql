drop database company; 
create database company;	
use company;
	create table employee(
		empid int primary key,
		firstname varchar(25) not null,
		lastname varchar(25) not null,
		salary decimal(5,2) check(salary>100),
		dep varchar(40) default "se"
		);
	describe employee;

	insert into employee(
		empid,
		firstname,
		lastname,
		salary,
		dep) 
	values
	(
		1,
		"ibrahim",
		"alali",
		978.33,
		"entwecklung"
		);
		insert into employee(
		empid,
		firstname,
		lastname,
		salary,
		dep) 
	values
	(
		2,
		"ismail",
		"alali",
		500.33,
		"math"
		);
		insert into employee(
		empid,
		firstname,
		lastname,
		salary,
		dep) 
	values
	(
		3,
		"mohammad",
		"alali",
		753.74,
		"wirtschaft"
		);
		insert into employee(
		empid,
		firstname,
		lastname,
		salary,
		dep) 
	values
	(
		4,
		"mostafa",
		"alali",
		201.63,
		"entwecklung"
		);
	select * from employee;