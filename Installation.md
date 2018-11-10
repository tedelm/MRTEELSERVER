# Installation

## Pre-req
You have a clean installation of raspberry pi (no webserver,database or such that can make this fail)
You have access to your raspberry pi using SSH

## Set timezone and hostname
```
sudo raspi-config
```
## upgrade OS
```
sudo apt-get update
sudo apt-get dist-upgrade
```
## Download MRTEELSERVER
```
git clone https://github.com/tedelm/MRTEELSERVER /home/pi/MRTEELSERVER
```
## Install LAMP
```
sudo apt-get install apache2 mysql-server mysql-client python-mysql.connector
sudo apt-get install php5 libapache2-mod-php5 php5-fpm php5-mysql php5-mysqlnd
```
## Install PhpMyAdmin
```
sudo apt-get install phpmyadmin
```

## Create database and add permissions
```
sudo mysql -u root -p

CREATE DATABASE mrteeldb;
USE mrteeldb;

CREATE USER 'mrteel' IDENTIFIED BY 'nosecretnow';
GRANT USAGE ON *.* TO 'mrteel';
GRANT ALL PRIVILEGES ON `mrteeldb`.* TO 'mrteel' WITH GRANT OPTION;
```
### Create table
```
CREATE TABLE `Data` (
	`Timestamp` datetime NOT NULL,
	`Name` varchar(64) COLLATE ascii_bin NOT NULL,
	`ID_` int NOT NULL AUTO_INCREMENT,
	`Angle` double NOT NULL,
	`Temperature` double NOT NULL,
	`Battery` double NOT NULL,
	`ResetFlag` boolean,
	`Gravity` double NOT NULL DEFAULT 0,
	`UserToken` varchar(64) COLLATE ascii_bin,
	`Interval` int,
	`RSSI` int,
PRIMARY KEY (`Timestamp`,`Name`,`ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin COMMENT='iSpindle Data';

CREATE TABLE `MyIspindles` (
	`ID_` int NOT NULL AUTO_INCREMENT,
	`IspindelName` varchar(64) COLLATE ascii_bin,
    `Poly1` double NOT NULL,    
    `Poly2` double NOT NULL,    
    `Poly3` double NOT NULL,            
	PRIMARY KEY (`ID_`)
	) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin COMMENT='My iSpindle info';
	
CREATE TABLE `MyRecipes` (
	`ID_` int NOT NULL AUTO_INCREMENT,
	`IspindelName` varchar(64) COLLATE ascii_bin,
	`MyRecipeName` varchar(64) COLLATE ascii_bin,
	`MyRecipeOG` double NOT NULL, 
	`MyRecipeCalcFG` double NOT NULL, 	
	`MyRecipeBrewDay` varchar(64) COLLATE ascii_bin,       
	PRIMARY KEY (`ID_`)
	) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin COMMENT='My iSpindle info';

QUIT;
```
## Install MRTEELSERVER
```
sudo apt-get install insserv
```

Then, within the SSH terminal session, type:</br>
```
cd /home/pi/MRTEELSERVER
sudo mv ./www/* /var/www/html

sudo mv ./tcpserver/mrteelserver.py /usr/local/bin
sudo mv ./tcpserver/MRTEELSERVER /etc/init.d

sudo chmod 755 /usr/local/bin/mrteelserver.py
sudo chmod 755 /etc/init.d/MRTEELSERVER

cd /etc/init.d
sudo systemctl daemon-reload
sudo insserv MRTEELSERVER
sudo service MRTEELSERVER start
```
You should be able to see the script running now:
```
ps -ax | grep MRTEELSERVER
```
## Brows to your new site	
```
http://<your raspberry pi ip>/index.php
```

## Default Username and password used
```
mysql
Database: mrteeldb
Username: mrteel
Password: nosecretnow
```

## GenericTCP server
The GenericTCP server uses port 9501</br>
To troubleshoot use:</br>
</br>
see if your server is listening on port 9501:
```
ps -ax | grep MRTEELSERVER
netstat -ano | grep "9501"
```
Enable debug mode, change DEBUG = 0, to DEBUG = 1 in mrteelserver.py and stop service</br>
```
sudo nano /usr/local/bin/mrteelserver.py
sudo service MRTEELSERVER stop

Now you run the server in consol mode to see output:
/usr/local/bin/mrteelserver.py

```
