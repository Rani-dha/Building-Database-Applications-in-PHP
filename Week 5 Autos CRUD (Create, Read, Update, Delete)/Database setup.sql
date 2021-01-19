Databases and Tables Required for the Assignment
You already should have a PHP hosting environment such as MAMP or XAMPP installed or have some other access to a MySQL client to run commands.

You will need to create a database, a user to connect to the database and a password for that user using commands similar to the following:

create database misc;

GRANT ALL ON misc.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';

You will need to make a connection to that database in a file like this if you are using MAMP (Macintosh):
<?php
$pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


If you are using XAMPP or Linux you should change the port to 3306:
<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

Usually this file is named pdo.php and is included in each of the files that want to use the database. You will need to change the user name and password on both your GRANT statements and in the code that makes the PDO connection.
You will also need to create and configure a table in the new "misc" database using the following SQL commands:

CREATE TABLE autos (
   auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
   make VARCHAR(128),
   year INTEGER,
   mileage INTEGER
);