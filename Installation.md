# Create the database #

You should have Mysql or some other database installed and running on your system.  The application's default configuration is for Mysql.  You can change the database type by editing the resources.db.adapter entry in the application's config/store.ini file.

Create a new database called "storefront", and create or modify a user which is granted full rights to this database.  Then edit the resources.db.**entries in the application's config/store.ini file to reflect your setup.**

```
resources.db.adapter = "PDO_MYSQL"
resources.db.isdefaulttableadapter = true
resources.db.params.dbname = "storefront"
resources.db.params.username = "dbusername"
resources.db.params.password = "dbpassword"
resources.db.params.hostname = "localhost"
resources.db.params.charset = "UTF8"
```

# Loading the database #

Create and populate the database tables using data in the application's sql directory.  For mysql, this would be:
mysql -h localhost -u yourdbusername -p dbname < structure.sql
mysql -h localhost -u yourdbusername -p dbname < data.sql

Log into your database with your new database user and verify that the database has been loaded.

# Webserver setup #

You should have a webserver running on your local machine.  Edit the webserver's configuration to point to the application's public folder.

For apache, you should edit the http.conf configuration file.  Normally, only two lines need modification:
```
DocumentRoot "/path/to/zendframeworkstorefront/public"
<Directory "/path/to/zendframeworkstorefront/public">
```
Next, verify that the application's data/cache/db directory is writable by the webserver.  If you're uncertain how to do this and you're just running a local test setup, simply make the cache/db directory writable by everyone.  On unix and Mac OS X, type the command chmod o+w /path/to/zendframeworkstorefront/data/cache/db

Download and install the latest version of the Zend Framework (http://framework.zend.com/).  (This application was tested with versions 1.8+)  Unpack the downloaded file, and copy the library/Zend folder to the application's library folder.

Restart your webserver and visit http://localhost in your web browser. At this point, you should be able to see the storefront.

# Testing with PHPUnit and ant #

First, you'll need to make sure you have both ant (http://ant.apache.org/) and PHPUnit (http://www.phpunit.de/) installed on your system.  Then go to the application's build directory and run ant.  You should see a "BUILD SUCCESSFUL" message.