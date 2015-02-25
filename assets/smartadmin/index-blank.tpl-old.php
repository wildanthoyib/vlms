<!DOCTYPE html>
<?php $current_url = current_url() ?>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title>SIMONE-PEDP</title>
		<meta name="Wildan Toyib" title="Lead Developer" content="Direktorat Pembelajaran dan Kemahasiswaan" class="Direktorat Jenderal Pendidikan Tinggi" object="Kementerian Pendidikan dan Kebudayaan Republik Indonesia">
	        <meta name="Arie Nugraha" title="Core Developer" content="Direktorat Pembelajaran dan Kemahasiswaan" class="Direktorat Jenderal Pendidikan Tinggi" object="Kementerian Pendidikan dan Kebudayaan Republik Indonesia">
		<meta name="Polytechnic Education Development Project ADB 2928-INO" content="Manajamen Monitoring & Evaluasi Peningkatan Mutu Pendidikan Politeknik">
		<meta name="SIMONE-PEDP" class="Kementerian Pendidikan dan Kebudayaan RI" content="PEDP 2013-2017">
		<meta name="MP3EI: Masterplan Percepatan dan Perluasan Pembangunan Ekonomi Indonesia, Bidang Pendidikan:Program Peningkatan Mutu Pendidikan Politeknik" content="Program Pengembangan Peningkatan Mutu Pendidikan Politeknik, 6 Koridor Ekonomi Indonesia {Koridor Sumatera, Koridor Jawa, Koridor Kalimantan, Koridor Sulawesi, Koridor Bali & Nusa Tenggara, Koridor Papua & Kepulauan Maluku}" class="PEDP 2013-2017, MP3EI 2014-2015, RPJMN Kemdikbud">

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

				<img src="<?php echo base_url('/assets') ?>/img/logo-dikbud.png" width="52" height="42" class="pull-left"><a href="<?php echo site_url("#") ?>" class="logo-title">Manajemen Monitoring dan Evaluasi Peningkatan<br /> Mutu Pendidikan Politeknik ADB 2928-INO</a>

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

				<!-- input: search field -->
				<form action="#search.html" class="header-search pull-right">
					<input type="text" placeholder="Pencarian Data PEDP" id="search-fld">
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
<a href="<?php echo base_url("#") ?>"><i class="fa fa-dashboard fa-lg fa-fw"></i><span class="menu-item-parent">Beranda</span></a>
</li>
<!--
Menu untuk grafik from dimas
-->

<?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><!-- awal menu untuk PMU/Admin -->

<li class="<?php if (stripos($current_url, '/graphics') || stripos($current_url, '/graphics')) { echo 'open'; } ?>">
<a href="#" title="Graphics and Diagrams"><i class="fa fa-bar-chart-o fa-lg fa-fw"></i><span class="menu-item-parent">Graphics and<br /> Chart</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/graphics') || stripos($current_url, '/impl')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/graphics/pedp') ?>" title="Plan vs Realization for PEDP"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i>Plan vs Realization<br /> for PEDP</a>
</li>
<li>
	<a href="<?php echo site_url('/graphics/piu') ?>"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i>Plan vs Realization<br /> for PIU</a>
</li>
<li>
	<a href="<?php echo site_url('/graphics/schema') ?>" title="Plan vs Realization for Schema"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i>Plan vs Realization<br /> for Schema</a>
</li>
</ul>
</li>
<?php endif; ?><!-- akhir menu untuk PMU -->


<?php if ('piu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><!-- awal menu untuk PIU/PMU -->

<li class="<?php if (stripos($current_url, '/rpp') || stripos($current_url, '/proc/') || stripos($current_url, '/non_proc/')) { echo 'open'; } ?>">
<a href="#"><i class="fa fa-edit fa-lg fa-fw"></i><span class="menu-item-parent" title="Plan">Plan</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/rpp') || stripos($current_url, '/proc/') || stripos($current_url, '/non_proc/')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/rpp') ?>"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Proposal/RPP</a>
</li>
<li>
	<a href="<?php echo site_url('/proc/plan') ?>"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Procurement Plan</a>
</li>
<li>
	<a href="<?php echo site_url('/non_proc/plan') ?>"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Non-Procurement Plan</a>
</li>
</ul>
</li>

<li class="<?php if (stripos($current_url, '/realization') || stripos($current_url, '/impl')) { echo 'open'; } ?>">
<a href="#" title="Realization and Implementation"><i class="fa fa-edit fa-lg fa-fw"></i><span class="menu-item-parent">Realization and<br /> Implementation</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/realization') || stripos($current_url, '/impl')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/realization') ?>" title="Procurement Implementation"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Financial Realization</a>
</li>
<li>
	<a href="<?php echo site_url('/impl/proc') ?>" title="Procurement Implementation"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Procurement Implementation</a>
