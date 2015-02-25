<!DOCTYPE html>
<?php $current_url = current_url() ?>
<html dir="ltr" lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title>Validation Logic Management System - PDDIKTI</title>
		<meta name="Verifikasi dan Validasi" content="Validator Verifikasi dan Validasi Content Management System PDDIKTI">
		<meta name="VCMS PDDIKTI" class="Kemristekdikti" content="VCMS 2015-2020">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/smartadmin-production.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/smartadmin-skins.css">

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets') ?>/pedp.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/pedp.css">
		<link rel="Stylesheet" type="text/css" href="<?php echo base_url('/assets') ?>/css/smoothDivScroll.css" />

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

				<img src="<?php echo base_url('/assets') ?>/img/logo-dikbud.png" width="52" height="42" class="pull-left"><a href="<?php echo site_url("#") ?>" class="logo-title"><font color="white">Validation Logic Management System<br /> Pangkalan Data Pendidikan Tinggi</font></a>

			</div>
			<!-- end projects dropdown -->

			<!-- pulled right: nav area -->
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?php echo site_url('/login/logout') ?>" title="Sign Out"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- search mobile button (this is hidden till mobile view port) -->
				<div id="search-mobile" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
				</div>
				<!-- end search mobile button -->

			<p class="navbar-text"><i class="glyphicon glyphicon-calendar"></i>	
			<font color="white">
				   <?php 
				      $h = "-7";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
				      $hm = $h * 60; 
				      $ms = $hm * 60;
				      $gmdate = gmdate("D, d/F/Y. g:i:s A", time()-($ms)); // the "-" can be switched to a plus if that's what your time zone is.
				      echo "<strong> $gmdate </strong>";
				    ?>
			</font>
			</p>
				   
				<!-- input: search field -->
				<form action="#search.html" class="header-search pull-right">
					<input type="text" placeholder="Cari data VLMS" id="search-fld">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
					<a href="javascript:void(0);" id="cancel-search-js" title="Batalkan Pencarian"><i class="fa fa-times"></i></a>
				</form>
				<!-- end input: search field -->

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->

		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">

			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" id="show-shortcut">
						<img src="<?php echo base_url('/assets/smartadmin') ?>/img/avatars/sunny.png" alt="me" class="online" />
						<span>
							<?php echo $user_data['realname'] ?>
						</span>
						<i class="fa fa-angle-down"></i>
					</a>

				</span>
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive

			To make this navigation dynamic please make sure to link the node
			(the reference to the nav > ul) after page load. Or the navigation
			will not initialize.
			-->
			<nav>

<!-- START NAV PEDP -->

<ul>
<li>
<a href="<?php echo base_url("#") ?>"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
</li>

<?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups'] || 'piu' == $user_data['groups'] || 'reviewer' == $user_data['groups']) : ?><!-- awal menu untuk PIU dan PMU -->
<!--
Menu untuk grafik from dimas
<li class="<?php if (stripos($current_url, '/graphics')) { echo 'open'; } ?>">
<a href="#" title="Graphics and Diagrams"><i class="fa fa-bar-chart-o fa-lg fa-fw"></i><span class="menu-item-parent">Graphics and<br /> Chart</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/graphics')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/graphics/index/pedp') ?>" title="Plan vs Realization for PEDP"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i>Plan vs Realization<br /> for PEDP</a>
</li>
<li>
	<a href="<?php echo site_url('/graphics/index/piu') ?>"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i>Plan vs Realization<br /> for PIU</a>
</li>
<li>
	<a href="<?php echo site_url('/graphics/index/schema') ?>" title="Plan vs Realization for Schema"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i>Plan vs Realization<br /> for Schema</a>
</li>
</ul>
</li>
-->
<?php endif; ?>

<?php if ( 'admin' == $user_data['groups'] || 'piu' == $user_data['groups'] || 'pmu' == $user_data['groups']) : ?><!-- awal menu untuk PIU dan PMU -->

<li class="<?php if (stripos($current_url, '/rpp') || stripos($current_url, '/proc/') || stripos($current_url, '/non_proc/')) { echo 'open'; } ?>">
  <a href="#"><i class="fa fa-edit fa-lg fa-fw"></i><span class="menu-item-parent" title="Plan">Program Plan</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/rpp') || stripos($current_url, '/proc/') || stripos($current_url, '/non_proc/')) { echo ' style="display: block"'; } ?>>
<li>
  <a href="<?php echo site_url('/rpp') ?>"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>RPP/DIPA</a>
</li>
<li>
  <a href="<?php echo site_url('/proc/plan') ?>"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Procurement Plan</a>
</li>
<li>
  <a href="<?php echo site_url('/non_proc/plan') ?>"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Non-Procurement Plan</a>
