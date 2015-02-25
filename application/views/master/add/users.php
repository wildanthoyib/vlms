<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Users</strong> Master Data</div></h4>

<form role="form" id="form-financial_project_component" method="post" action="<?php echo site_url('/master/simpan/users') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/users'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
<!-- Form entry User -->
<table id="tabel-form-fpc" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
	<th class="short">Nama </th>
        <th class="short">Username</th>
        <th class="short">Password</th>
        <th class="short">Group</th>
	<th class="short">PIU ID</th>
		
    </tr>
    <?php
    $row_max = 5;
    $subjek=array('PMU', 'PIU Penugasan','PIU Kompetisi');
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
        <td><?php echo $r; ?></td>
	<td>
	  <input type="text" class="form-control" placeholder="Nama Lengkap" name="realname[]" >
	</td>
        <td>
	  <input type="text" class="form-control" placeholder="Username" name="username[]" >
	</td>
	<td>
	  <input type="password" class="form-control" placeholder="Passwords" name="passwd[]" >
	</td>
        <td>
	  <select class="form-control" name="groups[]"><?php foreach ($groups as $val => $text) : ?>
	  <option value="<?php echo $val; ?>"><?php echo $text ?></option><?php endforeach; ?>
	  </select>
	</td>
      <td>
	  <select class="select2" name="grantee_id[]"><?php foreach ($list_grantee as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"><?php echo $komp->name_of_grantee ?></option>
	  <?php endforeach; ?>
	  </select>
	</td>
	</tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry User -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