</li>
<li>
	<a href="<?php echo site_url('/impl/non_proc') ?>" title="Non-Procurement Implementation"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i>Non-Procurement <br />Implementation</a>
</li>
</ul>
</li>

<li>
<a href="#" title="Recapitulation report"><i class="fa fa-edit fa-lg fa-fw"></i><span class="menu-item-parent">Recapitulation Reports</span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/dashboard')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/reports/index/g1') ?>" title="Recapitulation of Payment"><i class="fa fa-lg fa-fw fa-list"></i>Report 1 G1</a>
</li>
<li>
	<a href="<?php echo site_url('/reports/index/g2') ?>" title="Monitoring Activity"><i class="fa fa-lg fa-fw fa-list"></i>Report 1 G2</a>
</li>
<li>
	<a href="<?php echo site_url('/reports/index/g3') ?>" title="Monitoring Activity"><i class="fa fa-lg fa-fw fa-list"></i>Report 1 G3</a>
</li>
</ul>
</li>

<?php endif; ?><!-- akhir menu untuk PIU -->


<?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><!-- awal menu PMU -->

<li class="<?php if (stripos($current_url, '/report')) { echo 'open'; } ?>">
<a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Financial Report</span> <span class="fa arrow"></span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/report')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/report/use_funds') ?>">1A: Project Sources and Uses of Funds</a>
</li>
<li>
	<a href="<?php echo site_url('/report/cash_forecast') ?>">1C: Project Cash <br />Forecast</a>
</li>
<li>
	<a href="<?php echo site_url('/report/disbursements') ?>">1E: Disbursements and<br /> Awards Status for Grant Fund</a>
</li>
<li>
	<a href="<?php echo site_url('/report/summary') ?>">1G: Summary Statement <br />Awards</a>
</li>
</ul>
<!-- /.nav-second-level -->
</li>


<li>
<a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Project Progress <br />Report</span> <span class="fa arrow"></span></a>
<ul class="nav-second-level">
<li>
	<a href="<?php echo site_url('/report/output_monitoring') ?>">2B: Output Monitoring Report<br /> (Unit of Output by Project Activity)</a>
</li>
</ul>
<!-- /.nav-second-level -->
</li>

<li>
<a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent" title="PMR">Procurement <br />Management Report</span> <span class="fa arrow"></span></a>
<ul class="nav-second-level">
<li>
	<a href="<?php echo site_url('/report/output_monitoring') ?>">3A: Procurement Process<br /> Monitoring (Goods and Works)</a>
</li>
<li>
	<a href="<?php echo site_url('/report/procurement_monitoring') ?>">3B: Procurement Process <br />Monitoring (Consultants Services)</a>
</li>
<li>
	<a href="<?php echo site_url('/report/contract_goods') ?>">3C: Contract Awards <br />Report (Goods and Works)</a>
</li>
<li>
	<a href="<?php echo site_url('/report/contract_consultant') ?>">3D: Contract Awards <br />Report (Consultants Services)</a>
</li>
</ul>
<!-- /.nav-second-level -->
</li>

<li class="<?php if (stripos($current_url, '/report')) { echo 'open'; } ?>">
<a href="#"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Achievements Report</span> <span class="fa arrow"></span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/report')) { echo ' style="display: block"'; } ?>>
<li>
	<a href="<?php echo site_url('/report/recapitulations') ?>">Recapitulation of Works Achievements</a>
</li>
<li>
	<a href="<?php echo site_url('/report/laboratories') ?>">1A: Achivements of<br />Laboratories Biddings </a>
</li>
<li>
	<a href="<?php echo site_url('/report/materials') ?>">1B: Achivements of<br />Materials Biddings</a>
</li>
<li>
	<a href="<?php echo site_url('/report/supportings') ?>">1C: Achievements of<br /> Supporting Equipments Biddings</a>
</li>
<li>
	<a href="<?php echo site_url('/report/civil') ?>">1D: Achivements of <br />Civil Works Biddings</a>
</li>
<li>
	<a href="<?php echo site_url('/report/overseas') ?>">2A: Achivements of <br />Overseas Degree</a>
</li>
<li>
	<a href="<?php echo site_url('/report/domestic') ?>">2B: Achivements of <br />Domestic Non-Degree</a>
</li>
<li>
	<a href="<?php echo site_url('/report/overseas_nd') ?>">2C: Achivements of <br />Overseas Non-Degree</a>