</li>
<?php if ('pmu' == $user_data['groups']) : ?>
<li>
  <a href="<?php echo site_url('/rpp/approval') ?>"><i class="fa fa-lg fa-fw fa-table"></i>Rekapitulasi Rencana Pelaksanaan Proyek</a>
</li>
<?php endif; ?>
</ul>
</li>

<li class="<?php if (stripos($current_url, '/impl', 0)) { echo 'open'; } ?>">
	<a href="#" title="Realization and Implementation"><i class="fa fa-edit fa-lg fa-fw"></i><span class="menu-item-parent">Program Implementation<br/>- Contracted</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/impl', 0)) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/impl/proc') ?>" title="Procurement Implementation"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Procurement Implementation</a>
</li>
<li>
	<a href="<?php echo site_url('/impl/non_proc') ?>" title="Non-Procurement Implementation"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Non-Procurement <br />Implementation</a>
</li>
</ul>
</li>

<li>
  <a href="#" title="Surat Perintah Pencairan Dana"><i class="fa fa-edit fa-lg fa-fw"></i><span class="menu-item-parent">Disbursement</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/realization', 0)) { echo ' style="display: block"'; } ?>>
 <li>
  <a href="<?php echo site_url('/realization') ?>" title="Disbursement"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Entry Implementation</a>
</li>
</ul>
</li>
<?php endif; ?><!-- akhir menu untuk PIU -->


<li>
   <a href="#" title="Recapitulation report"><i class="fa fa-lg fa-fw fa-table"></i><span class="menu-item-parent">VLMS</span></a>
	<ul class="nav-second-level"<?php if (stripos($current_url, '/reports/index', 0)) { echo ' style="display: block"'; } ?>>
		<li><!-- Susunan report seperti ini ya, jangan dirubah2 lagi, utk mengikuti ke sistem report yang berlaku pada pedp -->
		  <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Development Kit</span> <span class="fa arrow"></span></a>
		</li>
		
        <li>
          <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Scheduler</span> <span class="fa arrow"></span></a>
        </li>
		
		<li>
          <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Trigger</span> <span class="fa arrow"></span></a>
        </li>
		
	</ul>
</li>

<li>
   <a href="#" title="Recapitulation report"><i class="fa fa-lg fa-fw fa-table"></i><span class="menu-item-parent">Data Merging</span></a>
	<ul class="nav-second-level"<?php if (stripos($current_url, '/reports/index', 0)) { echo ' style="display: block"'; } ?>>
		<li><!-- Susunan report seperti ini ya, jangan dirubah2 lagi, utk mengikuti ke sistem report yang berlaku pada pedp -->
		  <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Mahasiswa</span> <span class="fa arrow"></span></a>
		  
		  <ul>
			<li><a href="<?php echo site_url('/mahasiswa/profil');?>"><i class="fa fa-lg fa-fw fa-edit"></i> Profil</a></li>
			<li><a href="<?php echo site_url('/mahasiswa/aktivitas');?>"><i class="fa fa-lg fa-fw fa-edit"></i> Aktivitas</a></li>
			<li><a href="<?php echo site_url('/mahasiswa/nilai');?>"><i class="fa fa-lg fa-fw fa-edit"></i> Nilai</a></li>
			<li><a href="<?php echo site_url('/mahasiswa/status');?>"><i class="fa fa-lg fa-fw fa-edit"></i> Status</a></li>
		  </ul>
		  
		</li>
		
        <li>
          <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Dosen</span> <span class="fa arrow"></span></a>
		  
		  <ul>
			<li><a href="<?php echo site_url('/dosen/aktivitas');?>"><i class="fa fa-lg fa-fw fa-edit"></i> Aktivitas</a></li>
			<li><a href="<?php echo site_url('/dosen/penelitian');?>#"><i class="fa fa-lg fa-fw fa-edit"></i> Penelitian</a></li>
		  </ul>
		  
        </li>
		
	</ul>
</li>

<li>
   <a href="#" title="Recapitulation report"><i class="fa fa-lg fa-fw fa-table"></i><span class="menu-item-parent">Approval System</span></a>
	<ul class="nav-second-level"<?php if (stripos($current_url, '/reports/index', 0)) { echo ' style="display: block"'; } ?>>
		<li><!-- Susunan report seperti ini ya, jangan dirubah2 lagi, utk mengikuti ke sistem report yang berlaku pada pedp -->
		  <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Mahasiswa</span> <span class="fa arrow"></span></a>
		</li>
		
        <li>
          <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Dosen</span> <span class="fa arrow"></span></a>
        </li>
		
	</ul>
</li>

