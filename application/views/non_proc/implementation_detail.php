<?php
ob_start();
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br />
  <div>Non-Procurement Implementation Detail for: <strong><?php echo $proposal_detail->contract ?> (<?php echo $proposal_detail->grantee ?>)</strong></div></h3>
<form role="form" id="form-non_proc-plan-detail" method="post" action="<?php echo site_url('/non_proc/simpan/impl') ?>">
<div class="form-group">
  <a type="submit" href="<?php echo site_url('/impl/non_proc'); ?>" class="btn btn-info"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a type="submit" href="<?php echo site_url('/non_proc/detail/'.$proposal_detail->id); ?>" class="btn btn-default with_tooltip bg-color-magenta txt-color-white" title="Melihat kembali data utama non-procurement plan"><i class="glyphicon glyphicon-inbox"></i> Lihat Data <i>Non-Procurement Plan</i></a>
</div>
<?php
$pesan = $this->session->flashdata('pesan_simpan');
if ($pesan) {
  echo '<div class="alert alert-success">'.$pesan.'</div>';
}
?>
<div class="alert alert-warning">Pastikan telah memilih paket kegiatan Non-Procurement untuk ditindaklanjuti ke proses detail progress </div>
<div class="alert alert-danger">*Wajib diisi</div>
<div class="form-table">
<!-- Form entry detail implementasi -->
<table id="tabel-form-plan-detail" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
    <th class="very-short centered">Nomor</th>
    <th>Deskripsi Nama Kegiatan</th>
	<!--
    <th>Nama Pelaksana*</th>
    <th>No. Kontrak*</th>
    <th>Tanggal Pelaksanaan*</th>
	<th>Durasi Pelaksanaan*</th>
	<th>Nilai*</th>
	<th>Progress*</th>
	<th>Pengembalian*</th>
	-->
    </tr>
    <?php
    $r = 1;
    foreach ($records as $rec) : ?>
    <tr<?php echo !$rec->plan_id?' class="warning"':'' ?>>
      <td><?php echo $r ?></td>
      <!-- <td><select class="form-control" name="tahun_anggaran[<?php echo $rec->plan_id ?>]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select></td> -->
      <td class="impl_row"><strong><?php echo $rec->package_id ?></strong> <a class="btn btn-info with_tooltip btn-show-progress pull-right bg-color-green txt-color-white" href="<?php echo site_url('/non_proc/progress_detail/'.$rec->proposal_detail_id) ?>"
		title="Klik untuk menindaklanjuti detail program non-procurement implementation"><i class="glyphicon glyphicon-resize-vertical"></i> Detail Progress</a>
	    <div class="prog_detail_container"></div>
	  </td>
    </tr>
    <?php
    $r++;
    endforeach;
    ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
</div>
<input type="hidden" name="rpp_id" value="<?php echo $proposal_detail->id ?>" />
</form>
<!-- END form entry detail implementation -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';