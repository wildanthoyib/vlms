<?php
ob_start();
/* tahun disembunyikan dulu, belum musimnya dimunculin
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
*/
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Activity Package</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Activity Package</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/activity_package'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-activity_package" method="post" action="<?php echo site_url('/master/simpan/activity_package') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/activity_package'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Activity Package</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/activity_package'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table">
<!-- Form entry activity_package -->
<table id="tabel-form-activity_package" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
	<th class="long">Nama Paket</th>
	<th class="short">Parent ID</th>
    </tr>
    <?php
    $row_max = 20;
	// var_dump($records);
    foreach ($records as $rec) : ?>
    <tr>
        <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" /></td>
		<td>
		  <input type="text" class="form-control" placeholder="Nama Paket" name="package_name[<?php echo $rec->id ?>]" value="<?php echo $rec->package_name ?>" >
		  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
		</td>
		<td>
		  <select class="select2" name="parent_id[<?php echo $rec->id ?>]">
		    <?php foreach ($list_activity as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->parent_id?' selected':''; ?>><?php echo $komp->package_name ?></option><?php endforeach; ?>
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
<!-- END activity_package.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
