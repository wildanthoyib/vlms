<?php
ob_start();
/*Belum musim memunculkan tahun, bikin berart loading bro....
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
 */
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Metoda Seleksi</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Schema</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/schema'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-entry-schema" method="post" action="<?php echo site_url('/master/simpan/schema') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/schema'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Schema</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/schema'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table">
<!-- Form entry Schema -->
<table id="tabel-form-schema" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
    <th class="very-short">No.</th>
	<th class="long">Nama Skema</th>
	<th class="long">Penjelasan Skema</th>
    </tr>
    <?php
    $row_max = 20;
	// var_dump($records);
    foreach ($records as $rec) : ?>
    <tr>
      <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" /></td>
      <td><input type="text" class="form-control" placeholder="Skema" name="schema_name[<?php echo $rec->id ?>]" value="<?php echo $rec->schema_name ?>" >
        <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Penjelasan Skema" name="description[<?php echo $rec->id ?>]" value="<?php echo $rec->description ?>" >
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
<!-- END Schema.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
