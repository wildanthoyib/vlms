<?php
ob_start();
$year_oldest = 2013;
$year_latest = 2018;
/*$year_oldest = date('Y')-1;
  $year_latest = date('Y')+4;*/
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div><strong>Number of Contract Implementation</strong></div></h4>
<form role="form" id="form-entryg1" method="post" action="<?php echo site_url('/rpp/approve/simpan') ?>">
<div class="form-group">
  <button type="submit" href="<?php echo site_url('/rpp/approve'); ?>" class="btn btn-primary">Approve RPP/DIPA</button>
</div>
<?php
$pesan = $this->session->flashdata('pesan_simpan');
if ($pesan) {
  echo '<div class="alert alert-success">'.$pesan.'</div>';
}
?>
<div class="form-table">
<!-- Form entry Proposal -->
<table id="tabel-form-g1" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="very-short">#</th>
        <th>Nama Grantee (PIU)</th>
        <th class="long">Rencana Pelaksanaan Proyek</th>
        <th>Tahun Anggaran</th>
        <th>Detail Approval</th>
        <th>Status</th>
        <th>Tanggal Status</th>
    </tr>
    <?php
    $row_max = 10;
    $r = 1;
    foreach ($records as $rec) : ?>
    <tr>
      <td><input type="checkbox" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" ></td>
      <td><?php echo $rec->name_of_grantee ?>
      <td><?php echo $rec->contract ?>
      <input type="hidden" name="id[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" >
      </td>
      <td><?php echo $rec->year ?></td>
      <td><a href="<?php echo site_url('/rpp/detail/'.$rec->id); ?>" class="btn btn-warning"><i class="glyphicon glyphicon-plus-sign"></i> Detail RPP</a></td>
      <td><?php echo $rec->approval==1?'<span class="label label-danger">Belum selesai</span>':'Sudah selesai' ?></td>
      <td class="short"><?php echo date('d-m-Y') ?></td>
    </tr>
    <?php
      $r++;
    endforeach;
    ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary">Approve RPP</button>
</div>
</form>
<!-- END form entry Proposal -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
