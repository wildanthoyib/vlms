<?php
ob_start();
$year_oldest = 2013;
$year_latest = 2018;
/*$year_oldest = date('Y')-1;
  $year_latest = date('Y')+4;*/
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Add <strong>Number of Contract Implementation</strong>Form</div></h4>

<form role="form" id="form-rpp" method="post" action="<?php echo site_url('/rpp/simpan') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/rpp/index'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-th-list"></i>Browse Data</a>
</div>

<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry Proc Plan -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
