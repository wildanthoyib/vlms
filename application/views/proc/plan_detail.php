<?php
ob_start();
/*$year_oldest = date('Y')-1;
$year_latest = date('Y')+4;*/
$year_oldest = 2013;
$year_latest = 2018;

$list_months = array(
  '1' => 'Januari', '2' => 'Februari', '3' => 'Maret',
  '4' => 'April', '5' => 'Mei', '6' => 'Juni',
  '7' => 'Juli', '8' => 'Agustus', '9' => 'September',
  '0' => 'Oktober', '11' => 'Nopember', '12' => 'Desember'
  );
$list_months_q1 = array(
  '1' => 'Januari', '2' => 'Februari', '3' => 'Maret');
$list_months_q2 = array(
  '4' => 'April', '5' => 'Mei', '6' => 'Juni');
$list_months_q3 = array(
  '7' => 'Juli', '8' => 'Agustus', '9' => 'September');
$list_months_q4 = array(
  '10' => 'Oktober', '11' => 'Nopember', '12' => 'Desember'
  );
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br />
  <div>Procurement Plan Detail for: <strong><?php echo $proposal_detail->contract ?> (<?php echo $proposal_detail->grantee ?>)</strong></div></div>
</h3>
<form role="form" id="form-proc-plan-detail" method="post" action="<?php echo site_url('/proc/simpan/detail') ?>">
<div class="form-group">
    <a href="<?php echo site_url('/proc/plan'); ?>" class="btn btn-info"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a href="<?php echo site_url('/proc/hapus_detail'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Paket</a>
  <a href="<?php echo site_url('/proc/impl_detail/'.$proposal_detail->id); ?>" class="btn btn-default with_tooltip bg-color-magenta txt-color-white" title="Melanjutkan ke proses progress procurement plan"><i class="glyphicon glyphicon-random"></i> Lihat <i>Implementation and Plan Realization</i></a>
