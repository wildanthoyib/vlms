<?php
ob_start();
/* tahun disembunyikan dulu, belum musimnya dimunculin
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
*/
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Users</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Users</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/users'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-entry-users" method="post" action="<?php echo site_url('/master/simpan/users') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/users'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Users</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/users'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table">
<!-- Form entry user -->
<table id="tabel-form-financial_project_component" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
   	<th class="very-short">No.</th>
	<th class="long">Nama </th>
        <th class="long">Username</th>
        <th class="short">Group</th>
	<th class="short">PIU ID</th>
	<th class="short">Password</th>
    </tr>
    <?php
    $row_max = 20;
	// var_dump($records)<?php echo $rec->id?
    foreach ($records as $rec) : ?>
    <tr>
        <td>
	  <input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	</td>
        <td>
	  <input type="text" class="form-control" placeholder="Nama" name="realname[<?php echo $rec->id?>]" value="<?php echo $rec->realname ?>" >
	  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	</td>
       <td>
	  <input type="text" class="form-control" placeholder="Username" name="username[<?php echo $rec->id?>]" value="<?php echo $rec->username ?>" >
	  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	</td>
	<td>
	  <select class="form-control" name="groups[<?php echo $rec->id?>]"><?php foreach ($groups as $val => $text) : ?>
	  <option value="<?php echo $val; ?>"<?php echo $rec->groups == $val?' selected':''; ?>><?php echo $text ?></option><?php endforeach; ?>
	  </select>
	</td>
	<td>
	  <select placeholder="PIU Identity" class="select2" name="grantee_id[<?php echo $rec->id?>]"><?php foreach ($list_pid as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->grantee_id?' selected':'';?>><?php echo $komp->name_of_grantee ?></option><?php endforeach; ?>
	  </select>
	</td>
	<td>
	  <input type="password" class="form-control" placeholder="Change Passwords" name="passwd[<?php echo $rec->id?>]" value="" >
	  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
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
<!-- END of users.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
