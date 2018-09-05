#!/bin/bash
# Script by : _Dreyannz_
apt-get update
apt-get install apache2 -y
apt-get install libssh2-php -y
service apache2 restart
apt-get install nginx -y
apt-get install php5-fpm -y
apt-get install php5-cli -y
rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default
wget -O /etc/nginx/nginx.conf "https://raw.githubusercontent.com/Dreyannz/AutoScriptVPS/master/Files/Nginx/nginx.conf"
mkdir -p /home/vps/public_html
wget -O /etc/nginx/conf.d/vps.conf "https://raw.githubusercontent.com/Dreyannz/AutoScriptVPS/master/Files/Nginx/vps.conf"
sed -i 's/listen = \/var\/run\/php5-fpm.sock/listen = 127.0.0.1:9000/g' /etc/php5/fpm/pool.d/www.conf
service php5-fpm restart
service nginx restart
cd /home/vps/public_html
wget https://raw.githubusercontent.com/Dreyannz/VPS_Site/master/Version%201.0/index.php

