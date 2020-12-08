# Fitbyte
Body weight exercise tracker

## Setup Instructions:
* Startup a mysql instance
* Create a database 
  * CREATE DATABASE fitbyte;
* Enter your database 
  * USE fitbyte;
* Create people table and exercise table
  * CREATE TABLE people (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, email varchar(255), username varchar(255), firstName varchar(255), lastName varchar(255), password varchar(255));
  * CREATE TABLE exercises (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, p_id int, exercise varchar(255), quantity int, time TIMESTAMP);
* Fill in connection info in `init.php`
* That's it!
