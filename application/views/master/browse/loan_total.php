<?php
ob_start();
/* tahun disembunyikan dulu, belum musimnya dimunculin
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
*/
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Loan Proceeds</strong> Master Data</div></h3>
<?php
// pesan apabila data telah tersimpan
$list_grantee_type = array('PMU', 'PIU');
$list_proc_or_nonprocs = array('Proc', 'Non-Proc');
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Financial Project Component</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/loan_total'); ?>">
    
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-entry-financial_project_component" method="post" action="<?php echo site_url('/master/simpan/loan_total') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/loan_total'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Financial Project Component</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/loan_total'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table table-overflow">
<!-- Form entry financial_project_component -->
<table id="tabel-form-financial_project_component" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
      <th class="very-short">No.</th>
      <th class="long">Nama Komponen Proyek</th>
      <th class="short">Sumber Pembiayaan</th>
    </tr>
    <?php
    $row_max = 20;
	// var_dump($records);
    foreach ($records as $rec) :
    ?>
    <tr>
        <td>
	  <input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	</td>
        <td>
	  <input type="text" class="form-control" placeholder="Nama Komponen Proyek Keuangan" name="item[<?php echo $rec->id ?>]" value="<?php echo $rec->item?>" >
	  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	  </td>
        <td>
	  <select class="form-control" name="source_of_fund[<?php echo $rec->id ?>]"><?php foreach ($list_fund as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->source_of_fund?' selected':''; ?>><?php echo $komp->source_of_fund ?></option><?php endforeach; ?>
	  </select>
	</td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>

<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
</form>
<!-- END financial_project_component.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
