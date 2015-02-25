<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Quartal</strong> Master Data</div></h4>

<form role="form" id="form-quartal" method="post" action="<?php echo site_url('/master/simpan/quartal') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/quartal'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table">
    
<table id="tabel-form-quartal" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">No.</th>
	<th class="short">Quartal</th>
	<th class="short">Penjelasan Quartal</th>
	<!--<th class="long">Cluster</th>-->
    </tr>
    <?php
    $row_max = 4;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>   
       <td class="very-short" align="center"><?php echo $r; ?></td>
	   <td class="short">
	     <input type="text" class="form-control" placeholder="Quartal" name="quartal[<?php echo $r ?>]" >
	   </td>
            <td class="short">
	     <input type="text" class="form-control" placeholder="Keterangan" name="description[<?php echo $r ?>]" >
	   </td>
	    <!--<td class="long">
	     <input type="text" class="form-control" placeholder="Cluster" name="cluster[<?php echo $r ?>]" >
	   </td>-->
	</tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>

<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
