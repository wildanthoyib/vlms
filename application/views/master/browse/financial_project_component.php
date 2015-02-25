<?php
ob_start();
/* tahun disembunyikan dulu, belum musimnya dimunculin
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
*/
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Financial Project Component</strong> Master Data</div></h3>
<?php
// pesan apabila data telah tersimpan
$list_grantee_type = array('PMU', 'PIU');
$list_proc_or_nonprocs = array('Proc', 'Non-Proc');
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Financial Project Component</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/financial_project_component'); ?>">
    
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>
	  <div class="form-group">
	    <select class="form-control" name="schema"><?php foreach ($list_schema as $komp) : ?>
		<option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$curr_schema?' selected':'' ?>><?php echo $komp->schema_name ?></option><?php endforeach; ?>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-entry-financial_project_component" method="post" action="<?php echo site_url('/master/simpan/financial_project_component') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/financial_project_component'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Financial Project Component</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/financial_project_component'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table table-overflow">
<!-- Form entry financial_project_component -->
<table id="tabel-form-financial_project_component" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
      <th class="very-short">No.</th>
      <th class="long">Nama Komponen Proyek</th>
      <th class="short">Sumber Pembiayaan</th>
      <th class="short">Kategori Kontrak</th>
      <th class="long">Metoda Seleksi</th>
      <th class="short">Jenis</th>
      <th class="short">Kode</th>
      <th class="short">Grantee Type</th>
    </tr>
    <?php
    $row_max = 20;
	// var_dump($records);
    foreach ($records as $rec) :
    // $list_proc_or_nonprocs = array('Proc', 'Non-Proc');
    ?>
    <tr>
        <td>
	  <input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	</td>
        <td>
	  <input type="text" class="form-control" placeholder="Nama Komponen Proyek Keuangan" name="name_of_fpc[<?php echo $rec->id ?>]" value="<?php echo $rec->name_of_fpc ?>" >
	  <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	  </td>
        <td>
	  <select class="form-control" name="source_of_fund[<?php echo $rec->id ?>]"><?php foreach ($list_fund as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->source_of_fund?' selected':''; ?>><?php echo $komp->source_of_fund ?></option><?php endforeach; ?>
	  </select>
	</td>
	<td>
	  <select class="form-control" name="parent_id[<?php echo $rec->id ?>]"><?php foreach ($list_component as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->parent_id?' selected':''; ?>><?php echo $komp->name_of_fpc ?></option><?php endforeach; ?></select>
	</td>
	<td>
	  <select class="form-control" name="subject[<?php echo $rec->id ?>]"><?php foreach ($list_schema as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->subject?' selected':''; ?>><?php echo $komp->schema_name ?></option><?php endforeach; ?>
	  </select>
	</td>
	<td>
	  <select class="form-control" name="proc_or_nonproc[<?php echo $rec->id ?>]"><?php foreach ($list_proc_or_nonprocs as $pp) : ?>
	  <option value="<?php echo $pp; ?>"<?php echo trim($pp)==trim($rec->proc_or_nonproc)?' selected':''; ?>><?php echo $pp	?></option><?php endforeach; ?>
	  </select>
	</td>
	<td>
	  <input type="text" class="form-control" placeholder="Kode" name="code[<?php echo $rec->id ?>]" value="<?php echo $rec->code ?>" />
	</td>
	 <td>
	  <select class="form-control" name="grantee_type[<?php echo $rec->id ?>]"><?php foreach ($list_grantee_type as $gt) : ?>
	  <option value="<?php echo $gt; ?>"<?php echo $gt==$rec->grantee_type?' selected':''; ?>><?php echo $gt ?></option><?php endforeach; ?>
	  </select>
	</td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>

<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
</form>
<!-- END financial_project_component.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
