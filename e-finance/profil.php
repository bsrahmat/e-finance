<?php
	require_once 'library/connectionmysql.php';
	Connected();
	
	if($_SESSION['galaxy_unit']=='none') { require_once 'library/error-popup.php'; die; }
	
	if($_SESSION['galaxy_type']=='0')
	  $qry_admin = "select * from tbl_admin where admin_kode = '".$_SESSION['galaxy_kode']."'";
	else
	  $qry_admin = "select * from tbl_admin join  units ON  units.id = tbl_admin.unit_kode where admin_kode = '".$_SESSION['galaxy_kode']."'";
	
	 $rs_admin = mysql_query($qry_admin);
	 $rows_admin=mysql_fetch_array($rs_admin);
	 
	 $admin_type['0'] = 'Super Admin';
	 $admin_type['1'] = 'Admin';
	 $admin_type['2'] = 'User';
	 
	 $gender['0'] = 'Laki-laki';
	 $gender['1'] = 'Perempuan';
	 
	

	 
//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='0') { 
	$photo_name = ''; $isPhoto = false;
	if($rows_admin['admin_photo_large']) {
		$photo_name = $rows_admin['admin_photo_large'];
		if(file_exists('photo/large/'.$rows_admin['admin_photo_large'])) {
			$photo_large = 'photo/large/'.$rows_admin['admin_photo_large'];
			$isPhoto = true;
		} else{
			if($rows_admin['admin_gender']=='1') {
				$photo_large = 'photo/large/cew.gif';
			}elseif($rows_admin['admin_gender']=='0') {
				$photo_large = 'photo/large/cow.gif';
			}
		}
	} else{
		if($rows_admin['admin_gender']=='1') {
			$photo_large = 'photo/large/cew.gif';
		}elseif($rows_admin['admin_gender']=='0') {
			$photo_large = 'photo/large/cow.gif';
		}
	}
		
		
	list($width, $height) = getimagesize($photo_large);
		
	if($rows_admin['admin_photo_small'])
		if(file_exists('photo/small/'.$rows_admin['admin_photo_small'])) {
			$photo_small = $rows_admin['admin_photo_small'];
		} else{
			if($rows_admin['admin_gender']=='1') {
				$photo_small = 'photo/small/cew.gif';
			}elseif($rows_admin['admin_gender']=='0') {
				$photo_small = 'photo/small/cow.gif';
			}
		}
	else{
		if($rows_admin['admin_gender']=='1') {
			$photo_small = 'photo/small/cew.gif';
		}elseif($rows_admin['admin_gender']=='0') {
			$photo_small = 'photo/small/cow.gif';
		}
	}
	
	
		
?>

   <div class="popup-shadow" style="width: 650px;">
      <div class="popup-header">
         <span>Profil User</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      
      	<table>
         <tr>
         <td width="1%" align="center">
         	<img class="img-large" src="<? echo $photo_large; ?>" height="<? echo $height?>" />
            <input id="img_small" type="hidden" value="<? echo $photo_small?>" />
         </td>
         <td>
         	<table>
            <tr>
            <td width="25%"><b>Nama</b></td>
            <td width="2%">:</td>
            <td>
				<? echo $rows_admin['admin_full_name']?>
                <input id="usr_nm" type="hidden" value="<? echo $rows_admin['admin_full_name']?>" />
            </td>
            </tr>
            <tr>
            <td><b>Alamat</b></td>
            <td>:</td>
            <td><? echo $rows_admin['admin_alamat']?></td>
            </tr>
            <tr>
            <td><b>Tempat Lahir</b></td>
            <td>:</td>
            <td><? echo $rows_admin['admin_tempat_lahir']?></td>
            </tr>
            <tr>
            <td><b>Tanggal Lahir</b></td>
            <td>:</td>
            <td><? echo cTextDate($rows_admin['admin_tgl_lahir'])?></td>
            </tr>
            <tr>
            <td><b>Jenis Kelamin</b></td>
            <td>:</td>
            <td><? echo $gender[$rows_admin['admin_gender']]?></td>
            </tr>
            <tr>
            <td><b>Group User</b></td>
            <td>:</td>
            <td><? echo $admin_type[$rows_admin['admin_type']]?></td>
            </tr>
            <? if($_SESSION['galaxy_type']!='0') { ?>
            <tr>
            <td><b>Unit/Cabang</b></td>
            <td>:</td>
            <td><? echo $rows_admin['name']?></td>
            </tr>
            <? } ?>
            <tr>
            <td><b>Email</b></td>
            <td>:</td>
            <td><? echo $rows_admin['admin_email']?></td>
            </tr>
            <tr>
            <td><b>Telepon/Handphone</b></td>
            <td>:</td>
            <td><? echo $rows_admin['admin_phone']?></td>
            </tr>
            
            </table>
         </td>
         </tr>
      	</table>
        <script language="Javascript">
        	$('.admin-box').children('img').attr('src','photo/small/'+$('#img_small').val());
			$('.account-panel').html($('#usr_nm').val());
        </script>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
        <div class="input-button" type="popup" mode="1" link="profil?0">Ganti Foto</div>
        <? if($isPhoto) { ?>
        <div class="input-button" type="popup" mode="9" link="profil?0">Edit Thumb</div>
        <div class="input-button" type="popup" mode="3" link="profil?0">Hapus Foto</div>
        <? } ?>
        <div class="input-button" type="popup" mode="4" link="profil?0">Ganti Pass</div>
        <div class="input-button" type="popup" mode="7" link="profil?0">Edit User</div>
        <div class="input-button" type="popup" mode="5" link="profil?0">Edit Profil</div>
        
        
        
      </div>
   </div>

