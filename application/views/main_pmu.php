<?php
ob_start();
/*$year_oldest = date('Y')-1;
  $year_latest = date('Y')+4;*/
$year_oldest = 2013;
$year_latest = 2018;
ob_start();
if (!isset($print_view)) {
?>
<div class="alert alert-info">Selamat datang <i>User Substansi/Administrasi</i> atas nama <strong><?php echo $user_data['realname']  ?></strong> pada Sistem Manajemen Monitoring dan Evaluasi Peningkatan Mutu Pendidikan Politeknik ADB Loan No.2928-INO.</div>
<?php } ?>

<h3>Recapitulation Dashboard of the <strong>Polytechnics Education Development Project</strong>
  <div>Accomplishment Report for Year: <strong><?php echo $current_year ?></strong></div></h3>
<?php
$header = ob_get_clean();
if (!isset($print_view)) {
  echo $header;
}
?>

<div class="panel panel-default filter-form option-form">
  <div class="panel-heading">Pemilahan data berdasarkan tahun anggaran</div>
  <div class="panel-body">
    <form method="get" role="form">
	  <div class="form-group">
        <label for="rpp">RPP/Tahun Anggaran</label>
        <select class="form-control" name="year"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select>
      </div>
	  <div class="form-group">
	    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-repeat"></i> Ubah Pemilahan</button>
	</div>
	  <button type="button" class="btn btn-warning show-opsi-form"><i class="glyphicon glyphicon-leaf"></i> Tampilkan pilihan tahun anggaran</button>
	  <a href="<?php echo site_url('/dashboard/index') ?>?print=yes" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
	</form>
  </div>
</div>

<?php ob_start(); ?>
<table id="tabel-form-grantee" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
  <tr>
      <th class="very-short">Number</th>
      <!--<th class="very-short">Code of Grantee</th>-->
      <th class="long">Name of Grantee</th>
      <th class="long">RPP (IDR)</th>
      <th class="long">DIPA (IDR)</th>
      <th class="long">Contracted (IDR)</th>
      <th class="long">Disbursed (IDR)</th>
      <th class="long">% of Disbursed to DIPA</th>
      <th class="long">% of Disbursed to Contracted</th>
      <!--<th class="long">% of Accomplishment</th>-->
  </tr>
  <?php
  $row_max = 50;
  $n = 1;
  // var_dump($records);
  foreach ($list_grantee as $rec) :
  // query data rpp masing-masing grantee
  $rpp_id = 0;
  $this->db->where(array('year' => $current_year, 'grantee_id' => $rec->id));
  $rpp_query = $this->db->get('Proposal');
  $rpp_data = $rpp_query->row();
  if (isset($rpp_data->id)) {
	$rpp_id = $rpp_data->id;
  }
  ?>
  <tr>
    <td><?php echo $n; ?></td> <!-- number -->
    <!--<td><?php echo $rec->id ?></td>-->
    <td><a href="<?php echo site_url('/dashboard/'); ?>?pmu_grantee=<?php echo $rec->id ?>&rpp_year=<?php echo $current_year ?>"><?php echo $rec->name_of_grantee ?></a></td>
      
	<?php $rpp_sum = $this->Rpp_model->getRppTotalSum($rpp_id); ?>
    <td><?php echo number_format($rpp_sum, 0, '', '.') ?></td> <!--RPP IDR -->
    
    
    <?php $plan_sum = $this->Proc_model->getPlanSum($rec->id, $rpp_id) ?>  <!--DIPA IDR -->
    <td><?php echo number_format($plan_sum, 0, '', '.') ?></td>
    
    <?php $impl_sum = $this->Proc_model->getImpSum($rec->id, $rpp_id) ?>  <!-- Contracted IDR -->
    <td><?php echo number_format($impl_sum, 0, '', '.') ?></td>
    
    <?php $disb_sum = $this->Proc_model->getDisbursedSum($rec->id, $rpp_id) ?>
    
    <td><?php echo number_format($disb_sum, 0, '', '.') ?></td>  <!--Disbursed IDR -->
    <td><?php echo @(round(($disb_sum/$plan_sum)*100, 2)).'%' ?></td>  <!--% of Disbursed to DIPA -->
    <td><?php echo @(round(($disb_sum/$impl_sum)*100, 2)).'%' ?></td>  <!--% of Disbursed to Contracted -->
    
    <!--<td><?php echo @(round(($impl_sum/$plan_sum)*100, 2)).'%' ?></td>-->
  </tr>
    
    <?php
	$n++;
	endforeach; ?>
</table>
<?php
$data_table = ob_get_clean();
if (!isset($print_view)) {
  echo $data_table;
}

$main_content = ob_get_clean();
if (isset($print_view)) {
  $main_content = null;
  $main_content = $header.$data_table;
  require './assets/smartadmin/index-print.tpl.php';
} else {
  require './assets/smartadmin/index-blank.tpl.php';  
}
