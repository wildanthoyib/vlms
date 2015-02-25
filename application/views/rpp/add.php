<?php
ob_start();
/*$year_oldest = date('Y')-1;
  $year_latest = date('Y')+4;*/
$year_oldest = 2013;
$year_latest = 2018;

?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?><br />Add <strong>Number of Contract Implementation</strong> Form</div></h4>

<form role="form" id="form-rpp" method="post" action="<?php echo site_url('/rpp/simpan') ?>">
<div class="form-group">
  <a type="submit" href="<?php echo site_url('/rpp/index'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-home"></i> Kembali ke Depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
</div>
<div class="alert alert-warning">Pastikan mengentri data nomor kontrak dikti, memilih tahun anggaran, dan menentukan serta mengisi sumber pembiayaan (ADB,GoI & DRK).</div>
<div class="form-table">
<!-- Form entry Plan RPP -->
<table id="tabel-form-add_rpp" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
      <th class="very-short"><i class="glyphicon glyphicon-sort-by-order"></i> Nomor</th>
      <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><th>Name of Grantee(PIU)</th><?php endif; ?>
      <th><i class="glyphicon glyphicon-book"></i> Surat Perjanjian antara PMU dengan PIU</th>
      <th><i class="glyphicon glyphicon-calendar"></i> Tahun Anggaran</th>
      <th><i class="glyphicon glyphicon-leaf"></i> ADB* (IDR)/RK</th>
      <th><i class="glyphicon glyphicon-leaf"></i> GOI* (IDR)/RM</th>
      <th><i class="glyphicon glyphicon-leaf"></i> DRK/PNBP* (IDR)/RM</th>
	  <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
      <th>CIDA*(IDR)</th>
	  <?php endif; ?>
      <!-- <th>Nilai Total Anggaran*</th> -->
    </tr>
    <?php
    $row_max = 1;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <tr>    
      <td><?php echo $r; ?></td>
      <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
      <td>
      <select placeholder="Name of Grantee" class="select2" name="grantee_id[]">
      <?php foreach ($list_pid as $komp) : ?>
      <option value="<?php echo $komp->id; ?>"><?php echo $komp->name_of_grantee ?></option>
      <?php endforeach; ?>
      </select>
      </td>
      <?php endif; ?>
      <td>
      <input type="text" class="form-control with_tooltip" placeholder="Nomor Kontrak Rencana Pelaksanaan Proyek dari Dirjen DIKTI" name="contract[]" title="Isikan dengan menggunakan nomor kontrak RPP dari PMU-DIKTI">
      </td>
      <td>
      <select class="form-control with_tooltip" name="year[]" title="Isilah menggunakan Tahun Anggaran"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select>
      </td>
      <td>
      <input type="text" class="form-control with_tooltip" placeholder="Jumlah Rupiah dari ADB" name="adb[]" title="Isilah dengan sejumlah bantuan dari ADB">
      </td>
      <td>
      <input type="text" class="form-control with_tooltip" placeholder="Jumlah Rupiah dari APBN" name="goi[]" title="Isilah dengan sejumlah bantuan dari APBN">
      </td>
      <td>
      <input type="text" class="form-control with_tooltip" placeholder="Jumlah Rupiah dari DRK/PNBP Grantee" name="drk[]" title="Isilah dengan sejumlah bantuan dari DRK/PNBP Grantee">
      </td>
	  <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
      <td>
      <input type="text" class="form-control with_tooltip" placeholder="Jumlah Rupiah dari CIDA" name="cida[]" title="Isilah dengan sejumlah bantuan dari CIDA">
      </td>
	  <?php endif; ?>
      <!-- total nilai anggaran adalah hasil dari sum(adb+goi+drk+cid), fungsi langsung cetak karakter by using php logics
      <td>
      <input type="text" readonly="readonly" class="form-control with_tooltip" placeholder="Jumlah total ADB+GOI+DRK+CIDA" name="total_value[]" title="Total Sumber Bantuan">
      </td>
	  -->
	</tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
</div>
</form>
<!-- END form entry Plan RPP -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';