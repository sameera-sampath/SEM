CREATE TABLE users 
(
USER_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(20) NOT NULL UNIQUE,
password VARCHAR(45) NOT NULL,
fname varchar(45) NOT NULL,
lname varchar(45) NOT NULL,
User_Type varchar(45) NOT Null) ;

CREATE  TABLE Province (
  Province_ID INT(11) NOT NULL,
  Province_Name varchar(45) NOT NULL,
  PRIMARY KEY (Province_ID) );

CREATE  TABLE Zone (
  Zone_ID INT(11) NOT NULL,
  Zone_Name varchar(45) NOT NULL,
  Province_ID INT(11) NOT NULL REFERENCES Province (Province_ID),
  PRIMARY KEY (Zone_ID) );
  
CREATE  TABLE Division (
  Division_ID INT(11) NOT NULL,
  Division_Name varchar(45) NOT NULL,
  Zone_ID INT(11) NOT NULL REFERENCES Zone(Zone_ID),
  PRIMARY KEY (Division_ID) );

CREATE  TABLE School (
  School_ID INT(11) NOT NULL,
  School_Name varchar(45) NOT NULL,
  School_Grade varchar(45) NOT NULL DEFAULT '1AB',
  School_Type varchar(45) NOT NULL DEFAULT 'Provincial',
  Division_ID INT(11) NOT NULL REFERENCES Division(Division_ID),
  Zone_ID INT(11) NOT NULL REFERENCES Zone(Zone_ID),
  PRIMARY KEY (School_ID) );



CREATE  TABLE Teacher (
  USER_ID INT(11) NOT NULL REFERENCES users (USER_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Designation varchar(45) NOT NULL DEFAULT 'Teacher',
  Teacher_Grade varchar(45) NOT NULL DEFAULT '2',
  PRIMARY KEY (USER_ID) );

CREATE  TABLE Principal (
  USER_ID INT(11) NOT NULL REFERENCES users (USER_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Designation varchar(45) NOT NULL DEFAULT 'Principal',
  Principal_Grade varchar(45) NOT NULL DEFAULT '2',
  PRIMARY KEY (USER_ID) );

CREATE TABLE Officer (
  USER_ID int(11) NOT NULL REFERENCES users (USER_ID),
  Designation varchar(45) NOT NULL DEFAULT 'Director',
  Level varchar(45) NOT NULL DEFAULT 'Provincial',
  Officer_Grade varchar(45) NOT NULL DEFAULT '2',
  PRIMARY KEY (USER_ID));

  CREATE TABLE Zonal_Officer (
  USER_ID int(11) NOT NULL REFERENCES Officer (USER_ID),
  Zone_ID INT(11) NOT NULL REFERENCES Zone(Zone_ID),
  PRIMARY KEY (USER_ID));
  
CREATE TABLE Divisional_Officer (
  USER_ID int(11) NOT NULL REFERENCES Officer (USER_ID),
  Division_ID INT(11) NOT NULL REFERENCES Division(Division_ID),
  PRIMARY KEY (USER_ID));
  
  CREATE TABLE Provincial_Officer (
  USER_ID int(11) NOT NULL REFERENCES Officer (USER_ID),
  Province_ID INT(11) NOT NULL REFERENCES Province (Province_ID),
  PRIMARY KEY (USER_ID));
  
CREATE TABLE Category (
  Category_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Category_Name varchar(45) NOT NULL DEFAULT 'Residential');
  
  CREATE TABLE Application (
  Application_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Full_Name varchar(100) NOT NULL,
  Name_With_Initials varchar(45) NOT NULL,
  Category_ID int(11) NOT NULL REFERENCES Category (Category_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Name_Father varchar(45) NOT NULL,
  Name_Mother varchar(45) NOT NULL,
  Address varchar(100) NOT NULL,
  City varchar(45) NOT NULL,
  Distance_To_School_KM INT(11) NOT NULL);
  
CREATE TABLE Student (
  Student_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Full_Name varchar(100) NOT NULL,
  Name_With_Initials varchar(45) NOT NULL,
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Name_Father varchar(45) NOT NULL,
  Name_Mother varchar(45) NOT NULL,
  Address varchar(100) NOT NULL,
  City varchar(45) NOT NULL,
  Distance_To_School_KM INT(11) NOT NULL);
  
CREATE TABLE Student_School (
  Student_ID INT NOT NULL REFERENCES Student(Student_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Enrollment_Date DATE NOT NULL,
  Leaving_Date DATE NULL,
  primary Key(Student_ID,School_ID));
  
CREATE TABLE Grade (
  Grade_ID INT(11) NOT NULL,
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Grade_Cordinator INT(11) NOT NULL REFERENCES Teacher (USER_ID),
  primary Key(Grade_ID,School_ID));
  
CREATE TABLE Class (
  Class_ID INT(11) NOT NULL,
  Grade_ID INT(11) NOT NULL REFERENCES Grade(Grade_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Class_Teacher INT(11) NOT NULL REFERENCES Teacher (USER_ID),
  primary Key(Class_ID,Grade_ID,School_ID));
  
CREATE TABLE Student_Class (
  Student_ID INT NOT NULL REFERENCES Student(Student_ID),
  Class_ID INT(11) NOT NULL REFERENCES Class(Class_ID),
  Grade_ID INT(11) NOT NULL REFERENCES Grade(Grade_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Academic_Year YEAR NOT NULL,
  primary Key(Student_ID,Class_ID,Grade_ID,School_ID));
  
CREATE TABLE Student_Grade (
  Student_ID INT NOT NULL REFERENCES Student(Student_ID),
  Grade_ID INT(11) NOT NULL REFERENCES Grade(Grade_ID),
  School_ID INT(11) NOT NULL REFERENCES School(School_ID),
  Academic_Year YEAR NOT NULL,
  primary Key(Student_ID,Grade_ID,School_ID));