<? }  
//<!-- END FORM -->

//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='1') { 
	 	
?>
	
   <div class="popup-shadow" style="width: 400px;">
      <div class="popup-header">
         <span>Ganti Foto Profil</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/save-foto.php" method="post">
      <table>
      <tr>
      <td align="center">
      <b>Masukkan file gambar untuk foto profil</b><br />
      <input name="upload_foto" type="file" />
      </td>
      </tr>
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
        <div mode="6" link="profil?0&mod=0" class="popup-button">Simpan</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->

//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='2') { 
 
 	if($rows_admin['admin_photo_crop']) {
		if(file_exists('photo/crop/'.$rows_admin['admin_photo_crop'])) {
			list($width, $height) = getimagesize('photo/crop/'.$rows_admin['admin_photo_crop']);
			$photo_crop = 'photo/crop/'.$rows_admin['admin_photo_crop'];
		} else{
			if($rows_admin['admin_gender']=='1') {
				$photo_crop = 'photo/large/cew.gif';
			}elseif($rows_admin['admin_gender']=='0') {
				$photo_crop = 'photo/large/cow.gif';
			}
		}
	} else{
			if($rows_admin['admin_gender']=='1') {
				$photo_crop = 'photo/large/cew.gif';
			}elseif($rows_admin['admin_gender']=='0') {
				$photo_crop = 'photo/large/cow.gif';
			}
	}
	 	
?>
   <div class="popup-shadow" style="width: 400px;">
      <div class="popup-header">
         <span>Edit Foto Thumbnail</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/save-crop.php" method="post">
      <table>
      <tr>
      <td align="center">
      <img id="crop-image" src="<? echo $photo_crop; ?>"  width="<? echo $width; ?>" height="<? echo $height; ?>" /><br />
      <span style="font-size:11px;">Silahkan menggeser Kotak animasi diatas,<br />
      untuk mengambil foto profil yang diinginkan.</span>
      </td>
      </tr>
      </table>
      <input id="pos-x" name="pos-x" type="hidden" value="0" />
	  <input id="pos-y" name="pos-y" type="hidden" value="0" />
      </form>
      <script language="Javascript">$.fn.setCrop()</script>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="profil?0&mod=0" class="popup-button">Simpan</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->

//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='3') { 	 	
?>
   <div class="popup-shadow" style="width: 400px;">
      <div class="popup-header">
         <span>Hapus Foto</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/hapus-foto.php" method="post">
      <table>
      <tr>
      <td align="center">Apakah anda yakin untuk menghapus foto profil anda?.</td>
      </tr>
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="profil?0&mod=0" class="popup-button">Hapus</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->

//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='4') { 	 	
?>
   <div class="popup-shadow" style="width: 430px;">
      <div class="popup-header">
         <span>Ganti Password</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/ubah-password.php" method="post">
      <table>
      <tr>
      <td width="28%">Password Lama</td>
      <td width="2%">:</td>
      <td><input class="input-text" name="old_password" type="password" value="" /></td>
      </tr>
      <tr>
      <td>Password Baru</td>
      <td>:</td>
      <td><input class="input-text" name="new_password" type="password" value="" /></td>
      </tr>
      <tr>
      <td>rePassword Baru<br /><span style="font-size:11px;">Ketik Ulang</span></td>
      <td>:</td>
      <td><input class="input-text" name="renew_password" type="password" value="" /></td>
      </tr>
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="profil?0&mod=0" class="popup-button">Simpan</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->

//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='5') { 
	 	