<li>
   <a href="#" title="Recapitulation report"><i class="fa fa-lg fa-fw fa-table"></i><span class="menu-item-parent">Reporting</span></a>
	<ul class="nav-second-level"<?php if (stripos($current_url, '/reports/index', 0)) { echo ' style="display: block"'; } ?>>
		<li><!-- Susunan report seperti ini ya, jangan dirubah2 lagi, utk mengikuti ke sistem report yang berlaku pada pedp -->
		  <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Mahasiswa</span> <span class="fa arrow"></span></a>
		</li>
		
        <li>
          <a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Dosen</span> <span class="fa arrow"></span></a>
        </li>
		
	</ul>
</li>

<li class="<?php if (stripos($current_url, '/dashboard/help')) { echo 'open'; } ?>">
<a href="#"><i class="fa fa-lg fa-fw fa-cog"></i> <span class="menu-item-parent" title="Manual dan Panduan Penggunaan Sistem Informasi dan Panduan Pelaksanaan Proyek">Helps & Manual</span> <span class="fa arrow"></span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/dashboard/help')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/dashboard/panduan') ?>"><i class="fa fa-lg fa-fw fa-lightbulb-o"></i> Manual Penggunaan Aplikasi</a>
</li>
<li>
	<a href="<?php echo site_url('/dashboard/dokumentasi') ?>"><i class="fa fa-lg fa-fw fa-lightbulb-o"></i> Dokumentasi Teknis VLMS</a>
</li>
<li>
	<a href="<?php echo site_url('/dashboard/kosakata') ?>"><i class="fa fa-lg fa-fw fa-lightbulb-o"></i> Kosa Kata Data PDPT</a>
</li>
</li>

<!-- END NAV PEDP -->

			</nav>
			<span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>

			<!-- START FOOTER-->
			<div class="footer">
			  <div class="footer-content" align="center"> Validation Logic Management System<br />Pangkalan Data Pendidikan Tinggi
				<br />Sekretariat Jenderal Kementerian Pendidikan Tinggi Riset dan Teknologi<br />&copy;&nbsp;2015.
				<p>Gedung D Lantai 9, Jalan Pintu Satu Senayan, Jakarta 10270 </p>
			  </div>
			</div>


		</aside>
		<!-- END NAVIGATION -->

		<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>Menu Utama</li><li>Dashboard</li>
				</ol>
					
				<!-- end breadcrumb -->

				<!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right">
				<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
				<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
				<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

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
					<a href="<?php echo site_url('/login/profile'); ?>" class="jarvismetro-tile big-cubes bg-color-green"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>Lihat/Ubah Profile </span> </span> </a>
				</li>
				<li>
					<a href="<?php echo site_url('/login/logout'); ?>" class="jarvismetro-tile big-cubes bg-color-red"> <span class="iconbox"> <i class="fa fa-sign-out fa-4x"></i> <span>Logout</span> </span> </a>
				</li>
			</ul>
		</div>
		<!-- END SHORTCUT AREA -->


	<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/pace/pace.min.js"></script>
    <script src="<?php echo base_url('/assets/smartadmin') ?>/js/libs/jquery-2.0.2.min.js"></script>
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/libs/jquery-ui-1.10.3.min.js"></script>

	<!-- BOOTSTRAP JS -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript">$('.with_tooltip').tooltip({container: 'body'})</script>

	<!-- CUSTOM NOTIFICATION -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/notification/SmartNotification.min.js"></script>

	<!-- JARVIS WIDGETS -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/smartwidgets/jarvis.widget.min.js"></script>

	<!-- JQUERY VALIDATE -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/jquery-validate/jquery.validate.min.js"></script>

	<!-- JQUERY SELECT2 INPUT -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/select2/select2.min.js"></script>

	<!-- browser msie issue fix -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

	<!-- FastClick: For mobile devices -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/fastclick/fastclick.js"></script>

	<!--[if IE 7]>

	<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

	<![endif]-->

	<!-- PEDP JS -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/app.js"></script>
	<script src="<?php echo base_url('/assets') ?>/pedp.js"></script>

	<!-- Full Calendar -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>

    <?php if (isset($include_chart) && $include_chart) : ?>
	<!-- Morris Chart Dependencies -->
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/morris/raphael.2.1.0.min.js"></script>
	<script src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/morris/morris.min.js"></script>
	<?php endif; ?>
	<?php if (isset($chart_data)) { echo $chart_data; } ?>
	
	<script src="<?php echo base_url('/assets/js'); ?>/jquery.mousewheel.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url('/assets/js'); ?>/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url('/assets/js'); ?>/optimasi.js" type="text/javascript"></script>
	<script type="text/javascript">
        // Initialize the plugin with no custom options
        $(document).ready(function () {
          // None of the options are set
          $(".table-overflow").smoothDivScroll({
            autoScrollingMode: false
          });
        });
    </script>

	</body>

</html>