<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Selection Methods</strong> Master Data</div></h4>

<form role="form" id="form-schema" method="post" action="<?php echo site_url('/master/simpan/schema') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/schema'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
<!-- Form entry Schema -->
<table id="tabel-form-schema" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
	<th class="long">Skema PIU/Grantee</th>
	<th class="long">Penjelasan Seleksi</th>
    </tr>
    <?php
    $row_max = 5;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
        <td><?php echo $r; ?></td>
        <td>
	<input type="text" class="form-control" placeholder="Skema PIU" name="schema_name[]" >
	</td>
	<td>
	<input type="text" class="form-control" placeholder="Penjelasan Skema" name="description[]" >
	</td>

	<?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry Schema -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
