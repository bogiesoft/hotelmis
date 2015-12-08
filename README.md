# hotelmis
This repo is based on the original version of Hotel Management Information Systems, an open source reservation system
written in PHP that we found on Sourceforge and resurrected here on Github.

## Installation

We updated the original version to use PDO instead of the deprecated mysql_connect.

Requires PHP and Mysql.

### Steps
- Create an mysql database
- upload the included hotelmis.sql file into the db
- update queryfunctions.php file/line 25 with db name, db username and db user password
  - by default it uses localhost for db address, update line 25 as well if using a different location

### Usage
Login info is username: admin and password: password.
