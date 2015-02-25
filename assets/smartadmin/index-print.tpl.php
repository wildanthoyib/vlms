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

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!-- Basic Styles -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets/smartadmin') ?>/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('/assets') ?>/pedp-print.css">
	
</head>
<body class="print">
<a href="javascript: self.print()" class="pull-right"><small>Cetak Halaman Ini</small></a>
<!-- MAIN CONTENT -->
<div id="content">
<?php echo $main_content ?>
</div>
<!-- END MAIN CONTENT -->
<script type="text/javascript">
  self.print();
</script>
</body>
</html>
