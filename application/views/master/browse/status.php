<?php
ob_start();
$procs_or_nonprocs['Proc'] = 'Proc';
$procs_or_nonprocs['Non-Proc'] = 'Non-Proc';
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Status</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Status</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/status'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-status" method="post" action="<?php echo site_url('/master/simpan/status') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/status'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Status Procurement</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/status'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="form-table">
<!-- Form entry status -->
<table id="tabel-form-status" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
		<th class="short">Status</th>
		<th class="long">Penjelasan Status</th>
		<th class="short">Proc./Non-Proc.</th>
		<th class="long">Bobot</th>
		
    </tr>
    <?php
    $row_max = 20;
	// var_dump($records);
    foreach ($records as $rec) : ?>
    <tr>
        <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
		  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" /></td>
		<td>
		  <input type="text" class="form-control" placeholder="Status" name="status[<?php echo $rec->id ?>]" value="<?php echo $rec->status ?>" >
		</td>
		<td>
		  <input type="text" class="form-control" placeholder="Penjelasan Status" name="description[<?php echo $rec->id ?>]" value="<?php echo $rec->description ?>" >
		</td>
		<td>
		  <select class="form-control" name="proc_or_nonproc[<?php echo $rec->id?>]"><?php foreach ($procs_or_nonprocs as $val => $text) : ?>
		  <option value="<?php echo $val; ?>"<?php echo $rec->proc_or_nonproc == $val?' selected':''; ?>><?php echo $text ?></option><?php endforeach; ?>
		  </select>
		</td>
		<td>
		  <input type="text" class="form-control" placeholder="Bobot" name="progress_weight[<?php echo $rec->id ?>]" value="<?php echo $rec->progress_weight ?>" >
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
<!-- END status.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
