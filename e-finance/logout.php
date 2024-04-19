<?
	require_once 'library/connectionmysql.php';
	mysql_query("UPDATE tbl_admin SET admin_status = '1', admin_waktu = ".time()." WHERE admin_kode=".$_SESSION['galaxy_kode']);
	
	session_start();	
	$_SESSION['galaxy_kode'] = '';
	$_SESSION['galaxy_full'] = 'none';
	$_SESSION['galaxy_posisi'] = 'none';
	$_SESSION['galaxy_type'] = 'none';
	$_SESSION['galaxy_unit'] = 'none';		
	
	header("Location: ".URL_DIRECT);
?>