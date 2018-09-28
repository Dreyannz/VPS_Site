<?php


/* Site Data */
$site_name        = "LadyClare";
$site_description = "Provider of Quality SSH, SSL, VPN Accounts";
$site_template    = "lumen"; // (flatly, darkly, sketchy, lumen, materia)


/* Server Data */
/* Format: Server_Name, IP_Address, Root_Pass, Account_Validity */
/* Example: 1=>array(1=>"LadyClare Server 1","123.456.789","LadyClare","5"), */

$server_lists_array=array(
			1=>array(1=>"Sample 1","123.123.123.123","LadyClare","5"),
			2=>array(1=>"Sample 2","123.123.123.123","LadyClare","5"),
			3=>array(1=>"Sample 3","123.123.123.123","LadyClare","5"),
	);			


/* Service Variables */	
$port_ssh= '22, 143'; 				// SSH Ports
$port_dropbear= '443, 110'; 			// Dropbear Ports
$port_ssl= '442'; 				// SSL Ports
$port_squid= '3128, 8080, 8888'; 		// Squid Ports
$ovpn_client= ''.$hosts.'/client.ovpn';		// OpenVPN Client Config
?>
