<? if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<?php
	require_once 'library/connectionmysql.php';
	Connected();
	
	if($_SESSION['galaxy_posisi']=='none' || !isset($_SESSION['galaxy_posisi'])) { header("Location: ".URL_DIRECT); die; }
	if($_SESSION['galaxy_unit']=='none' || !isset($_SESSION['galaxy_unit'])) { header("Location: ".URL_DIRECT); die; }
	
	$rs_user=mysql_query("select * from tbl_admin where admin_kode = '".$_SESSION['galaxy_kode']."'");
	$rows_user=mysql_fetch_array($rs_user);
	
	$rs_units = mysql_query("select * from units where id = '".$_SESSION['galaxy_unit']."'");
	$cnt_units =mysql_num_rows($rs_units);
	$rows_units=mysql_fetch_array($rs_units);

	$admin_type['0'] = 'Super Admin';
	$admin_type['1'] = 'Admin';
	$admin_type['2'] = 'User';
	
	if($cnt_units>0)
		$header = $rows_units['name'];
	
	$userName = $rows_user['admin_full_name'];
	
	if($rows_user['admin_photo_small']) {
		if(file_exists('photo/small/'.$rows_user['admin_photo_small'])) {
			list($width, $height) = getimagesize('photo/small/'.$rows_user['admin_photo_small']);
			$photo_small = 'photo/small/'.$rows_user['admin_photo_small'];
		} else{	
			if($rows_user['admin_gender']=='1') {
				$photo_small = 'photo/small/cew.gif';
			}elseif($rows_user['admin_gender']=='0') {
				$photo_small = 'photo/small/cow.gif';
			}
		}
	} else{
		if($rows_user['admin_gender']=='1') {
			$photo_small = 'photo/small/cew.gif';
		}elseif($rows_user['admin_gender']=='0') {
			$photo_small = 'photo/small/cow.gif';
		}
	}
		//
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>GALAXY ACCOUNTING SYSTEM<? echo $header?></title>
	<link rel="shortcut icon" href="images/logo.png" />

    <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/base/jquery.ui.all.css">
    
    <link rel="stylesheet" href="css/reset2.css" type="text/css" media="screen" />
    
	<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.custom.js"></script>
    <!--<script type="text/javascript" src="js/jquery.calculation.js"></script>-->
    
	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.js"></script>        
	<script type="text/javascript" src="js/ui/i18n/jquery.ui.datepicker-id.js"></script>
    <script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.position.js"></script>
	<script src="js/ui/jquery.ui.autocomplete.js"></script>
    <link rel="stylesheet" href="css/demos.css">
    <script type="text/javascript">
	tday  =new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	
	function GetClock(){
		d = new Date();
		nday   = d.getDay();
		nmonth = d.getMonth();
		ndate  = d.getDate();
		nyear = d.getYear();
		nhour  = d.getHours();
		nmin   = d.getMinutes();
		nsec   = d.getSeconds();
		
		if(nyear<1000) nyear=nyear+1900;
			 if(nhour ==  0) {ap = " AM";nhour = 12;} 
		else if(nhour <= 11) {ap = " AM";} 
		else if(nhour == 12) {ap = " PM";} 
		else if(nhour >= 13) {ap = " PM";nhour -= 12;}
		
		if(nmin <= 9) {nmin = "0" +nmin;}
		if(nsec <= 9) {nsec = "0" +nsec;}
		
		
		document.getElementById('clockbox').innerHTML=""+nhour+":"+nmin+":"+nsec+ap+"";
		setTimeout("GetClock()", 1000);
	}
	window.onload=GetClock;
	</script>
    
    </head>
  