</div>
<?php
$pesan = $this->session->flashdata('pesan_simpan');
$error = $this->session->flashdata('error_simpan');
$terhapus = $this->session->userdata('data_terhapus');
$error_melebihi_pagu = $this->session->flashdata('error_melebihi_pagu');
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
if ($error_melebihi_pagu) {
  $melebihi_pagu = json_decode($error_melebihi_pagu);
  echo '<div class="alert alert-danger alert-error"><ul>';
  foreach ($melebihi_pagu as $err) {
	echo '<li>'.$err.'</li>';
  }
  echo '</ul></div>';
}
?>
<div class="alert alert-warning">Pastikan memilih nama paket pengadaan, mengentri tanggal, menentukan metoda pengadaan, memberikan keterangan pengadaan, menuliskan harga perkiraan sementara dan memberikan keterangan terhadap paket pengadaan tersebut.!</div>
<div class="form-table table-overflow">
<!-- Form entry detail plan --><!--
<table id="tabel-form-plan-detail" class="table table-bordered table-striped table-condensed" align="center" valign="auto">-->
  <table id="tabel-form-plan-detail" class="table table-bordered table-striped table-condensed table-hover">
    <tr>
        <th class="very-short"><i class="glyphicon glyphicon-ok"></i></th>
        <!-- <th class="tahun-filterable">Tahun Anggaran</th> -->
        <th class="select2-max"><i class="glyphicon glyphicon-th-list"></i> Nama Paket <i>Procurement</i>*</th>
        <th><i class="glyphicon glyphicon-calendar"></i> Tanggal <i>Procurement</i>*</th>
        <th><i class="glyphicon glyphicon-hand-right"></i> Metode <i>Procurement</i>*</th>
        <th><i class="glyphicon glyphicon-star-empty"></i> Keterangan Review (Post/Prior)*</th>
	<!-- <th><i class="glyphicon glyphicon-leaf"></i> HPS/OE*(IDR/Rp)</th>  Nilai NOL--->
	<th><i class="glyphicon glyphicon-leaf"></i>Nominal NOL* (Rp)</th> <!-- Nilai NOL--->
	<th>Rencana Penarikan Q1</th>
	<th>Rencana Penarikan Q2</th>
	<th>Rencana Penarikan Q3</th>
	<th>Rencana Penarikan Q4</th>
	<th><i class="glyphicon glyphicon-tags"></i> Catatan Tentang Paket <i>Procurement</i></th>
    </tr>
    <?php
    $row_max = 1;
    $review = array('Prior', 'Post');
    foreach ($records as $rec) : ?>
    <tr>
        <td>
	  <input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" class="form-control with_tooltip" title="Klik kotak untuk memilih, kemudian klik tombol HAPUS" />
	</td>
        <!-- <td>
	<select class="form-control" name="tahun_anggaran[<?php echo $rec->id ?>]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select>
	</td> -->
        <td>
	  <select class="select2 with_tooltip" title="Pilih Nama Paket yang sesuai" name="proposal_detail_id[<?php echo $rec->id ?>]" data-select-width="450px"><?php foreach ($list_proposal_detail as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->proposal_detail_id?' selected':''; ?>><?php echo $komp->name_of_fpc.' - '.$komp->package_id.' - '.number_format($komp->value, 0, 0, '.'); ?></option><?php endforeach; ?></select>
	</td>
        <td>
	  <input type="text" class="form-control datepicker with_tooltip" title="Isi dengan Tanggal Pengadaan" name="proc_date[<?php echo $rec->id ?>]" data-dateformat="dd-mm-yy" value="<?php echo date('d-m-Y', strtotime($rec->proc_date)) ?>" />
	</td>
        <td>
	  <select class="form-control with_tooltip" title="Isi dengan metode pengadaan yang sesuai" name="proc_method[<?php echo $rec->id ?>]"><?php foreach ($list_proc_method as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->proc_method?' selected':''; ?>><?php echo $komp->procurement_method; ?></option><?php endforeach; ?></select>
	</td>
        <td>
	  <select class="form-control" name="prior_or_post[<?php echo $rec->id ?>]"><?php foreach ($review as $rv) : ?><option value="<?php echo $rv; ?>"<?php echo $rv==$rec->prior_or_post?' selected':''; ?>><?php echo $rv; ?></option><?php endforeach; ?></select>
	</td>
        <!-- <td>
	<select class="form-control with_tooltip" title="Isi dengan sumber dana yang sesuai" name="source_of_fund[<?php echo $rec->id ?>]"><?php foreach ($list_sof as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->source_of_fund; ?></option><?php endforeach; ?></select>
	</td> -->
        <td>
          <input type="text" class="form-control with_tooltip" title="Prakiraan Biaya tidak boleh bernilai minus" placeholder="Prakiraan Biaya" name="estimated_cost[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->estimated_cost, 0, 0, '.') ?>" >
          <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
        </td>
	<td>
	  <select name="plan_q1[<?php echo $rec->id ?>]" class="form-control"><?php foreach ($list_months_q1 as $m => $b) { echo '<option value="'.$m.'"'.( $rec->plan_q1==$m?' selected':'' ).'>'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q1_value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->plan_q1_value, 0, 0, '.') ?>" />
	</td>
	<td>
	  <select name="plan_q2[<?php echo $rec->id ?>]" class="form-control"><?php foreach ($list_months_q2 as $m => $b) { echo '<option value="'.$m.'"'.( $rec->plan_q2==$m?' selected':'' ).'>'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q2_value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->plan_q2_value, 0, 0, '.') ?>" />
	</td>
	<td>
	  <select name="plan_q3[<?php echo $rec->id ?>]" class="form-control"><?php foreach ($list_months_q3 as $m => $b) { echo '<option value="'.$m.'"'.( $rec->plan_q3==$m?' selected':'' ).'>'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q3_value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->plan_q3_value, 0, 0, '.') ?>" />
	</td>
	<td>
	  <select name="plan_q4[<?php echo $rec->id ?>]" class="form-control"><?php foreach ($list_months_q4 as $m => $b) { echo '<option value="'.$m.'"'.( $rec->plan_q4==$m?' selected':'' ).'>'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q4_value[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->plan_q4_value, 0, 0, '.') ?>" />
	</td>
	<td>
	  <input type="text" class="form-control with_tooltip" title="Isi Catatan Paket yang sesuai" name="description[<?php echo $rec->id ?>]" value="<?php echo $rec->description ?>" />
	</td>
    </tr>
    <?php endforeach;
    for ($r = 1; $r <= $row_max; $r++) :
    ?>
    <tr class="warning">
        <td>
	  <i class="glyphicon glyphicon-plus"></i>
	</td>
        <!-- <td>
	<select class="form-control" name="tahun_anggaran[]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select>
	</td> -->
        <td>
	  <select class="select2 with_tooltip" title="Pilih nama paket yang sesuai" name="proposal_detail_id[]" data-select-width="450px"><?php foreach ($list_proposal_detail as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->name_of_fpc.' - '.$komp->package_id.' - '.number_format($komp->value, 0, 0, '.'); ?></option><?php endforeach; ?></select>
	</td>
        <td>
	  <input type="text" class="form-control datepicker with_tooltip" title="Isi dengan tanggal pengadaan" name="proc_date[]" data-dateformat="dd-mm-yy" />
	</td>
        <td>
	  <select class="form-control with_tooltip" title="Isi dengan metode pengadaan yang sesuai" name="proc_method[]"><?php foreach ($list_proc_method as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->procurement_method; ?></option><?php endforeach; ?></select>
	</td>
        <td>
	  <select class="form-control" name="prior_or_post[]"><?php foreach ($review as $rv) : ?><option value="<?php echo $rv; ?>"><?php echo $rv; ?></option><?php endforeach; ?></select>
	</td>
        <!-- <td>
	<select class="form-control with_tooltip" title="Isi dengan sumber dana yang sesuai" name="source_of_fund[]"><?php foreach ($list_sof as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->source_of_fund; ?></option><?php endforeach; ?></select>
	</td> -->
        <td>
	  <input type="text" class="form-control with_tooltip" title="Prakiraan biaya tidak boleh bernilai minus" placeholder="Prakiraan Biaya" name="estimated_cost[]" >
	</td>
	<td>
	  <select name="plan_q1[]" class="form-control"><?php foreach ($list_months_q1 as $m => $b) { echo '<option value="'.$m.'">'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q1_value[]" value="0" />
	</td>
	<td>
	  <select name="plan_q2[]" class="form-control"><?php foreach ($list_months_q2 as $m => $b) { echo '<option value="'.$m.'">'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q2_value[]" value="0" />
	</td>
	<td>
	  <select name="plan_q3[]" class="form-control"><?php foreach ($list_months_q3 as $m => $b) { echo '<option value="'.$m.'">'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q3_value[]" value="0" />
	</td>
	<td>
	  <select name="plan_q4[]" class="form-control"><?php foreach ($list_months_q4 as $m => $b) { echo '<option value="'.$m.'">'.$b.'</option>';  } ?></select>
	  <input type="text" class="form-control with_tooltip" title="Isi dengan Nilai Rencana Penarikan"
		name="plan_q4_value[]" value="0" />
	</td>
	<td>
	  <input type="text" class="form-control" class="form-control with_tooltip" title="Isilah dengan catatan paket yang sesuai" name="description[]" />
	</td>
    </tr>
    <?php
    endfor;
    ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
    <a href="<?php echo site_url('/proc/hapus_detail'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Paket</a>
</div>
<input type="hidden" name="rpp_id" value="<?php echo $proposal_id ?>" />
</form>
<!-- END form entry detail plan -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';