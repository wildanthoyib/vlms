<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Status</strong> Master Data</div></h4>

<form role="form" id="form-status" method="post" action="<?php echo site_url('/master/simpan/status') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/status'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
<!-- Form entry G1 -->
<table id="tabel-form-g1" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
		<th class="short">Status</th>
		<th class="long">Penjelasan Status</th>		
		<th class="short">Bobot Progress</th>
		<th class="short">Proc/Non Proc</th>
    </tr>
    <?php
    $row_max = 5;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
       <td><?php echo $r; ?></td>
	   <td>
	     <input type="text" class="form-control" placeholder="Status Proposal" name="status[<?php echo $r ?>]" >
	   </td>
	    <td>
	     <input type="text" class="form-control" placeholder="Penjelasan Status Proposal" name="description[<?php echo $r ?>]" >
	   </td>
	   <td>
	   <input type="text" class="form-control" placeholder="Bobot Progress" name="progress_weight[<?php echo $r ?>]" >
	   </td>
	   <td>
	    <select class="form-control" name="proc_or_nonproc[]"><?php foreach ($procs_or_nonprocs as $val => $text) : ?>
	    <option value="<?php echo $val; ?>"><?php echo $text ?></option><?php endforeach; ?>
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
<!-- END form entry G1 -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