<body>
<div class="container">
	<div class="wrapper">   
    	<div class="header">
        	<div class="title-box">
            	<img class="t-logo" src="images/logo.png" />
            	<div class="title">GALAXY DEMO<br />
                <span class="lsub">Web-Based Accounting System</span><br />
                <span class="subs"><? echo $rows_units['name'];?></span>
                </div>
                
                <div class="account-logout" link="<? echo URL_DIRECT?>">Log out</div>
                
                <div type="popup" link="profil?0" mode="0" class="account-panel"><? echo $userName; ?></div>
                <div class="user-box"><img src="<? echo $photo_small;?>"/></div>
            </div>
        </div>    	
		<div class="shadow-wrapper">        	
   	  	<div class="content">
        	<div class="nav-box">
            	<div class="info"><font style=" font-size:18px; color:#ffffff;"><? echo indonesian_date (); ?></font><br /><font style="font-size:32px; color:#FF0;"><div id="clockbox"></div></font></div>
            	<div class="sub-nav-box">	
					<ul class="sub-nav-button">  
                      <?php 
						$qry_menu = ''; $qry_access = "";
						$qry_menu = "select * from tbl_menu order by menu_kode";
												
						$rs_menu = mysql_query($qry_menu);
						$i = 0;
						
						while($rows_menu=mysql_fetch_array($rs_menu)) {
						if($_SESSION['galaxy_type']=='0') {
							$qry_submenu = "select * from tbl_submenu where menu_kode = '".$rows_menu['menu_kode']."' order by submenu_kode ASC";
						} else {
							$qry_submenu = "select * from tbl_submenu where menu_kode = '".$rows_menu['menu_kode']."' order by submenu_kode ASC";
							//$qry_submenu = "select * from tbl_submenu where units_kode = '".$_SESSION['galaxy_unit']."' and menu_kode = '".$rows_menu['menu_kode']."'";
						}
						
						$rs_access = mysql_query("select * from  tbl_permissions where admin_kode = '".$_SESSION['galaxy_kode']."' and menu_kode = '".$rows_menu['menu_kode']."'");
						$rows_access=mysql_fetch_array($rs_access);
						$rs_submenu = mysql_query($qry_submenu);
						$cnt_submenu = mysql_num_rows($rs_submenu);
						
						if($rows_access['permissions_view']!='1') {
						if($cnt_submenu>0) { 
						?>
                      	<li>
                            <div class="<? if($i==0) echo 'nav-ul-selected'; else echo 'nav-ul'; ?>" link="<? echo $rows_menu['menu_link'] ?>"><? echo $rows_menu['menu_name'] ?></div> 
                            <ul class="sub-nav-menu">
                            <?php
							if($_SESSION['galaxy_type']=='0')
								$qry_submenus = "select * from tbl_submenu where menu_kode = '".$rows_menu['menu_kode']."' order by submenu_kode ASC";
							else 
								$qry_submenus = "select * from tbl_submenu where menu_kode = '".$rows_menu['menu_kode']."' order by submenu_kode ASC";
								
							$rs_submenu = mysql_query($qry_submenus);
							$cnt_submenu = mysql_num_rows($rs_submenu);
							if($cnt_submenu>0) {
							while($rows_submenu=mysql_fetch_array($rs_submenu)) {
								
							$qry_subaccess = "select * from  tbl_permissions where admin_kode = '".$_SESSION['galaxy_kode']."' and submenu_kode = '".$rows_submenu['submenu_kode']."'";
							$rs_sub_access = mysql_query($qry_subaccess);
							$rows_sub_access=mysql_fetch_array($rs_sub_access);
							if($rows_sub_access['permissions_view']!='1') {
								if($i==0) { $link = $rows_submenu['menusub_link']; $selected = '-selected'; } else $selected = '';
							?>
                                <li  title="<? echo $rows_submenu['submenu_name'] ?>"><div class="tab<? echo $selected?>" link="<? echo $rows_submenu['menusub_link'] ?>"><? echo $rows_submenu['submenu_name'] ?></div></li>
                             <?php
							$i++;
							}
							}
							}
							?>   
                            </ul>   
                        </li>
                        <?php
						$i++;
						}
						}
						}
						?> 
                    </ul>
        		</div>
           </div>
            	<div class="body">
                    <div class="sub-content">
                        <?php if($link) require_once($link.'.php') ?>
                    </div>
            	</div> 
            	
            </div>
        
        </div>
           
	</div><!-- End wrapper-->
</div> <!-- End contener-->
   
</body>
</html>
