<?php
ob_start();
?>
<h3>Polytechnic Education Development Project ADB Loan No. 2928-INO<div><strong>Grantees</strong> Master Data</div></h4>
<?php
// pesan apabila data telah tersimpan
$pesan_simpan = $this->session->flashdata('pesan_simpan');
if ($pesan_simpan) {
  echo '<div class="alert alert-success">'.$pesan_simpan.'</div>';
}
?>
<!-- filter -->
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Grantee</div>
<div class="panel panel-default">
  <div class="panel-heading">Filter data</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/master/index/grantee'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Kata kunci pencarian" />
      </div>	  
	  <button type="submit" class="btn btn-primary">Filter</button>
	</form>
  </div>
</div>
<!-- end of filter -->

<form role="form" id="form-grantee" method="post" action="<?php echo site_url('/master/simpan/grantee') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/master/add/grantee'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i> Add Grantee</a>
  <a type="submit" href="<?php echo site_url('/master/hapus/grantee'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-minus-sign"></i> Delete Data</a>
</div>
<div class="pagination-wrap">
<?php echo $pagination; ?>
</div>
<div class="form-table table-overflow">
<!-- Form entry Grantee -->
<table id="tabel-form-grantee" class="table table-bordered table-striped table-condensed" align="center" valign="middle">

    <tr>
	<th class="very-short">No.</th>
	<th class="long">Kode Grantee</th>
	<th class="long">Nama Grantee</th>
	<th class="long">Alamat</th>
	<th class="long">E-Mail</th>
	<th class="long">Nomor Telepon</th>
	<th class="long">Nama Manajer</th>
	<th class="long">Nomor Batch</th>
	<th class="long">Status Grantee</th>
	<th class="long">Wilayah</th>
	<th class="long">Tahun Periode</th>
	<th class="long">Nomor Kontrak</th>
	<th class="long">ID FPIC</th>
	<th class="short">Tahun Alokasi Dana</th>
	<th class="long">Alokasi Dana Proyek</th>
	<th class="short">Tahun Alokasi DIPA</th>
	<th class="long">Dana Alokasi DIPA</th>
	<th class="long">Skema Proyek</th>
    </tr>

    <?php
    $row_max = 20;
	// var_dump($records);
    foreach ($records as $rec) : ?>
    <tr>
      <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" /></td>
    <td>
      <input type="text" class="form-control" readonly="readonly" placeholder="Kode Grantee" name="id[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" >
      <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
    </td>
    <td>
      <input type="text" class="form-control" placeholder="Grantee" name="name_of_grantee[<?php echo $rec->id ?>]" value="<?php echo $rec->name_of_grantee ?>" >
    </td>
    <td>
      <input type="text" class="form-control" placeholder="Alamat" name="address[<?php echo $rec->id ?>]" value="<?php echo $rec->address ?>" >
    </td>
    <td>
      <input type="text" class="form-control" placeholder="e-mail" name="email[<?php echo $rec->id ?>]" value="<?php echo $rec->email ?>" >
    </td> 
    <td>
      <input type="text" class="form-control" placeholder="Phone" name="phone[<?php echo $rec->id ?>]" value="<?php echo $rec->phone ?>" >
    </td>
    <td>
      <input type="text" class="form-control" placeholder="Manager" name="manager[<?php echo $rec->id ?>]" value="<?php echo $rec->manager ?>" >
    </td>
    <td>
      <input type="text" class="form-control" placeholder="Nomor Batch" name="batch_number[<?php echo $rec->id ?>]" value="<?php echo $rec->batch_number ?>" >
    </td>
    <td>
      <input type="text" class="form-control" placeholder="Status Grantee" name="status_grantee[<?php echo $rec->id ?>]" value="<?php echo $rec->status_grantee ?>" >
    </td>
      
      <td><select placeholder="Silahkan Pilih Provinsi" class="select2" name="wilayah[<?php echo $rec->id ?>]"><?php foreach ($list_wilayah as $komp) : ?>
      <option value="<?php echo $komp->id; ?>"><?php echo $komp->Nama_provinsi; ?></option><?php endforeach; ?></select></td>
      
      <td>
      <input type="text" class="form-control" placeholder="Tahun Periode" name="year_period[<?php echo $rec->id ?>]" value="<?php echo $rec->year_period ?>" >
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Nomor Kontrak" name="contract_number[<?php echo $rec->id ?>]" value="<?php echo $rec->contract_number ?>" >
      </td>
      <td>
      <input type="text" class="form-control" placeholder="ID FPIC" name="FPIC_ID[<?php echo $rec->id ?>]" value="<?php echo $rec->FPIC_ID ?>" >
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Tahun Alokasi Dana Proyek" name="year_of_project_fund_allocation[<?php echo $rec->id ?>]" value="<?php echo $rec->year_of_project_fund_allocation ?>" >
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Alokasi Dana Proyek" name="allocation_of_project_fund[<?php echo $rec->id ?>]" value="<?php echo $rec->allocation_of_project_fund ?>" >
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Alokasi Tahun DIPA" name="year_of_DIPA_alocation[<?php echo $rec->id ?>]" value="<?php echo $rec->year_of_DIPA_alocation ?>" >
      </td>
      <td>
      <input type="text" class="form-control" placeholder="Alokasi Dana DIPA" name="allocation_of_DIPA_fund[<?php echo $rec->id ?>]" value="<?php echo $rec->allocation_of_DIPA_fund ?>" >
      </td>
     <td>
     <?php
	  $this->db->where(array('grantee_id' => $rec->id));
      $query = $this->db->get('GranteeSchema');
      $result = $query->result();
      $project_schema = array();
      foreach ($result as $row) { $project_schema[] = $row->schema_id; }
	  ?>
      <select class="select2" multiple="multiple" name="schemas[<?php echo $rec->id ?>][]">
      <option value="0"></option>
      <?php foreach ($list_of_schemas as $komp) : ?>
      <option value="<?php echo $komp->id; ?>"<?php echo in_array($komp->id, $project_schema)?' selected':''; ?>>
      <?php echo $komp->schema_name; ?></option><?php endforeach; ?>
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
<!-- END Grantee.php -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
