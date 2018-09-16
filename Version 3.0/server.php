<?php
$site_name        = "LadyClare";
$site_description = "Provider of Quality SSH, SSL, VPN Accounts";
$site_template    = "lumen";

$daily_limit_user = "30";

$server_lists_array=array(
	1=>array(1=>"Singapore AWS","13.251.88.112","LadyClare","5"),
	2=>array(1=>"Germany AWS","18.184.9.161","LadyClare","5"),
	3=>array(1=>"London AWS","18.130.94.241","LadyClare","5"),

);

/* Service Variables */
$port_ssh= '22, 143, 81'; 			// SSH Ports
$port_dropbear= '443, 142, 82'; 		// Dropbear Ports
$port_ssl= 'n/a'; 				// SSL Ports
$port_squid= '3128, 8000, 8080'; 		// Squid Ports
$ovpn_client= ''.$hosts.'/client.ovpn';		// OpenVPN Client Config

?>
