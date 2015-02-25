<?php
ob_start();
/*Belum musim munculin tahun keuleus....
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
 */
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Source of Fund</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Source of Fund</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/source_of_fund'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->


<form role="form" id="form-entry-source_of_fund" method="post" action="<?php echo site_url('/master/simpan/source_of_fund') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/source_of_fund'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Source of Fund</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/source_of_fund'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table">
<!-- Form entry Source of Fund -->
<table id="tabel-form-source_of_fund" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
	<th class="short">Sumber Pembiayaan</th>
	<th class="long">Penjelasan Sumber Pembiayaan</th>
    </tr>
    <?php
    $row_max = 10;
	// var_dump($records);
    foreach ($records as $rec) : ?>
    <tr>
        <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" /></td>
      <td>
      <input type="text" class="form-control" placeholder="Sumber Pembiayaan" name="source_of_fund[<?php echo $rec->id ?>]" value="<?php echo $rec->source_of_fund ?>" >
      <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
      </td>
       <td>
      <input type="text" class="form-control" placeholder="Penjelasan sumber pembiayaan" name="description[<?php echo $rec->id ?>]" value="<?php echo $rec->description ?>" >
      
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
<!-- END source_of_fund.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
