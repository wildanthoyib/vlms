<?php
ob_start();
$year_oldest = 2013;
$year_latest = 2018;
/*$year_oldest = date('Y')-1;
  $year_latest = date('Y')+4;*/
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br /><strong>Main of Disbursement - Financial Realization</strong></div></h3>
<form role="form" id="form-realization" enctype="multipart/form-data" method="post" action="<?php echo site_url('/realization/simpan') ?>">
<div class="form-group">
  <a href="<?php echo site_url('/realization/add'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Data Pencairan (SP2D)</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a href="<?php echo site_url('/realization/hapus'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a>
</div>
<?php
$pesan = $this->session->flashdata('pesan_simpan');
$error = $this->session->flashdata('error_simpan');
$terhapus = $this->session->userdata('data_terhapus');
$upload_error = $this->session->flashdata('upload_error');
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
if ($upload_error) {
  echo '<div class="alert alert-danger">File upload error with message: '.$upload_error.'</div>';
}
?>
<div class="form-table table-overflow">

<!-- Form entry Proposal -->
<table id="tabel-form-entry-proposal" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short"><i class="glyphicon glyphicon-ok"></i></th>
        <th class="long"><i class="glyphicon glyphicon-sort-by-order"></i> Nomor SP2D</th>
            <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
        <th class="long">Name of Grantee(PIU)</th><?php endif; ?>
        <th class="long"><i class="glyphicon glyphicon-calendar"></i> Tanggal SP2D</th>
        <th class="long"><i class="glyphicon glyphicon-book"></i> Nomor Kontrak Implementasi</th>
        <th class="short"><i class="glyphicon glyphicon-transfer"></i> Kurs* (USD to IDR)</th>
        <th><i class="glyphicon glyphicon-file"></i> Bukti Fisik/Berkas SP2D</th>
        <th class="long"><i class="glyphicon glyphicon-tag"></i> Keterangan SP2D</th>
        <th class="short"><i class="glyphicon glyphicon-list"></i> Rincian Pencairan/<i>Disbursement</i></th>
    </tr>
    <?php
    $row_max = 5;
    $r = 1;
    foreach ($records as $rec) : ?>
    <tr>
        <td><input type="checkbox" class="form-control with_tooltip" title="Klik kotak untuk memilih" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" ></td>
        <td><input type="text" class="form-control with_tooltip" title="Isilah dengan nomor Surat Perintah Pencairan Dana yang sudah dikeluarkan KPPN" placeholder="Nomor SP2D" name="sp2d_number[<?php echo $rec->id ?>]" value="<?php echo $rec->sp2d_number ?>" >
          <input type="hidden" name="updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" >
        </td>
        <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
        <td><?php echo $rec->name_of_grantee ?></td>
        <?php endif; ?>
        <td><input type="text" class="form-control datepicker with_tooltip" title="Isilah dengan tanggal pencairan SP2D" name="sp2d_date[<?php echo $rec->id ?>]" value="<?php echo date('d-m-Y', strtotime($rec->sp2d_date)) ?>" data-dateformat="dd-mm-yy" /></td>
        <td><select class="form-control" class="with_tooltip" title="Pilih Rencana Pelaksanaan Proyek" name="proposal_id[<?php echo $rec->id ?>]"><?php foreach ($list_proposal as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->proposal_id?'selected':''; ?>><?php echo $komp->contract; ?></option><?php endforeach; ?></select></td>
        <td><input type="text" class="form-control with_tooltip" title="Konversi Kurs US Dollar ke Indonesia Rupiah " name="kurs_dollar[<?php echo $rec->id ?>]" value="<?php echo number_format($rec->kurs_dollar,0,'','.') ?>"  /></td>
        <td>
          <?php if ($rec->file) { echo '<a href="'.base_url('/files/financial/'.$rec->file).'" class="download-link with_tooltip" title="Unduh Berkas SP2D">Lihat/Unduh Berkas SP2D</a>'; } ?>
          <input type="file" class="with_tooltip" title="Berkas Scan SP2D" placeholder="Upload berkas scan" name="upload_sp2d_batch[<?php echo $rec->id ?>]" >
        </td>
        <td><input type="text" class="form-control" readonly="readonly" name="ket_sp2d[<?php echo $rec->id ?>]" value="<?php echo $rec->ket_sp2d ?> "> </input></td>
        <td><a href="<?php echo site_url('realization/detail/'.$rec->id) ?>" class="btn btn-warning with_tooltip" title="Klik untuk melihat detail implementasi" ><i class="glyphicon glyphicon-tasks"></i> Detail Disbursement</a></td>
    </tr>
    <?php
      $r++;
    endforeach;
    ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
   <a href="<?php echo site_url('/realization/hapus'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a>
</div>
</form>
<!-- END form entry Proposal -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
