<?php
ob_start();
 $year_oldest = date('Y')-1;
 $year_latest = date('Y')+4;
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Grantee</strong> Master Data</div></h4>

<form role="form" id="form-grantee" method="post" action="<?php echo site_url('/master/simpan/grantee') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/index/grantee'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-list"></i>Browse Data</a>
</div>

<div class="form-table table-overflow">
<!-- Form entry Grantee -->
<table id="tabel-form-grantee" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
      
  <tr>
      <th class="very-short">No.</th>
      <th>Kode Grantee</th>
      <th>Nama Grantee</th>
      <th>Alamat</th>
      <th>E-Mail</th>
      <th>Nomor Telepon</th>
      <th>Nama Manajer</th>
      <th>Nomor Batch</th>
      <th>Status Grantee</th>
      <th>Wilayah</th>
      <th>Tahun Periode</th>
      <th>Nomor Kontrak Dikti</th>
      <th>ID FPIC</th>
      <th>Tahun Alokasi Dana</th>
      <th>Alokasi Dana Proyek</th>
      <th>Tahun Alokasi DIPA</th>
      <th>Dana Alokasi DIPA</th>
      <th>Methoda Seleksi</th>
   </tr>
          
    <?php
    $row_max = 5;
    $sgrantee = array('--Status Politeknik--', 'Negeri', 'Swasta');
    $wilayah = array('--Pilih Provinsi--', 'ACEH','SUMATERA UTARA','SUMATERA BARAT','RIAU','JAMBI','SUMATERA SELATAN','BENGKULU','LAMPUNG','KEP. BANGKA BELITUNG','KEP.RIAU','BANTEN','D.K.I. JAKARTA','JAWA BARAT','JAWA TENGAH','D.I. YOGYAKARTA','JAWA TIMUR','BALI','NUSA TENGGARA BARAT','NUSA TENGGARA TIMUR','KALIMANTAN BARAT','KALIMANTAN TENGAH','KALIMANTAN SELATAN','KALIMANTAN TIMUR','KALIMANTAN UTARA','GORONTALO','SULAWESI UTARA','SULAWESI TENGAH','SULAWESI SELATAN','SULAWESI TENGGARA','SULAWESI BARAT','MALUKU','MALUKU UTARA','PAPUA','PAPUA BARAT','LUAR NEGERI',);
    
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>
	  <td><?php echo $r; ?></td>
	  <td>
	  <input type="text" class="form-control" placeholder="Kode Grantee" name="id[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Mis:Politeknik Negeri Manado" name="name_of_grantee[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Alamat Lengkap" name="address[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Alamat e-mail" name="email[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Telepon" name="phone[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Manajer" name="manager[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Nomor Batch" name="batch_number[]" >
	  </td>
	  <td>
	  <select class="form-control" name="status_grantee[]"><?php foreach ($sgrantee as $rv) : ?>
	  <option value="<?php echo $rv; ?>"><?php echo $rv; ?></option><?php endforeach; ?>
	  </select>
	  </td>
	  <td><select placeholder="Silahkan Pilih Provinsi" class="select2" name="wilayah[]"><?php foreach ($list_wilayah as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"><?php echo $komp->Nama_provinsi; ?></option><?php endforeach; ?></select></td>
	  <td class="tahun-filterable">
	  <select class="form-control" name="year_period[]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?>
	  <option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select></td>
	  <td>
	  <input type="text" class="form-control" placeholder="Nomor Kontrak" name="contract_number[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="ID FPIC" name="FPIC_ID[]" >
	  <td class="tahun-filterable">
	  <select class="form-control" name="year_of_project_fund_allocation[]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?>
	  <option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select></td>
	  <td>
	  <input type="text" class="form-control" placeholder="Alokasi Dana Proyek" name="allocation_of_project_fund[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Tahun Alokasi DIPA" name="year_of_DIPA_allocation[]" >
	  </td>
	  <td>
	  <input type="text" class="form-control" placeholder="Dana Alokasi DIPA" name="allocation_of_DIPA_fund[]" >
	  </td>
	  
	  <td><select placeholder="Silahkan Pilih Skema" class="select2" multiple="multiple" name="schema_name[]"><?php foreach ($list_of_schemas as $komp) : ?>
	  <option value="<?php echo $komp->id; ?>"><?php echo $komp->schema_name; ?></option><?php endforeach; ?></select></td>
	  
	</tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry Grantee -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
