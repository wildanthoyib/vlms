<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->


		<title>Validation Logic Management Systems - PDDIKTI</title>
		<meta name="Wildan Toyib" title="Lead Developer" content="Direktorat Pembelajaran dan Kemahasiswaan" class="Direktorat Jenderal Pendidikan Tinggi" object="Kementerian Pendidikan dan Kebudayaan Republik Indonesia">
		<meta name="M. Caesar .A" title="Developer" content="Direktorat Pembelajaran dan Kemahasiswaan" class="Direktorat Jenderal Pendidikan Tinggi" object="Kementerian Pendidikan dan Kebudayaan Republik Indonesia">


		<!-- Use the correct meta names below for your web application
			 Ref: http://davidbcalhoun.com/2013/viewport-metatag

		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">-->

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/smartadmin-production.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/smartadmin-skins.css">

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets') ?>/pedp.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/pedp.css">


		<!-- FAVICONS -->
		<link rel="shortcut icon" href="<?php echo base_url('/assets/smartadmin') ?>/img/favicon/dikbud.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo base_url('/assets/smartadmin') ?>/img/favicon/dikbud.ico" type="image/x-icon">

	</head>
	<body class="fixed-header fixed-navigation fixed-ribbon">
		<!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->

		<!-- HEADER -->
		<header id="header">
			<!-- projects dropdown -->
			<div id="project-context">

				<!--<span class="nav-bar" href="<?php echo site_url("#") ?>"><img src="<?php echo base_url('/assets') ?>/img/logo-dikbud.png" width="44" height="34"  class="logo" alt="Logo Kemdikbud">
				Direktorat Pembelajaran dan Kemahasiswaan - Direktorat Jenderal Pendidikan Tinggi - Kementerian Pendidikan dan Kebudayaan</span>
				<h3>Manajemen Monitoring dan Evaluasi Peningkatan Mutu Pendidikan Politeknik</h3>
				-->

				<img src="<?php echo base_url('/assets') ?>/img/logo-dikbud.png" width="52" height="42" class="pull-left"><a href="<?php echo site_url("#") ?>" class="logo-title"><font color="white">Validation Logic Management System <br />Pangkalan Data Pendidikan Tinggi</font></a>

			</div>
			<!-- end projects dropdown -->

		</header>
		<!-- END HEADER -->


	<!-- MAIN PANEL -->
	<div id="main-login" role="main">

		<!-- RIBBON -->
		<div id="ribbon" style="color:blue;">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
			<strong>Login VLMS - PDDIKTI <br /> </strong>	
			</ol>
			<!-- end breadcrumb -->
		</div>
		<!-- END RIBBON -->

		<!-- MAIN CONTENT -->
		<div id="content">
        <?php echo $main_content ?>
		</div>
		<!-- END MAIN CONTENT -->

	</div>
	<!-- END MAIN PANEL -->

	<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
	Note: These tiles are completely responsive,
	you can add as many as you like
	-->
	<div id="shortcut">
		<ul>
			<li>
				<a href="javascript:void(0);" class="jarvismetro-tile big-cubes bg-color-green"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>Ubah Profile </span> </span> </a>
			</li>
			<li>
				<a href="#index.html" class="jarvismetro-tile big-cubes bg-color-red"> <span class="iconbox"> <i class="fa fa-sign-out fa-4x"></i> <span>Logout</span> </span> </a>
			</li>
		</ul>
	</div>
	<!-- END SHORTCUT AREA -->
	
	<div class="footer" style="background-color:#333;height:100px;margin-top:0px;text-align:center;font-size:7pt;">
			<font color="white" >
			DISCLAIMER : Semua Data Yang Ditampilkan Pada Laman Ini, Adalah Berasal Dari Pelaporan Data Perguruan Tinggi (Kementerian Pendidikan Tinggi, Riset dan Teknologi Tidak Menambah, Mengubah Dan Menghapus Data Tanpa Ada Permintaan Dari Perguruan Tinggi). Apabila Ada Pihak Lain Yang Ingin Memanfaatkan Data Ini Untuk Kepentingan Umum Agar Mengajukan Perijinan Terlebih Dahulu Ke Direktur Jenderal Pembelajaran dan Penjaminan Mutu. 
Copyright ©2015 - Kementerian Pendidikan Tinggi, Riset dan Teknologi. 
			</font>
	</div>
	
    <script src="<?php echo base_url('/assets/smartadmin') ?>/js/libs/jquery-2.0.2.min.js"></script>

	<!-- BOOTSTRAP JS -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/bootstrap/bootstrap.min.js"></script>

	<!--[if IE 7]>

	<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

	<![endif]-->

	<!-- MAIN APP JS FILE -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/app.js"></script>
	<!-- PEDP JS -->
	<script src="<?php echo base_url('/assets') ?>/pedp.js"></script>
	<script src="<?php echo base_url('/assets') ?>/login.js"></script>
	<!-- Optinmasi page-->
	<script src="<?php echo base_url('/assets/js'); ?>/optimasi.js" type="text/javascript"></script>
	
</body>
</html>
