#!/usr/bin/env bash
su root
apt-get install sudo
usermod -aG sudo pi
sudo raspi-config
sudo apt-get update
sudo apt-get dist-upgrade
sudo apt-get install git-all
git clone https://github.com/tedelm/MRTEELSERVER /home/pi/MRTEELSERVER
sudo apt-get install apache2 mysql-server mysql-client python-mysql.connector
sudo apt-get install php5 libapache2-mod-php5 php5-fpm php5-mysql php5-mysqlnd
sudo apt-get install phpmyadmin
