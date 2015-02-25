<?php
ob_start();
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br />Detail of Total RPP per Cost Component: <strong><?php echo $rpp->contract ?> (<?php echo $rpp->grantee ?>)</strong></div></h3>

<!-- filter -->

<div class="panel panel-default">
  <div class="panel-heading">Filtering data komponen pembiayaan</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/rpp/detail_rpp/'.$rpp->id); ?>">
      <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
	  <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-filter"></i>Filter Data</button>
	</form>
  </div>
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data detail RPP</div>
</div>
<!-- end of filter -->

<form role="form" id="form-rpp" method="post" action="<?php echo site_url('/rpp/simpan_detail_rpp') ?>">
<div class="form-group">
  <a type="submit" href="<?php echo site_url('/rpp/index'); ?>" class="btn btn-info"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/rpp/hapus_detail_rpp'); ?>" class="btn btn-danger btn-delete btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a>
</div>
<div class="alert alert-warning">*Pastikan memilih komponen pembiayaan dan mengentry nilai total pembiayaan sesuai dengan RPP yang ditentukan !</div>
<div class="alert alert-danger">*Wajib diisi</div>
<div class="form-table">
<!-- Form entry RPP Plan -->
<table id="tabel-form-rppdetail" class="table table-bordered table-striped table-condensed" align="center">
    <tr>
  	<th class="very-short"><i class="glyphicon glyphicon-ok"></i></th>
	<th class="select2-max" class="very-long"><i class="glyphicon glyphicon-th-list"></i> Komponen Pembiayaan*</th>
	<th>Nilai Pembiayaan (Rp)*</th>
    </tr>
    <?php
    $c = 1;
    foreach ($records as $rec) :  
    ?>
    <!--Browse Data-->
    <tr class="rppdetail">
      <td>
	<input type="checkbox" class="form-control with_tooltip" title="Klik kotak untuk memilih" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
      </td>
      <td>
	<select class="select2" name="component_id[<?php echo $rec->id ?>]" data-select-width="600px">
	  <option value="0" disabled="disabled">PROCUREMENT</option>
	  <?php foreach ($list_component_proc as $komp) : ?>
	      <optgroup label="<?php echo $komp['data']->name_of_fpc ?>">
	      <?php if ($komp['childs']) : ?>
		<?php foreach ($komp['childs'] as $komp2) : ?>
		  <option value="<?php echo $komp2['data']->id; ?>"<?php echo $rec->component_id==$komp2['data']->id?' selected':'' ?>><?php echo $komp2['data']->name_of_fpc.' - '.$komp2['data']->sf.' - '.$komp2['data']->schema_name ?></option>
	        <?php endforeach; ?>
	      </optgroup>
	    <?php endif; ?>
	      <!--<option value="<?php echo $komp['data']->id; ?>"<?php echo $rec->component_id==$komp['data']->id?' selected':'' ?>><?php echo $komp['data']->name_of_fpc.' - '.$komp['data']->sf.' - '.$komp['data']->schema_name ?></option>-->
	  <?php endforeach; ?>
	  
	  <option value="0" disabled="disabled">NON-PROCUREMENT</option>
  	  <?php foreach ($list_component_non_proc as $komp) : ?>
	      <optgroup label="<?php echo $komp['data']->name_of_fpc ?>">
	        <?php if ($komp['childs']) : ?>
		<?php foreach ($komp['childs'] as $komp2) : ?>
		  <option value="<?php echo $komp2['data']->id; ?>"<?php echo $rec->component_id==$komp2['data']->id?' selected':'' ?>><?php echo $komp2['data']->name_of_fpc.' - '.$komp2['data']->sf.' - '.$komp2['data']->schema_name ?></option>
	        <?php endforeach; ?>
	      </optgroup>
	    <?php endif; ?>
	      <!--<option value="<?php echo $komp['data']->id; ?>"<?php echo $rec->component_id==$komp['data']->id?' selected':'' ?>><?php echo $komp['data']->name_of_fpc.' - '.$komp['data']->sf.' - '.$komp['data']->schema_name ?></option>-->
	  <?php endforeach; ?>
	</select>
    </td>
    <td>
	  <input type="text" class="form-control with_tooltip" title="Nilai Rupiah Komponen Pembiayaan" placeholder="Mis: 500.000,00" name="value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->value, 0, '', '.') ?>" >
	  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>"/>
    </td>
    </tr>
    
    <?php
    $c++;
    endforeach;
	
    $row_max = $c;
    for ($r = $c; $r <= $row_max; $r++) : ?>
    <!-- Add Data -->
    <tr class="rppdetail warning">
      <td><i class="glyphicon glyphicon-plus"></i></td>
      <!-- <td><select class="form-control" name="month[]"><?php foreach ($list_month as $val => $text) : ?><option value="<?php echo $val; ?>"><?php echo $text ?></option><?php endforeach; ?></select></td> -->
      <td>
	    <select class="select2" name="component_id[]" data-select-width="600px">
	    <option value="0" disabled="disabled">PROCUREMENT</option>
	    <?php foreach ($list_component_proc as $komp) : ?>
	      <optgroup label="<?php echo $komp['data']->name_of_fpc ?>">
	      <?php if ($komp['childs']) : ?>
		    <?php foreach ($komp['childs'] as $komp2) : ?>
		      <option value="<?php echo $komp2['data']->id; ?>"><?php echo $komp2['data']->name_of_fpc.' - '.$komp2['data']->sf.' - '.$komp2['data']->schema_name ?></option>
	        <?php endforeach; ?>
	      </optgroup>
	      <?php endif; ?>
	      <!--<option value="<?php echo $komp['data']->id; ?>"><?php echo $komp['data']->name_of_fpc.' - '.$komp['data']->sf.' - '.$komp['data']->schema_name ?></option>-->
	    <?php endforeach; ?>

  	    <option value="0" disabled="disabled">NON-PROCUREMENT</option>
  	    <?php foreach ($list_component_non_proc as $komp) : ?>
	      
	        <optgroup label="<?php echo $komp['data']->name_of_fpc ?>">
	  	    <?php if ($komp['childs']) : ?>
		    <?php foreach ($komp['childs'] as $komp2) : ?>
	  	      <option value="<?php echo $komp2['data']->id; ?>"><?php echo $komp2['data']->name_of_fpc.' - '.$komp2['data']->sf.' - '.$komp2['data']->schema_name ?></option> -->
	        <?php endforeach; ?>
	        <?php endif; ?>
		    </optgroup>

	        <!-- <option value="<?php echo $komp['data']->id; ?>"><?php echo $komp['data']->name_of_fpc.' - '.$komp['data']->sf.' - '.$komp['data']->schema_name ?></option> -->
	    <?php endforeach; ?>
	    </select>
      </td>
      <td>
 	    <input type="text" class="form-control" placeholder="Entry Nilai Total Komponen Biaya" name="value[]" >
      </td>
	</tr>
    <?php endfor; ?>
</table>
</div>
<input type="hidden" name="proposal_id" value="<?php echo $rpp->id ?>" />
<div class="form-group">
<!--  <a class="btn btn-danger add-rppdetail" href="#"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Baris Data</a> --> <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/rpp/hapus_detail_rpp'); ?>" class="btn btn-danger btn-delete btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>

</form>
<!-- END form entry Proc Plan -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';