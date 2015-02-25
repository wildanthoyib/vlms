<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Source of Funds</strong> Master Data</div></h4>

<form role="form" id="form-source_of_fund" method="post" action="<?php echo site_url('/master/simpan/source_of_fund') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/source_of_fund'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
<!-- Form entry source_of_fund -->
<table id="tabel-form-source_of_fund" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
	<th class="short">Sumber Pembiayaan</th>
	<th class="long">Penjelasan Sumber Pembiayaan</th>
    </tr>
    <?php
    $row_max = 10;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
        <td><?php echo $r; ?></td>
      <td class="short">
      <input type="text" class="form-control" placeholder="Sumber Pembiayaan" name="source_of_fund[<?php echo $r ?>]" >
      </td>
       <td class="long">
      <input type="text" class="form-control" placeholder="Penjelasan Sumber Pembiayaan" name="description[<?php echo $r ?>]" >
      </td>
	</tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>
<!-- END form source_of_fund -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
