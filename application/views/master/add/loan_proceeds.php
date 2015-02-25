<?php
ob_start();
//$list_proc_or_nonproc = array('Proc', 'Non-Proc');
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Financial Project Component</strong> Master Data</div></h4>

<form role="form" id="form-financial_project_component" method="post" action="<?php echo site_url('/master/simpan/loan_total') ?>">

<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/financial_project_component'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i> Browse Data</a>
</div>

<div class="form-table">
<!-- Form entry Financial Project Component-->
<table id="tabel-form-fpc" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
        <th class="long">Nama Komponen Proyek Keuangan</th>
        <th class="short">Sumber Dana</th>
    </tr>
    <?php
    $row_max = 5;
    $subjek=array('PMU', 'PIU Penugasan','PIU Kompetisi');
    $list_grantee_types = array('PMU','PIU');
    $list_proc_or_nonprocs = array('Proc', 'Non-Proc');
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
        <td><?php echo $r; ?></td>
        <td>
	  <input type="text" class="form-control" placeholder="Nama Komponen Proyek Keuangan" name="value[<?php echo $r ?>]" >
	</td>
        <td>
	  <select class="form-control" name="source_of_fund[<?php echo $r ?>]"><?php foreach ($list_loan as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"><?php echo $komp->source_of_fund ?></option><?php endforeach; ?>
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
<!-- END form entry Master Data Financial Project Component -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