?>
   <div class="popup-shadow" style="width: 500px;">
      <div class="popup-header">
         <span>Edit Profil User</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      		<form action="modul/user/profil.php" method="post">
         	<table>
            <tr>
            <td width="25%"><b>Nama</b></td>
            <td width="2%">:</td>
            <td><input class="input-text" name="fullname" type="text" value="<? echo $rows_admin['admin_full_name'] ?>" /></td>
            </tr>
            <tr>
            <td><b>Alamat</b></td>
            <td>:</td>
            <td><textarea rows="1" class="input-text" name="alamat" type="text"><? echo $rows_admin['admin_alamat'] ?></textarea></td>
            </tr>
            <tr>
            <td><b>Tempat Lahir</b></td>
            <td>:</td>
            <td><input style="width: 220px;" class="input-text" name="tempat_lahir" type="text" value="<? echo $rows_admin['admin_tempat_lahir'] ?>" /></td>
            </tr>
            <tr>
            <td><b>Tanggal Lahir</b></td>
            <td>:</td>
            <td><input class="input-text" name="tanggal_lahir" type="datepicker" value="<? echo cDate($rows_admin['admin_tgl_lahir']) ?>" /></td>
            </tr>
            <tr>
            <td><b>Jenis Kelamin</b></td>
            <td>:</td>
            <td>
            	<label style="float: left; width: 90px; height: 20px; color: black;"><input style="float: left; margin-right: 4px;" type="radio" name="gender" value="0" <? if($rows_admin['admin_gender']=='0') echo 'checked'; ?> />Male</label> 
        		<label style="float: left; width: 90px; height: 20px; color: black;"><input style="float: left; margin-right: 4px;" type="radio" name="gender" value="1" <?  if($rows_admin['admin_gender']=='1') echo 'checked'; ?> />Female</label> 
            </td>
            </tr>
            <tr>
            <td><b>Email</b></td>
            <td>:</td>
            <td><input style="width: 220px;" class="input-text" name="email" type="text" value="<? echo $rows_admin['admin_email'] ?>" /></td>
            </tr>
            <tr>
            <td><b>Telepon/Handphone</b></td>
            <td>:</td>
            <td><input class="input-text phone padmin" name="phone" type="text" value="<? echo $rows_admin['admin_phone'] ?>" /></td>
            </tr>
            
            </table>
            </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="profil?0&mod=0" class="popup-button">Simpan</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->

//<!-- =========================================================================================================================== -->
?>

<?
//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='6') {
	 $qry_admins = "select * from tbl_admin where admin_kode = '".$_GET['gid']."'";
	 $rs_admins = mysql_query($qry_admins);
	 $rows_admins=mysql_fetch_array($rs_admins); 	
?>
   <div class="popup-shadow" style="width: 400px;">
      <div class="popup-header">
         <span>Reset Password</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/reset-password.php" method="post">
      <table>
      <tr>
      <td align="center">Apakah anda yakin untuk Menreset password untuk User <b><? echo $rows_admins['admin_name']; ?></b>?<br /><b><u><i>Jika User di reset,  password sama dengan 1234</i></u></b></td>
      <input type="hidden" name="gid" value="<? echo $_GET['gid'] ?>" />
      </tr>
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="modul/user/daftar-user?<? echo $_GET['gid'] ?>&mod=1" class="popup-button">Reset Password</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->
 if($_GET['mod']=='7') { 	 	
?>
   <div class="popup-shadow" style="width: 430px;">
      <div class="popup-header">
         <span>Ganti User</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/ubah-user.php" method="post">
      <table>
      <tr>
      <td width="28%">User Lama</td>
      <td width="2%">:</td>
      <td><? echo $rows_admin['admin_name']?></td>
      </tr>
      <tr>
      <td>User Baru</td>
      <td>:</td>
      <td><input class="input-text" name="admin_name" type="text" value="" /></td>
      </tr> 
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="profil?0&mod=0" class="popup-button">Simpan</div>
      </div>
   </div>

<? } 


//<!-- FORM TIPE MODE 0 = TAMBAH/ADD, TIPE MODE 1 = UBAH/EDIT -->
 if($_GET['mod']=='8') { 
	 	
?>
	
   <div class="popup-shadow" style="width: 400px;">
      <div class="popup-header">
         <span>Ganti Tanda Tangan</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/save-acc.php" method="post">
      <table>
      <tr>
      <td align="center">
      <b>Masukkan file gambar untuk Tanda Tangan</b><br />
      <input name="upload_foto" type="file" />
      </td>
      </tr>
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
        <div mode="6" link="profil?0&mod=0" class="popup-button">Simpan</div>
      </div>
   </div>

<? }  
//<!-- END FORM -->
 if($_GET['mod']=='9') { 	 	
?>
   <div class="popup-shadow" style="width: 400px;">
      <div class="popup-header">
         <span>Hapus Foto</span>
         <div class="popup-close">X</div>
      </div>
      <div class="popup-body">
      <form action="modul/user/hapus-ttd.php" method="post">
      <table>
      <tr>
      <td align="center">Apakah anda yakin untuk menghapus Tanda Tangan?.</td>
      </tr>
      </table>
      </form>
      </div>
      <div class="popup-footer">
      	<div class="popup-cancel">Batal</div>
      	<div mode="6" link="modul/master/manager-unit?<? echo $_GET['gid'] ?>&mod=1" class="popup-button">Hapus</div>
      </div>
   </div>

<? }  

//<!-- =========================================================================================================================== -->
?>


