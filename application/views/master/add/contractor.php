<?php
ob_start();
/* tahun disembunyikan dulu, belum musimnya dimunculin...
 *$year_oldest = date('Y')-1;
 *$year_latest = date('Y')+4;
*/
$list_category = array('PT', 'CV', 'Individu');
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Contractor</strong> Master Data</div></h4>

<form role="form" id="form-contractor" method="post" action="<?php echo site_url('/master/simpan/contractor') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Save Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/contractor'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-inbox"></i> Browse Data</a>
</div>
<div class="form-table table-overflow">
<!-- form entry contractor-->
<table style="width:300px" id="tabel-form-contractor" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
	<th class="very-short">No.</th>
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
    $row_max = 20;
    $jenis = array('--Pilih Jenis--','PT', 'CV','Individual');
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
        <td><?php echo $r; ?></td>
	 <td class="long">
	  <input type="text" class="form-control" placeholder="Contractor(Firm,individual)" name="name_of_contractor[]" >
	</td>
	 <td class="long">
	  <input type="text" class="form-control" placeholder="Profile Perusahaan" name="company_profile[]" >
	</td>
        <td class="long">
	   <input type="text" class="form-control" placeholder="Alamat" name="address[]" >
	</td>
	 <td class="long">
	   <input type="text" class="form-control" placeholder="Personal Kontak(Direktur,Manager)" name="contact_person[]" >
	</td>
	  <td class="long">
	   <input type="text" class="form-control" placeholder="Kewarganegaraan" name="nationality[]" >
	</td>
	  <td class="long">
	   <input type="text" class="form-control" placeholder="Alamat email" name="email_address[]" >
	</td>
	<td class="long">
	   <input type="text" class="form-control" placeholder="Telepon" name="telp_number[]" >
	  </td>
	 <td class="short">
	   <input type="text" class="form-control" placeholder="facsimile" name="fax_number[]" >
	  </td>	  
	<td><select class="form-control" name="category_of_contractor[]"><?php foreach ($list_category as $id => $komp) : ?>
	<option value="<?php echo $komp; ?>"><?php echo $komp; ?></option><?php endforeach; ?></select></td>
    </tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Save Data</button>
</div>
</form>
<!-- END form entry Contractor -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
