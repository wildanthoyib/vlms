<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Procurement Method</strong> Master Data</div></h3>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Procurement Method</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/procurement_method'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-entry-procurement_method" method="post" action="<?php echo site_url('/master/simpan/procurement_method') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a href="<?php echo site_url('/master/add/procurement_method'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Procurement Method</a>
  <a href="<?php echo site_url('/master/hapus/procurement_method'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table">
<!-- Form entry Procurement Method -->
<table id="tabel-form-contractor" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
      <th class="very-short">#</th>
      <th class="long">Metoda Procurement</th>
      <th class="long">Keterangan Metoda</th>
    </tr>
    <?php
      $row_max = 10;
	  // var_dump($records);
      foreach ($records as $rec) : ?>
    <tr>
      <td>
      <input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Procurement Method" name="procurement_method[<?php echo $rec->id ?>]" value="<?php echo $rec->procurement_method ?>" >
      <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Keterangan Metoda Procurement" name="description[<?php echo $rec->id ?>]" value="<?php echo $rec->description ?>">
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
<!-- END Procurement_method.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
