<?php

// More Information at
// https://exain.wordpress.com/2017/08/09/how-to-securely-open-ports-ssh-rdp-etc-on-demand-for-dynamic-ips-through-iptables

// Configuration - START --
$password = "randompassword123"; // Change Password
$port = 22; // Port to be opened
// Configuration - ENDS  --


if (isset($_POST)) {

	$ipaddr = $_POST[ipaddr];
	$pw = $_POST[pw];
	$bgcolor = 'white';

	// Validate IP Address
	if ($ipaddr != '' && filter_var($ipaddr, FILTER_VALIDATE_IP)) {

		if ($pw == $password && ($port > 1 && $port <= 65535)) {

			// iptables command to execute
			exec("sudo /sbin/iptables -A INPUT -p tcp --dport $port -s $ipaddr -j ACCEPT");
			// show a color when password is correct
			$bgcolor = 'lime';

		} else {
			// show a different color when password is incorrect
			$bgcolor = 'red';
		}
	}
}
?>
<!doctype html>
<html>
<head>
	<title>Open Port <?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0">

	<style>
		div, input, form {
			text-align:left; font-family:monospace;font-size:14px;
		}
		input {
			border: 1px solid #444444; padding:10px;margin:10px;
		}
	</style>

</head>

<body>

<P>&nbsp;</P>

<div style="width:450px;margin:0 auto;">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method=post style="text-align:left;fonf-family:fixed;">
	<strong><h3>Open Port</h3></strong><BR>
	Enter Password : <input type=password name=pw autocomplete=off id=pw><BR>
	Enter IP Addr&nbsp; : <input type=text autocomplete=off style="text-align:right;background-color:<?php echo $bgcolor;?>" value="<?=$_SERVER[REMOTE_ADDR];?>" name=ipaddr>: <strong><?php echo $port; ?></strong><BR>
	<input style="margin-left:0px;" type=submit value='Open Port'>
	<P>
	<a href='<?php echo $_SERVER['PHP_SELF']; ?>?rand=<?php echo rand(); ?>'>Refresh</a><BR>
	Current IP: <?php echo $_SERVER[REMOTE_ADDR];?>
</form>

</div>


<script>
	document.getElementById('pw').focus();
</script>

</body>
</html>
