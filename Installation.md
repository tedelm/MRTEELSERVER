# Installation

## Pre-req
You have a clean installation of raspberry pi (no webserver,database or such that can make this fail)
You have access to your raspberry pi using SSH

## Install SUDO
```
su root
apt-get install sudo
usermod -a -G sudo pi
```
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
sudo apt-get install git-all
git clone https://github.com/tedelm/MRTEELSERVER /home/pi/MRTEELSERVER
```
## Install LAMP
```
UPDATE if you are running "stretch" rasbian (Requires php5):
#Update system
sudo apt-get update
sudo apt-get upgrade -y

#Install Apache2
sudo apt-get install apache2 -y
sudo a2enmod rewrite
sudo service apache2 restart

#Install PHP
sudo apt-get install php5 libapache2-mod-php5 -y

#Install MySQL
sudo apt-get install mysql-server php-mysql -y
sudo service apache2 restart

#Install PhpMyAdmin
sudo apt-get install phpmyadmin -y

IF you are running "Jessie" old rasbian:
sudo apt-get install apache2 mysql-server mysql-client python-mysql.connector
sudo apt-get install php5 libapache2-mod-php5 php5-fpm php5-mysql
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
	`ID` int NOT NULL,
	`Angle` double NOT NULL,
	`Temperature` double NOT NULL,
	`Battery` double NOT NULL,
	`ResetFlag` boolean,
	`Gravity` double NOT NULL DEFAULT 0,
	`UserToken` varchar(64) COLLATE ascii_bin,
	`Interval` int,
	`RSSI` int,
PRIMARY KEY (`Timestamp`,`Name`,`ID`)
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

## Connect iSpindel to your MRTEELSERVER
set "Service Type" to TCP</br>
set "Server Address" to IP of raspberry pi/MRTEELSERVER</br>

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

## Update MRTEELSERVER
```
git clone https://github.com/tedelm/MRTEELSERVER /home/pi/MRTEELSERVER-update
cd /home/pi/MRTEELSERVER-update
sudo mv ./www/* /var/www/html
cd ..
sudo rm -rf /home/pi/MRTEELSERVER-update
```

