<?php
/* Site Data */
/* invite_code_master is the Invite Code that the VIP Users will be using on the site */
/* free_user_exp is the active days for Free Users */
/* vip_user_exp is the active days for VIP Users */

$site_name        = "LadyClare";
$site_description = "Provider of Quality SSH, SSL, VPN Accounts";
$site_template    = "lumen";
$invite_code_master = "LadyClare";
$free_user_exp = "3";
$vip_user_exp = "15";


/* Server Data */
/* Format: Server_Name, IP_Address, Root_Pass, User_Type */
/* Example_1: 1=>array(1=>"LadyClare Server 1","123.456.789","LadyClare","VIP"), */
/* Example_2: 2=>array(1=>"LadyClare Server 2","123.456.789","Dreyannz","Free"), */

$server_lists_array=array(
			1=>array(1=>"For Testing 1","123.123.123.123","Password","Free"),
			2=>array(1=>"For Testing 2","123.123.123.123","Password","VIP"),
			3=>array(1=>"For Testing 3","123.123.123.123","Password","VIP"),
			4=>array(1=>"For Testing 4","123.123.123.123","Password","Free"),
	);			



/* Service Ports Variables */
	
$port_ssh= '22, 143, 81';					// SSH Ports
$port_dropbear= '443, 142, 82';				// Dropbear Ports
$port_ssl= 'n/a';							// SSL Ports
$port_squid= '3128, 8080, 8080';			// Squid Ports
$ovpn_client= ''.$hosts.'/client.ovpn';		// OpenVPN Client Config



/* Dont Edit Any Part Of The Code If You Dont Know How It Works*/
$error = false;
if (isset($_POST['user'])) 
	{
		$username = trim($_POST['user']);
		$username = strip_tags($username);
		$username = htmlspecialchars($username);
		$password1 = trim($_POST['password']);
		$password1 = strip_tags($password1);
		$password1 = htmlspecialchars($password1);
		$invite_code = $_POST['invite'];
		$invite_code = strip_tags($invite_code);
		$invite_code = htmlspecialchars($invite_code);
		
		
		
		if (empty($username)) 
			{
				$error = true;
				$nameError = "Please Input A Username.";
			}
		else if (strlen($username) < 3) 
			{
				$error = true;
				$nameError = "Username Must Have Atleat 3 Characters.";
			}
		if (empty($password1))
			{
				$error = true;
				$passError = "Please Input Password.";
			} 
		else if(strlen($password1) < 3) 
			{
				$error = true;
				$passError = "Password Must Have Atleast 3 Characters.";
			}
		for ($row = 1; $row < 101; $row++)
			{
			if ( $_POST['server'] == $server_lists_array[$row][1] )
				{
				if ( $server_lists_array[$row][4] == "VIP" )
					{
						if ( !empty($invite_code))
							{
								if ( $invite_code != $invite_code_master )
									{
										$error = true;
										$inviteError = "Invite Code Is Incorrect";
									}
								else
									{
										$hosts= $server_lists_array[$row][2];
										$root_pass= $server_lists_array[$row][3];
										
										break;
									}
							}
						else
							{
								$error = true;
								$inviteError = "Please Input Invite Code";
							}				
					}
				elseif ( $server_lists_array[$row][4] == "Free" )
					{
						$hosts= $server_lists_array[$row][2];
						$root_pass= $server_lists_array[$row][3];
						
						break;
					}
				}
			}
		if ( $_POST['user_type'] == "VIP User")
			{
				if ( empty($invite_code))
					{
						$error = true;
						$inviteError = "Please Input Invite Code";
					}
				else
					{
						$expiration= $vip_user_exp;
					}
				
			}
		elseif ( $_POST['user_type'] == "Free User")
			{
				if ( empty($invite_code))
				{
					$expiration= $free_user_exp;
				}
				else
				{
					$error = true;
					$inviteError = "Invite Code If For VIP Users Only";
				}
			}

		$password1 = $_POST['password'];
		$nDays = $expiration;
		$datess = date('m/d/y', strtotime('+'.$nDays.' days'));
		$password = escapeshellarg( crypt($password1) );
		if( !$error ) 
			{
				date_default_timezone_set('UTC');
				date_default_timezone_set("Asia/Manila"); 
				$my_date = date("Y-m-d H:i:s"); 
				$connection = ssh2_connect($hosts, 22);
				if (ssh2_auth_password($connection, 'root', $root_pass)) 
					{
						$show = true;	 
						ssh2_exec($connection, "useradd $username -m -p $password -e $datess -d  /tmp/$username -s /bin/false");
						$succ = 'Added Succesfully';
						if ($res) 
							{
								$errTyp = "success";
								$errMSG = "Successfully registered, you may Check your credentials";
								$username = '';
								$password = '';
							} 
						else 
							{
								$errTyp = "danger";
								$errMSG = "Something went wrong, try again later..."; 
							} 
					} 
				else 
					{
						die('Connection Failed...');
					}	
			}   
	} 
?>







