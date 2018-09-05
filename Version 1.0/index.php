<?php
/* Site Data */
$site_name        = "LadyClare";
$site_description = "Provider of Quality SSH, SSL, VPN Accounts";
$site_template    = "lumen"; // (flatly, darkly, sketchy, lumen, materia)

/* Server Data */
/* Format: Server_Name, IP_Address, Root_Pass, Account_Validity */
/* Example: 1=>array(1=>"LadyClare Server 1","123.456.789","LadyClare","7"), */
/* Example: 2=>array(1=>"LadyClare Server 2","123.456.789","LadyClare","10"), */
$server_lists_array=array(
			2=>array(1=>"For Testing 1","123.123.123.123","Password","5"),
			3=>array(1=>"For Testing 2","123.123.123.123","Password","5"),
			4=>array(1=>"For Testing 3","123.123.123.123","Password","5"),
			5=>array(1=>"For Testing 4","123.123.123.123","Password","5"),
	);			



/* Service Port Variables */
	
$port_ssh= '22, 143';						// SSH Ports
$port_dropbear= '443, 110';					// Dropbear Ports
$port_ssl= '442';							// SSL Ports
$port_squid= '3128, 8080, 8888';			// Squid Ports
$ovpn_client= ''.$hosts.'/client.ovpn';		// OpenVPN Client Config


/* Dont Edit Any Part Of The Code If You Dont Know How It Works*/
for ($row = 1; $row < 101; $row++)
	{
	if ( $_POST['server'] == $server_lists_array[$row][1] )
		{
		$hosts= $server_lists_array[$row][2];
		$root_pass= $server_lists_array[$row][3];
		$expiration= $server_lists_array[$row][4];
		break;
		}
	}
$error = false;
if (isset($_POST['user'])) 
	{
		$username = trim($_POST['user']);
		$username = strip_tags($username);
		$username = htmlspecialchars($username);
		$password1 = trim($_POST['password']);
		$password1 = strip_tags($password1);
		$password1 = htmlspecialchars($password1);
		$cpassword = $_POST['confirmpassword'];
		$cpassword = strip_tags($cpassword);
		$cpassword = htmlspecialchars($cpassword);
		$password1 = $_POST['password'];
		$nDays = $expiration;
		$datess = date('m/d/y', strtotime('+'.$nDays.' days'));
		$password = escapeshellarg( crypt($password1) );
		
		if (empty($username)) 
			{
				$error = true;
				$nameError = "Please enter your username.";
			}
		else if (strlen($username) < 3) 
			{
				$error = true;
				$nameError = "Name must have atleat 3 characters.";
			}
		if (empty($password1))
			{
				$error = true;
				$passError = "Please enter password.";
			} 
		else if(strlen($password1) < 3) 
			{
				$error = true;
				$passError = "Password must have atleast 3 characters.";
			}
		if($password1 != $cpassword)
			{
				$error = true;
				$cpaseror = "Password Didn't match.";
			} 
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
								$cpassword = '';
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
							<div class="input-group">									
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-globe" style="color:red;"></i></span>
								</div>
								<select class="custom-select" name="server" >
									<option disabled selected value>Select Server</option> 
										<optgroup label="LadyClare Services">
											<?php
											for ($row = 1; $row < 101; $row++)
											{
												if ( !empty($server_lists_array[$row][1]))
												{
													echo '<option>'; echo $server_lists_array[$row][1]; echo '</option>';
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
							<span class="text-danger"><?php echo $nameError; ?></span>
						</div>
						<div class="form-group">
							<span class="text-danger"><?php echo $passError; ?></span>
						</div>
						<div class="form-group">
							<span class="text-danger"><?php echo $cpaseror; ?></span>
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
									<span class="input-group-text"><i class="fas fa-key" style="color:red;"></i></span>
								</div>
									<input type="text" class="form-control" id="confirm" placeholder="Confirm Password" name="confirmpassword" autocomplete="off" >
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
</body>
</html>
