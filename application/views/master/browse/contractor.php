<?php
ob_start();
/* tahun disembunyikan dulu, belum musimnya dimunculin
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
*/
$list_category = array('PT', 'CV', 'Individual');
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Contractors</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan = $this->session->flashdata('pesan_simpan');
$error = $this->session->flashdata('error_simpan');
$terhapus = $this->session->userdata('data_terhapus');
if ($error) {
  echo '<div class="alert alert-danger alert-error">'.$error.'</div>';
}
if ($pesan) {
  echo '<div class="alert alert-success">'.$pesan.'</div>';
}
if ($terhapus) {
  $this->session->unset_userdata('data_terhapus');
  echo '<div class="alert alert-warning">'.$terhapus.'</div>';
}
?>
<!-- filter -->
<div class="panel panel-default">
  <div class="panel-heading">Filter data kontraktor</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/contractor'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-filter"></i> Filter Data</button>
	</form>
  </div>
  <div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Contractor</div>
</div>
<!-- end of filter -->

<form role="form" id="form-entry-contractor" method="post" action="<?php echo site_url('/master/simpan/contractor') ?>">
<div class="form-group">
<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Save Data</button>
<a href="<?php echo site_url('/master/add/contractor'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add Contractor</a>
<a href="<?php echo site_url('/master/hapus/contractor'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Delete Data</a>
</div>
<div class="form-table table-overflow">
<!-- Form entry Contractor -->
<table id="tabel-form-contractor" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
       
        <th class="very-short"><i class="glyphicon glyphicon-ok"></i></th>
        <th class="long">Nama Kontraktor</th>
	<th class="long">Profil Kontraktor</th>
        <th class="long">Alamat</th>
	<th class="long">Personal Kontak</th>
	<th class="long">Kewarganegaraan</th>
	<th class="long">Email</th>	
	<th class="long">Nomor Telepon</th>
	<th class="long">Nomor Fax/Telefax</th>
	<th class="short">Jenis</th>
      
    </tr>
    <?php
    $row_max = 10;
	// var_dump($records);
    foreach ($records as $rec) : ?>
    <tr>
	<td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" class="form-control with_tooltip" title="Klik kotak untuk memilih" /></td>
        <td class="long">
	<input type="text" class="form-control" placeholder="Contractor(Firm, individual)" name="name_of_contractor[<?php echo $rec->id ?>]" value="<?php echo $rec->name_of_contractor ?>" >
	<input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="Bidang Kontruksi/Tenaga Ahli" name="company_profile[<?php echo $rec->id ?>]" value="<?php echo $rec->company_profile ?>" >
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="Alamat" name="address[<?php echo $rec->id ?>]" value="<?php echo $rec->address ?>" >
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="Ir.Soekarna, MM" name="contact_person[<?php echo $rec->id ?>]" value="<?php echo $rec->contact_person ?>" >
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="Indonesia" name="nationality[<?php echo $rec->id ?>]" value="<?php echo $rec->nationality ?>" >
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="Soekar@majumundur.org" name="email_address[<?php echo $rec->id ?>]" value="<?php echo $rec->email_address ?>" >
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="Telepon" name="telp_number[<?php echo $rec->id ?>]" value="<?php echo $rec->telp_number ?>" >
	</td>
	<td class="long">
	<input type="text" class="form-control" placeholder="facsimile" name="fax_number[<?php echo $rec->id ?>]" value="<?php echo $rec->fax_number ?>" >
	</td>
	<td class="short"><select class="form-control" name="category_of_contractor[]"><?php foreach ($list_category as $id => $komp): ?>
	<option value="<?php echo $komp?>"><?php echo $komp; ?></option><?php endforeach; ?></select>
	</td>	
    </tr>
    <?php endforeach; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Save Data</button>
</div>

<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
</form>
<!-- END Contractor.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
