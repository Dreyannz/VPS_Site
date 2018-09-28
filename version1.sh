#!/bin/bash
# Script by : _Dreyannz_
MYIP=$(wget -qO- ipv4.icanhazip.com);
clear
echo -e ""
echo -e "\e[94m[][][]======================================[][][]"
echo -e "\e[0m                                                   "
echo -e "\e[93m          Simple VPS Panel by _Dreyannz_          "
echo -e "\e[94m                                                  "
echo -e "\e[94m[][][]======================================[][][]\e[0m"
echo -e "\e[0m                                                   "
echo -e "\e[93m        Which Version Should Be Installed?        "
echo -e "\e[0m                                                   "
echo -e "\e[93m        [1] Version 1 (Simple Registration)       "
echo -e "\e[93m        [2] Version 2 (Free and VIP Options)      "
echo -e "\e[0m                                                   "
echo -e "\e[0m                                                   "
read -p "            Install Version [1-2] :  " Version
echo -e "\e[94m                                                  "
echo -e "\e[94m[][][]======================================[][][]\e[0m"
sleep 3
clear
echo -e "\e[0m                                                   "
echo -e "\e[94m[][][]======================================[][][]"
echo -e "\e[0m                                                   "
echo -e "\e[93m                Processing Request                "
echo -e "\e[94m                                                  "
echo -e "\e[94m[][][]======================================[][][]\e[0m"
sleep 3

apt-get update > /dev/null 2>1;
apt-get install nginx -y > /dev/null 2>1;
apt-get install libssh2-php -y > /dev/null 2>1;
apt-get install php5-fpm -y > /dev/null 2>1;
apt-get install php5-cli -y > /dev/null 2>1;

rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default
wget  --quiet -O /etc/nginx/nginx.conf "https://raw.githubusercontent.com/Dreyannz/AutoScriptVPS/master/Files/Nginx/nginx.conf"
mkdir -p /home/vps/public_html
wget  --quiet -O /etc/nginx/conf.d/vps.conf "https://raw.githubusercontent.com/Dreyannz/AutoScriptVPS/master/Files/Nginx/vps.conf"
sed -i 's/listen = \/var\/run\/php5-fpm.sock/listen = 127.0.0.1:9000/g' /etc/php5/fpm/pool.d/www.conf
service php5-fpm restart
service nginx restart
case $Version in
	1)
	cd /home/vps/public_html
	wget --quiet https://raw.githubusercontent.com/Dreyannz/VPS_Site/master/Version%201.0/index.php
	wget --quiet https://raw.githubusercontent.com/Dreyannz/VPS_Site/master/Version%201.0/v1_server_details.php
	wget --quiet https://www.ladyclare.ml/logo.png
	clear
	echo -e "\e[0m                                                   "
	echo -e "\e[94m[][][]======================================[][][]"
	echo -e "\e[0m                                                   "
	echo -e "\e[93m            Simple VPS Panel Installed            "
	echo -e "\e[93m      Dont Forget To Input The Server Details     "
	echo -e "\e[93m             at v1_server_details.php             "
	echo -e "\e[94m                                                  "
	echo -e "\e[93m                 "$MYIP
	echo -e "\e[94m                                                  "
	echo -e "\e[94m[][][]======================================[][][]\e[0m"
	exit
	;;
	2)
	cd /home/vps/public_html
	wget --quiet https://raw.githubusercontent.com/Dreyannz/VPS_Site/master/Version%202.0/index.php
	wget --quiet https://raw.githubusercontent.com/Dreyannz/VPS_Site/master/Version%202.0/v2_server_details.php
	wget --quiet https://www.ladyclare.ml/logo.png
	clear
	echo -e "\e[0m                                                   "
	echo -e "\e[94m[][][]======================================[][][]"
	echo -e "\e[0m                                                   "
	echo -e "\e[93m            Simple VPS Panel Installed            "
	echo -e "\e[93m      Dont Forget To Input The Server Details     "
	echo -e "\e[93m             at v2_server_details.php             "
	echo -e "\e[94m                                                  "
	echo -e "\e[93m                 "$MYIP
	echo -e "\e[94m                                                  "
	echo -e "\e[94m[][][]======================================[][][]\e[0m"
	exit
	;;
esac
