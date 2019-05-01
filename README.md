# 2019-rmp-doginator

APIscrape/APIscrape.php
======================

A script clears existing database, creating new tables and populating them with data.


Description
============

1. Establishes a connection with an existing database.
2. Executes an SQL query which drops existing tables.
3. Executes an SQL query which creates new tables.
4. Creates a request to API using  htts://dog.ceo/api/breeds/list/all
5. Receives a response in a JSON format and decodes it.
6. Populates created tables with received data.


Usage
=====

1. Create a database called 'doginator'.
2. Go to APIscrape/APIscrape.php and edit the value of constants IP, USER and PASSWORD to your 
IP address, a DB user name and a DB access password.
3. Run 'php APIscrape.php' command in your Terminal.
4. You're done. The DB will be updated and populated for you.
 


