<?php
ob_start();
/*$year_oldest = date('Y')-1;
$year_latest = date('Y')+4;*/
$year_oldest = 2013;
$year_latest = 2018;

?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname'] ?><br /> Main of RPP & Number Contract Implementation</strong></div></h3>

<!-- filter -->

<div class="panel panel-default">
  <div class="panel-heading">Filtering data berdasarkan nomor kontrak DIKTI</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/rpp/index/'); ?>">
      <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
	  <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Masukan nomor kontrak yang ingin dicari" />
      </div>	  
	  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-filter"></i> Filter Data</button>
	</form>
  </div>
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data nomor kontrak DIKTI</div>
</div>

<!-- end of filter -->

<form role="form" id="form-entry_rpp" method="post" action="<?php echo site_url('/rpp/simpan') ?>">
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/rpp/add'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Data RPP/DIPA</a>
  <a href="<?php echo site_url('/rpp/hapus'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a>
</div>
<?php
  $pesan = $this->session->flashdata('pesan_simpan');
  $error = $this->session->flashdata('error_simpan');
  $terhapus = $this->session->userdata('data_terhapus');
  $check = $this->session->flashdata('check');
if ($error) {
  echo '<div class="alert alert-danger alert-error">'.$error.'</div>';
}
if ($pesan) {
  echo '<div class="alert alert-success">'.$pesan.'</div>';
}
if ($terhapus) {
  echo '<div class="alert alert-success">'.$terhapus.'</div>';
  $this->session->unset_userdata('data_terhapus');
}
if ($check) {
  echo '<div class="alert alert-danger">'.$check.'</div>';
}
?>
<div class="info">&nbsp;</div>
<div class="form-table table-overflow">
<!-- Form browse Proposal -->
<table id="tabel-form-rpp" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
    <th class="very-short"><i class="glyphicon glyphicon-ok"></i> &nbsp;</th>
    <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><th>Nama Grantee(PIU)</th><?php endif; ?>
      <th class="long"><i class="glyphicon glyphicon-book"></i> Nomor Kontrak PMU ke PIU</th>
      <th class="long"><i class="glyphicon glyphicon-calendar"></i> Tahun Anggaran</th>
      <th class="long">ADB (IDR)RK</th>
      <th class="long">GOI (IDR)RM</th>
      <th class="long">DRK/PNBP (IDR)RM</th>
      <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><th>CIDA*(IDR)</th><?php endif; ?>
      <th class="long"><i class="glyphicon glyphicon-plus"></i> Nilai Total Anggaran</th>
      <!-- dibuatkan menjadi 3 subtitle, terdiri dari SF, Rincian DIPA dan Rincian RPP-->
      <th><i class="glyphicon glyphicon-list"></i> Rincian RPP</th>
      <th><i class="glyphicon glyphicon-list"></i> Rincian DIPA RKA(K/L)</th>
      <!-- <th>Upload</th> -->
      <!-- <th>Approval</th> -->
      </tr>
    <?php
    foreach ($records as $rec) : ?>
    <tr>
      <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" class="form-control with_tooltip" title="Klik kotak untuk memilih, kemudian hapus data" /></td>
      
      <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
      <td>
      <select placeholder="Name of Grantee" class="select2" name="piu_id[]">
      <?php foreach ($list_pid as $komp) : ?>
      <option value="<?php echo $komp->id; ?>"<?php echo ($komp->id==$rec->grantee_id)?' selected':'' ?>><?php echo $komp->name_of_grantee ?></option>
      <?php endforeach; ?>
      </select>
      </td>
      <?php endif; ?>
      
      <td><input type="text" class="form-control with_tooltip" title="Anda dapat memperbaharui nomor kontrak rencana pelaksanaan program ini, kemudian simpan data" placeholder="Nomor Rencana Pelaksanaan Proyek" name="contract[<?php echo $rec->id ?>]" value="<?php echo $rec->contract ?>" >
      <input type="hidden" name="id[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" >
      </td>
      <td><select readonly="readonly" class="form-control with_tooltip" title="Tahun anggaran tidak dapat diperbaharui, hanya berlaku untuk sekali perencanaan dalam satu tahun" name="year[<?php echo $rec->id ?>]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"<?php echo $rec->year == $y?'selected':'' ; ?>><?php echo $y; ?></option><?php endfor; ?></select>
      </td>
      <td>
      <input type="text" class="form-control to_be_sum with_tooltip" placeholder="Jumlah Rupiah ADB" name="adb[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->adb, 0 , '', '.') ?>"title="Anda dapat memperbaharui jumlah nilai Loan dari ADB, kemudian simpan data">
      </td>
      <td>
      <input type="text" class="form-control to_be_sum with_tooltip" placeholder="Jumlah Rupiah GoI" name="goi[<?php echo $rec->id?>]" value="<?php echo number_format($rec->goi, 0 , '', '.') ?>"title="Anda dapat memperbaharui jumlah nilai PAGU(RKAKL) dari APBN, kemudian simpan data">
      </td>
      <td>
      <input type="text" class="form-control to_be_sum with_tooltip" placeholder="Jumlah Rupiah DRK" name="drk[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->drk, 0 , '', '.') ?>"title="Anda dapat memperbaharui jumlah nilai PAGU anggaran dari Institusi anda sendiri, kemudian simpan data">
      </td>
      <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
      <td>
      <input type="text" class="form-control to_be_sum with_tooltip" placeholder="Jumlah Rupiah CIDA" name="cida[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->cida, 0 , '', '.') ?>" title="Anda dapat memperbaharui jumlah nilai Grant/Loan dari CIDA, kemudian simpan data">
      </td>
      <?php endif; ?>
      <td class="auto_sum_wrapper"><input readonly="readonly" type="text" class="form-control auto_sum"  name="total_value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->total_value, 0 , '', '.') ?>" >
      <td><a href="<?php echo site_url('/rpp/detail_rpp/'.$rec->id); ?>" class="btn btn-default with_tooltip bg-color-green txt-color-white" title="Klik untuk mengisi detail RPP"><i class="glyphicon glyphicon-tasks"></i> Detail RPP</a></td>
      <td><a href="<?php echo site_url('/rpp/detail/'.$rec->id); ?>" class="btn btn-default with_tooltip bg-color-green txt-color-white" title="Klik untuk mengisi detail DIPA"><i class="glyphicon glyphicon-tasks"></i> Detail DIPA(RKA K/L)</a></td>
      <!-- <td><input type="file" class="with_tooltip" title="Klik untuk mengunggah file proposal" placeholder="Upload berkas" name="upload_detail[<?php echo $rec->id ?>]" ></td> -->
      <!-- <td><?php echo $rec->approval==1?'<span class="label label-danger">Tidak selesai</span>':'Sudah Selesai' ?></td> -->
    </tr>
    <?php
    endforeach;
    ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
   <a href="<?php echo site_url('/rpp/hapus'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a>
</div>
</form>
<!-- END form entry Proposal -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