</li>
<li>
	<a href="<?php echo site_url('/report/development') ?>">3A: Achivements of <br />Development Programs</a>
</li>
<li>
	<a href="<?php echo site_url('/report/tlm') ?>">3B: Achivements of <br />Teaching Learning Material Development</a>
</li>
<li>
	<a href="<?php echo site_url('/report/studies') ?>">4A: Achivements of <br />Studies</a>
</li>
<li>
	<a href="<?php echo site_url('/report/workshops') ?>">4B: Achivements of <br />Workshops</a>
</li>
<li>
	<a href="<?php echo site_url('/report/technical') ?>">5A: Achivements of <br />Technical Assistant</a>
</li>
<li>
	<a href="<?php echo site_url('/report/operational') ?>">6A: Achivements of <br />Operational Cost</a>
</li>
<li>
	<a href="<?php echo site_url('/report/remuneration') ?>">6B: Achivements of <br />Remuneration Cost/Staff Salary</a>
</li>

</ul>
<!-- /.nav-second-level -->
</li>

<li>
<a href="<?php echo site_url('/rpp/approval') ?>"><i class="fa fa-lg fa-fw fa-table"></i> <span class="menu-item-parent">Proposal Recapitulation</span> <span class="fa arrow"></span></a>
</li>
<?php endif; ?><!-- akhir menu untuk PMU -->

<!-- Master data -->
<li class="<?php if (stripos($current_url, '/master')) { echo 'open'; } ?>">
<a href="#"><i class="fa fa-lg fa-fw fa-list"></i> <span class="menu-item-parent" title="Master Data Report">Master Data</span> <span class="fa arrow"></span></a>
<ul class="nav-second-level"<?php if (stripos($current_url, '/master')) { echo ' style="display: block"'; } ?>>

<li>
	<a href="<?php echo site_url('/master/index/contractor') ?>">Contractor</a>
</li>
<?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><!-- awal menu PMU -->

<li>
	<a href="<?php echo site_url('/master/index/grantee') ?>">Grantee</a>
</li>
<li>
	<a href="<?php echo site_url('/master/index/procurement_method') ?>">Procurement Method</a>
</li>
<?php endif; ?>
<?php if ('admin' == $user_data['groups']) : ?><!-- awal menu PMU -->

<li>
	<a href="<?php echo site_url('/master/index/schema') ?>">Schema</a>
</li>
<li>
	<a href="<?php echo site_url('/master/index/source_of_fund') ?>">Source of Fund</a>
</li>
<li>
	<a href="<?php echo site_url('/master/index/financial_project_component') ?>">Financial Project <br />Component</a>
</li>
<li>
	<a href="<?php echo site_url('/master/index/activity_package') ?>">Activity Package</a>
</li>
<li>
	<a href="<?php echo site_url('/master/index/status') ?>">Status</a>
</li>
<li>
	<a href="<?php echo site_url('/master/index/quartal') ?>">Quartal</a>
</li>
<?php endif; ?>

</ul>
<!-- /.nav-second-level -->
</li>
<!-- Master data -->

</ul>
<!-- END NAV PEDP -->

			</nav>
			<span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>

			<!-- START FOOTER-->
			<div class="footer">
			  <div class="footer-content" align="center"> Polytechnic Education Development Project<br />Kementerian Pendidikan dan Kebudayaan
				<br />Direktorat Jenderal Pendidikan Tinggi <br />Direktorat Pembelajaran dan Kemahasiswaan &copy;&nbsp;2014.
				<p>Gedung D Lantai 7, Jalan Pintu Satu Senayan, Jakarta 10270 </p>
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
					<a href="javascript:void(0);" class="jarvismetro-tile big-cubes bg-color-green"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>Ubah Profile </span> </span> </a>
				</li>
				<li>
					<a href="<?php echo site_url('/login/logout') ?>" class="jarvismetro-tile big-cubes bg-color-red"> <span class="iconbox"> <i class="fa fa-sign-out fa-4x"></i> <span>Logout</span> </span> </a>
				</li>
			</ul>
		</div>
		<!-- END SHORTCUT AREA -->


		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo base_url('/assets/smartadmin') ?>/js/plugin/pace/pace.min.js"></script>
        <script src="<?php echo base_url('/assets/smartadmin') ?>/js/libs/jquery-2.0.2.min.js"></script>
	    <script src="<?php echo base_url('/assets/smartadmin') ?>/js/libs/jquery-ui-1.10.3.min.js"></script>

		<!-- BOOTSTRAP JS -->
		<script src="<?php echo base_url('/assets/smartadmin') ?>/js/bootstrap/bootstrap.min.js"></script>

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

	</body>

</html>