<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />  
<title><?php echo $site_name;?>   |   <?php echo $site_description;?>   |   </title>
    	<script language='JavaScript'>
        var txt = '   ' + document.title + '   '
        var speed = 400;
        var refresh = null;
        function site_name() 
		{
            		document.title = txt;
            		txt = txt.substring(1, txt.length) + txt.charAt(0);
            		refresh = setTimeout("site_name()", speed);
        	}
        site_name();     
    </script>
<link rel="shortcut icon" type="image/x-icon" href="/logo.png" height="200" width"200">
<meta name="description" content="<?php echo $site_description;?>"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.1/<?php echo $site_template;?>/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
</head>
<body>
	<div class="navbar navbar-expand-lg navbar-dark bg-danger">
		<div class="container">
			<a class="navbar-brand" href="/"><?php echo $site_name;?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigatebar" aria-controls="navigatebar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navigatebar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="https://www.phcorner.net/members/745093/">PHCorner</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<header id="header" align="center">
		<img src="/logo.png" alt="" height="250" width"250"/>
	</header>
	<div align="center">
        	<div class="col-md-4" align="center">
				<div align="center">
    					<div align="center" class="card-body">
							<form method="post" align="center" class="softether-create">
								<div class="form-group">	
										<?php
											if($show == true) 
												{
													echo '<div class="card border-danger">';
													echo '<table class="table-danger">';
													echo '<tr>'; echo '<td> </td>'; echo '<td> </td>'; echo '</tr>';			
													echo '<tr>'; echo '<td>Host</td>'; echo '<td>'; echo $hosts; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>Username</td>'; echo '<td>'; echo $username; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>Password</td>'; echo '<td>'; echo $password1; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>Server</td>'; echo '<td>'; echo $_POST['server']; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>User Type</td>'; echo '<td>'; echo $_POST['user_type']; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>SSH Port</td>'; echo '<td>'; echo $port_ssh; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>Dropbear Port</td>'; echo '<td>'; echo $port_dropbear; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>SSL Port</td>'; echo '<td>'; echo $port_ssl; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>Squid Port</td>'; echo '<td>'; echo $port_squid; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>OpenVPN Config</td>'; echo '<td>';echo '<a href="http://';echo $hosts; echo "/"; echo "client.ovpn"; echo'">download config</a>'; echo '</td>'; echo '</tr>';
													echo '<tr>'; echo '<td>Expiration Date</td>'; echo '<td>'; echo $datess; echo '</td>'; echo '</tr>';																							
													echo '<tr>'; echo '<td> </td>'; echo '<td> </td>'; echo '</tr>';
													echo '</table>';
													echo '</div>';
												}										
										?>
								</div>
								<div class="form-group">
									<span class="text-danger"><?php echo $nameError; ?></span>
								</div>
								<div class="form-group">
									<span class="text-danger"><?php echo $passError; ?></span>
								</div>
								<div class="form-group">
									<span class="text-danger"><?php echo $inviteError; ?></span>
								</div>
								<div class="form-group">
									<div class="input-group">									
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-globe" style="color:red;"></i></span>
										</div>
										<select class="custom-select" name="server" required>
											<option disabled selected value>Select Server</option> 
												<optgroup label="VIP Servers">
													<?php
														for ($row = 1; $row < 101; $row++)
														{
															if (( $server_lists_array[$row][4] == VIP ))
															{
																echo '<option>';echo $server_lists_array[$row][1]; echo '</option>';
															}
															elseif ( $server_lists_array[$row][4] == Free )
															{
																continue;
															}
															else
															{
																break;
															}
														}
													?>
												</optgroup>
												<optgroup label="Free Servers">
													<?php
														for ($row = 1; $row < 101; $row++)
														{
															if (( $server_lists_array[$row][4] == Free ))
															{
																echo '<option>';echo $server_lists_array[$row][1]; echo '</option>';
															}
															elseif ( $server_lists_array[$row][4] == VIP )
															{
																continue;
															}
															else
															{
																break;
															}
														}
													?>	
												</optgroup>												
										</select> 
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">									
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-crown" style="color:red;"></i></span>
										</div>
										<select class="custom-select" name="user_type" required>
											<option disabled selected value>Type Of User</option> 
											<option>Free User</option>
											<option>VIP User</option>												
										</select> 
									</div>
								</div>
								<div class="form-group">								
									<div class="input-group">									
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user-circle" style="color:red;"></i></span>
										</div>
										<input type="text" class="form-control" id="username" placeholder="Username" name="user" autocomplete="off" >
									</div>							
								</div>					
								<div class="form-group">								
									<div class="input-group">
									<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-key" style="color:red;"></i></span>
										</div>
										<input type="text" class="form-control" id="password" placeholder="Password" name="password" autocomplete="off"  >
									</div>								
								</div>								
								<div class="form-group">									
									<div class="input-group">									
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-code" style="color:red;"></i></span>
										</div>
										<input type="text" class="form-control" id="confirm" placeholder="Invite Code (VIP Users)" name="invite" autocomplete="off" >
									</div>
								</div>													
								<div class="form-group ">								
									<button type="submit" id="button" class="btn btn-danger btn-block btn-action">CREATE ACCOUNT</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
