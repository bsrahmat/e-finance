<? if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?
	require_once 'library/connectionmysql.php';
	Connected();
	
	

	if(isset($_SESSION['galaxy_posisi'])) if($_SESSION['galaxy_posisi']=='bissmillah_berhasil') header("Location: galaxy.php");
	if(!isset($_SESSION['galaxy_kode'])){
		if (!isset($_SESSION)) {
    		session_start();
		}		
		$_SESSION['galaxy_kode'] = 'none';
	}
	if(!isset($_SESSION['galaxy_posisi'])){
		if (!isset($_SESSION)) {
    		session_start();
		}
		$_SESSION['galaxy_posisi'] = 'none';
	}
	if(!isset($_SESSION['galaxy_type'])){
		if (!isset($_SESSION)) {
    		session_start();
		}
		$_SESSION['galaxy_type'] = 'none';
	}
	if(!isset($_SESSION['galaxy_unit'])){
		if (!isset($_SESSION)) {
    		session_start();
		}
		$_SESSION['galaxy_unit'] = 'none';
	}
?>
<?php

	$error = false;
	
	if (isset($_POST['galaxy']))
	{
		$valid = false;
		$redirect = isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : 'galaxy.php';
		$error = array();
		
		// Check fields
		if (!isset($_POST['login']) or strlen($_POST['login']) == 0)
		{
			$error[] = 'Please enter your user name';
		}
		elseif (!isset($_POST['pass']) or strlen($_POST['pass']) == 0)
		{
			$error[] = 'Please enter your password';
		}
		else
		{
		$rs = mysql_query("select * from tbl_admin where admin_name = '".strtolower($_POST['login'])."' and admin_pass = '".md5(strtolower($_POST['pass']))."'");
		$cnt = mysql_num_rows($rs);
		$rows = mysql_fetch_array($rs);
		if($cnt>0) {
			session_start();
			$_SESSION['galaxy_kode'] = $rows['admin_kode'];
			$_SESSION['galaxy_username'] = $rows['admin_name'];			
			$_SESSION['galaxy_full'] = $rows['admin_full_name'];
			$_SESSION['galaxy_posisi'] = 'bissmillah_berhasil';
			$_SESSION['galaxy_type'] = $rows['admin_type'];
			$_SESSION['galaxy_unit'] = $rows['unit_kode'];	
			$_SESSION['galaxy_status'] = $rows['admin_status'];				
			$valid = true;			
		}else {
				$error[] = 'Wrong user/password, please try again';
			}
		}
		
		// Check if AJAX request
		$ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		
		// If user valid
		if ($valid)
		{
			// Handle the keep-logged option
			if (isset($_POST['keep-logged']) and $_POST['keep-logged'] == 1)
			{
					
			}
			
			if ($ajax)
			{
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: '.date('r', time()+(86400*365)));
				header('Content-type: application/json');
				
				echo json_encode(array(
					'valid' => true,
					'redirect' => $redirect
				));
				exit();
			}
			else
			{
				header('Location: '.$redirect);
				exit();
			}
		}
		else
		{
			if ($ajax)
			{
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: '.date('r', time()+(86400*365)));
				header('Content-type: application/json');
				
				echo json_encode(array(
					'valid' => false,
					'error' => $error
				));
				exit();
			}
		}
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>

	<title>Login | Galaxy Demo Corporation</title>
	<meta charset="utf-8">
    <link href="css/reset.css" media="screen" rel="stylesheet" type="text/css"></link>
    <link href="css/common.css" media="screen" rel="stylesheet" type="text/css"></link>
    <link href="css/form.css" media="screen" rel="stylesheet" type="text/css"></link>
    <link href="css/standard.css" media="screen" rel="stylesheet" type="text/css"></link>
    <link href="css/special-pages.css" media="screen" rel="stylesheet" type="text/css"></link>

	<link rel="shortcut icon" href="images/logo.png" />
    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
	
	
</head>

<body class="special-page login-bg dark">
	<section id="login-block">
		<div class="block-border">
        	<div class="block-content">
			
			<h1>Galaxy Demo</h1>
			<div class="block-header">Please login</div>
				
			<?php
			
			if ($error)
			{
				?><p class="message error no-margin"><?php echo generateError($error); ?></p>
			
			<?php
			}
			
			?><form class="form with-margin" name="login-form" id="login-form" method="post" action="">
				<input type="hidden" name="galaxy" id="galaxy" value="send">
				<?php
				
				// Check if a redirect page has been forwarded
				if (isset($_REQUEST['redirect']))
				{
					?><input type="hidden" name="redirect" id="redirect" value="<?php echo htmlspecialchars($_REQUEST['redirect']); ?>">
				<?php
				}
				
				?><p class="inline-small-label">
					<label for="login"><span class="big">User name</span></label>
					<input type="text" name="login" id="login" class="full-width" value="<?php if (isset($_POST['login'])) { echo htmlspecialchars($_POST['login']); } ?>">
				</p>
				<p class="inline-small-label">
					<label for="pass"><span class="big">Password</span></label>
					<input type="password" name="pass" id="pass" class="full-width" value="">
				</p>
				
				<button type="submit" class="float-right">Login</button>
				<p class="input-height"></p>
			</form>
			
			
		</div>
        </div>
	</section>
</body>
</html>
