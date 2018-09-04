#!/bin/bash
rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default
wget -O /etc/nginx/nginx.conf "https://raw.githubusercontent.com/Dreyannz/AutoScriptVPS/master/Files/Nginx/nginx.conf"
mkdir -p /home/vps/public_html
wget -O /etc/nginx/conf.d/vps.conf "https://raw.githubusercontent.com/Dreyannz/AutoScriptVPS/master/Files/Nginx/vps.conf"
service nginx restart
cd /home/vps/public_html/
wget https://raw.githubusercontent.com/Dreyannz/LadyClare.ml/master/index.php
