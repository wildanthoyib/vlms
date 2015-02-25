<?php
ob_start();
$year_oldest = 2013;
$year_latest = 2018;
/*$year_oldest = date('Y')-1;
  $year_latest = date('Y')+4;*/
$list_month = array(
  '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',  '4' => 'April', '5' => 'Mei',
  '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',  '9' => 'September', '10' => 'Oktober',
  '11' => 'Nopember', '12' => 'Desember'
);
//echo '<pre>'; var_dump($list_component_proc); echo '</pre>';
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br />Detail of Number Contract Implementation: <strong><?php echo $rpp->contract ?> (<?php echo $rpp->grantee ?>)</strong></div></h3>

<!-- filter -->
<div class="panel panel-default">
  <div class="panel-heading">Filtering daftar isian pelaksanaan anggaran</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/rpp/detail/'.$rpp->id); ?>">
      <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
	  <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-filter"></i> Filter Data</button>
	</form>
  </div>
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data detail DIPA</div>
</div>

<!-- end of filter -->

<form role="form" id="form-rpp" method="post" action="<?php echo site_url('/rpp/simpan/detail') ?>">
<div class="form-group">
  <a type="submit" href="<?php echo site_url('/rpp/index'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/rpp/hapus_detail_dipa'); ?>" class="btn btn-danger btn-delete btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Komponen</a>
</div>
<div class="alert alert-warning">Pastikan memilih komponen pembiayaan, mengisi paket/kegiatan, menuliskan catatan,menentukan PAGU anggaran, dan memilih sumber pembiayaan !</div>
<div class="alert alert-danger">*Wajib diisi</div>
<!--<div class="form-table table-overflow">-->
  
<!-- Form entry RPP Plan -->
  	<div class="form-table table-responsive" style="width:auto; overflow: scroll;">
	  
<table id="tabel-form-rppdetail" class="table table-bordered table-striped table-condensed" align="center">
    <tr>
        <!-- <th>Bulan</th> -->
  	<th class="very-short"><i class="glyphicon glyphicon-ok"></i></th>
	<th class="select2-max"><i class="glyphicon glyphicon-th-list"></i> Komponen Pembiayaan*</th>
	<th><i class="glyphicon glyphicon-list-alt"></i> Nama Paket Pembiayaan*</th>
	<th><i class="glyphicon glyphicon-tags"></i> Catatan Penggunaan Paket</th>
	<th><i class="glyphicon glyphicon-leaf"></i> Nilai PAGU (DIPA-RKA KL)/Rp*</th><!-- Nilai PLAN--->
	<th><i class="glyphicon glyphicon-barcode"></i> Sumber Pembiayaan*</th>
        <!--<th>Komponen*</th>
        <th>Paket Kegiatan*</th>
        <th>Nilai* (IDR)</th> -->
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
	<select class="select2" name="component_id[<?php echo $rec->id ?>]" data-select-width="350px">
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
	<input type="text" class="form-control with_tooltip" title="Nama Paket pembiayaan" placeholder="Nama Paket pembiayaan" name="package_id[<?php echo $rec->id ?>]" value="<?php echo $rec->package_id ?>" >
	<input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>"/>
      </td>
      <td>
	<input type="text" class="form-control with_tooltip" title="Masukan catatan mengenai Rencana Pelaksanaan Proyek" placeholder="Catatan mengenai Rencana Pelaksanaan Proyek " name="note[<?php echo $rec->id ?>]" value="<?php echo $rec->note ?>" >
	<input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>"/>
      </td>
      <td>
	<input type="text" class="form-control with_tooltip" title="Nilai yang dientry tidak boleh minus" placeholder="Mis: 500.000,00" name="value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->value, 0, '', '.') ?>" >
	<input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>"/>
      </td>
        <td>
	<select class="form-control" name="source_of_fund[<?php echo $rec->id ?>]"><?php foreach ($list_fund as $komp) : ?>
	<option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->source_of_fund?' selected':''; ?>><?php echo $komp->source_of_fund ?></option><?php endforeach; ?>
	</select>
      </td>
    </tr>
    
    <?php
    $c++;
    endforeach;
	
    $row_max = $c;
    for ($r = $c; $r <= $row_max; $r++) : ?>
    <script type="text/javascript">
  
    </script>
    <!-- Add Data -->
    <tr class="rppdetail warning">
      <td><i class="glyphicon glyphicon-plus"></i></td>
      <!-- <td><select class="form-control" name="month[]"><?php foreach ($list_month as $val => $text) : ?><option value="<?php echo $val; ?>"><?php echo $text ?></option><?php endforeach; ?></select></td> -->
      <td>
	    <select class="select2" name="component_id[]" data-select-width="350px">
	    <option value="0" disabled="disabled">PROCUREMENT</option>
	    <?php foreach ($list_component_proc as $komp) : ?>
	      
	        <optgroup label="<?php echo $komp['data']->name_of_fpc ?>">
		    <?php if ($komp['childs']) : ?>
		    <?php foreach ($komp['childs'] as $komp2) : ?>
		      <option value="<?php echo $komp2['data']->id; ?>"><?php echo $komp2['data']->name_of_fpc.' - '.$komp2['data']->sf.' - '.$komp2['data']->schema_name ?></option>
	        <?php endforeach; ?>
		    <?php endif; ?>
	        </optgroup>
	      
	        <!-- <option value="<?php echo $komp['data']->id; ?>"><?php echo $komp['data']->name_of_fpc.' - '.$komp['data']->sf.' - '.$komp['data']->schema_name ?></option> -->
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
	<input type="text" class="form-control" placeholder="Nama Paket Pembiayaan" name="package_id[]" >
      </td>
      <td>
	<input type="text" class="form-control" placeholder="Catatan Mengenai Penggunaan Paket Pembiayaan" name="note[]" >
      </td>
      <td>
	<input type="text" class="form-control" placeholder="Harga Perkiraan Sementara" name="value[]" >
      </td>
        <td>
	<select class="form-control" name="source_of_fund[]"><?php foreach ($list_fund as $komp) : ?>
	<option value="<?php echo $komp->id; ?>"><?php echo $komp->source_of_fund ?></option><?php endforeach; ?>
	</select>
      </td>
<!--	  <td><a class="btn btn-danger rm-current-row">Hapus</a></td> -->
	</tr>
    <?php endfor; ?>
</table>
</div>
<input type="hidden" name="proposal_id" value="<?php echo $rpp->id ?>" />
<div class="form-group">
<!--  <a class="btn btn-danger add-rppdetail" href="#"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Baris Data</a> --> <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/rpp/hapus_detail_dipa'); ?>" class="btn btn-danger btn-delete btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Komponen</a>
</div>

<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>

</form>
<!-- END form entry Proc Plan -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';