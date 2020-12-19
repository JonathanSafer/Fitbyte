# Fitbyte
Body weight exercise tracker

## Instructions for use:
* Press the signup button to create a new account
* Once your account is created you can log in via the login page
* After you are logged in, you can log one of 3 exercises currently available
* When you have logged enough exercises, graphs will begin populating on your dashhboard
### In development:
* You can press the competitions button to see yourself compared to you friends
* When you create a new competition, you will have to provide a name and password for it. Your friends can use these credentials to join your competition

## MySQL Setup Instructions:
* Startup a mysql instance
* Create a database 
  * CREATE DATABASE fitbyte;
* Enter your database 
  * USE fitbyte;
* Create people table and exercise table
  * CREATE TABLE people (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, email varchar(255), username varchar(255), firstName varchar(255), lastName varchar(255), password varchar(255));
  * CREATE TABLE exercises (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, p_id int, exercise varchar(255), quantity int, time TIMESTAMP);
  * CREATE TABLE competitions (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, person0 int, person1 int, person2 int, person3 int, person4 int, person5 int, person6 int, person7 int, person8 int, person9 int);
* Fill in connection info in `init.php`
* That's it!
