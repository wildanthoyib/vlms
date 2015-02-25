<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Activity Package</strong> Master Data</div></h4>

<form role="form" id="form-activity_package" method="post" action="<?php echo site_url('/master/simpan/activity_package') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/activity_package'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
<!-- Form entry G1 -->
<table id="tabel-form-g1" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
		<th class="long">Nama Tipe Peralatan</th>
		<!--<th class="short">Kategori Luas</th>-->
    </tr>
    <?php
    $row_max = 5;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
        <td><?php echo $r; ?></td>
        <td class="long">
		  <input type="text" class="form-control" placeholder="Nama Paket" name="package_name[<?php echo $r ?>]" >
		</td>
	    <!--<td>
		  <select class="select2" name="package_id[<?php echo $r ?>]">
		  <?php foreach ($list_activity as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->package_name ?></option><?php endforeach; ?>
		  </select>
		</td>-->
	</tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry Activity Package-->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
