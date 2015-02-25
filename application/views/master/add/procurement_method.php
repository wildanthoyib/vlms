<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Procurement Method</strong> Master Data</div></h4>

<form role="form" id="form-proc_method" method="post" action="<?php echo site_url('/master/simpan/procurement_method') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/procurement_method'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
<table id="tabel-form-procurementmethod" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
  <tr>
    <th align="center">No.</th>
    <th>Metoda Procurement (Pengadaan)</th>
    <th>Keterangan Metoda</th>
  </tr>
  <?php
  $row_max = 5;
  for ($r = 1; $r <= $row_max; $r++) : ?>
    
  <tr>
    <td align="center"><?php echo $r; ?></td>
    <td>
      <input type="text" class="form-control" name="procurement_method[]" />
    </td>
    <td>
	  <input type="text" class="form-control" name="description[]" />
    </td>
  </tr>
    
  <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry Procurement Method-->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
