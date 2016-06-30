#!/bin/bash

set -e

color() {
      printf '\033[%sm%s\033[m\n' "$@"
      # usage color "31;5" "string"
      # 0 default
      # 5 blink, 1 strong, 4 underlined
      # fg: 31 red,  32 green, 33 yellow, 34 blue, 35 purple, 36 cyan, 37 white
      # bg: 40 black, 41 red, 44 blue, 45 purple
      }

color '36;1' "

     This script installs dependencies for Vkusotiiki-bg.

     For more details, visit:
     https://github.com/kakato10/vkusotiiki-bg
"
echo "cd /home/vagrant/vkusotiiki-bg" >> /home/vagrant/.bashrc

color '35;1' 'Updating packages...'
apt-get update


color '35;1' 'Install dependencies...'
apt-get install mysql-server \
                mysql-client \
                libmysqlclient-dev \
                php5-cli \
                php5-mysql \
                php5-mysqlnd \
                apache2 --fix-missing
color '35;1' 'Finished installing dependencies...'

# database

sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

service mysql restart
echo 'create database `vkusotiiki-bg`' | mysql -u root -proot
mysql -u root -proot vkusotiiki-bg < php_services/vkusotiiki-bg-2.sql

color '35;1' 'Cleaning up...'
apt-get -y autoremove

color '35;1' 'Install compass gem...'
gem install compass

color '35;1' 'Installinng npm packages...'
npm install n -g
n stable
npm install -g generator-karma generator-angular

color '35;1' 'Install npm packages...'
npm install
color '35;1' 'Finish installing npm packages'

# color '35;1' 'Install libs with bower...'
# cd vkusotiiki-bg
# bower install
# color '35;1' 'Finish installing bower libs'

color '35;1' 'Done!.'
