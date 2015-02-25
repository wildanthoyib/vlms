<?php
$page_title = 'Login';
$include_chart = '';
ob_start();
?>
<p align="center">
    <?php 
    $h = "-7";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
    $hm = $h * 60; 
    $ms = $hm * 60;
    $gmdate = gmdate("d/F/Y ~ g:i:s A", time()-($ms)); // the "-" can be switched to a plus if that's what your time zone is.
    echo "Saat ini:  $gmdate. ";
    ?>
</p>
				
<div class="panel panel-default login-box">

<div class="panel-heading">Silahkan Masukkan <strong>username dan password</strong> anda</div>
<div class="panel-body">
<form action="<?php print site_url('/login/check_login'); ?>" method="post" class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Username</label>
    <div class="col-lg-10">
      <input type="username" name="username" class="form-control" id="username" placeholder="Nama Pengguna" />
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label"> Password</label>
    <div class="col-lg-10">
      <input type="password" name="password" class="form-control" id="password" placeholder="Kata Sandi" />
    </div>
  </div>
  <!--
  <div class="form-group">
    <label for="inputPilihan1" class="col-lg-2 control-label">Level</label>
    <div class="col-lg-10">
	  	<select class="form-control" name="choice">
			<option value="0">-- Pilih --</option>
			<option value="1">Admin</option>
			<option value="2">Koordinator</option>
		</select>
    </div>
  </div>
  -->
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <input type="submit" value="Silahkan Login" class="btn btn-primary" />
    </div>
  </div>
</form>
</div>
</div>

<div id="shadow" class="popup"></div>

<div>

<p align="center"> 
Seluruh data di sistem informasi <strong>VLMS-PDDIKTI</strong> ini telah dienkripsikan/disandikan oleh <br />
<a href="http://www.positiveSSL.com" class="ssl">
<img src="http://www.positivessl.com/images-new/PossitiveSSL_tl_trans2.gif" alt="SSL Cerficate" title="SSL Certificate" width="64px" height="64px" border="0" />
</a>
<br />untuk menjamin keamanan transaksi data & informasi anda.
  
</div></p>

<?php
$main_content = ob_get_clean();
require './assets/smartadmin/login.tpl.php';
