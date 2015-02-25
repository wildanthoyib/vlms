<?php
$page_title = 'User';
ob_start();
?>
<fieldset>
<legend>Daftar User</legend>
<div class="alert alert-info">Ditemukan <strong><?php echo $total_rows ?></strong> data.</div>
<form action="<?php echo site_url('mutasi/daftar'); ?>" method="post">
  <div class="row">
	<div class="col-md-4">
    <div class="input-group">
      <input class="form-control span5" name="keywords" type="text" />
      <span class="input-group-btn"><button class="btn btn-default" name="cari_mutasi" type="button">Cari</button></span>
    </div>
	</div>
    <div class="col-md-8">
    <a class="btn btn-primary" href="<?php echo site_url('system/user/update'); ?>"><i class="icon-user"></i> Tambah user</a>
    </div>
  </div>
</form>
<p>&nbsp;</p>
<table class="table table-bordered table-striped">
  <tr>
	<th>No</th>
	<th>Nama user</th>
  	<th>Username login</th>
  	<th>Group</th>
  	<th>Detail</th>
  </tr>
<?php
$no = 1;
foreach ($datauser as $user) :
?>
  <tr>
  	<td><?php echo $no; ?></td>
  	<td><?php echo $user['realname']; ?></td>
	<td><?php echo $user['username']; ?></td>
  	<td><?php echo @implode(', ', unserialize($user['groups'])); ?></td>
	<td><a class="btn btn-info" href="<?php echo site_url('/system/user/update/'.$user['id']); ?>"><i class="glyphicon glyphicon-folder-open"></i></a></td>
  </tr>
<?php
$no++;
endforeach;
?>
</table>
<div class="pagination"><?php echo $paging; ?></div>
<div class="clear"></div>
</fieldset>
<?php
$main_content = ob_get_clean();

require 'templates/default/main.tpl.php';
