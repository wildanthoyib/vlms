<?php
ob_start();
$list_impl_type['Proc'] = 'Procurement';
$list_impl_type['Non-Proc'] = 'Non-Procurement';
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br />
  <div>Financial Realization Detail for SP2D number: <strong><?php echo $realization->sp2d_number.' ('.date('D, j-M-Y', strtotime($realization->sp2d_date)).')'; ?></strong></div></h3>
<form role="form" id="form-rpp" method="post" action="<?php echo site_url('/realization/simpan') ?>">
<div class="form-group">
  <a href="<?php echo site_url('/realization/index'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
  <a href="<?php echo site_url('/realization/hapus/detail'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Paket/Kegiatan</a>
</div>
<?php
$pesan = $this->session->flashdata('pesan_simpan');
if ($pesan) {
  echo '<div class="alert alert-success">'.$pesan.'</div>';
}
?>
<div class="form-table">
<script type="text/javascript">

var rowSelect2 = '<tr class="warning"><td><i class="glyphicon glyphicon-plus"></i></td>'
  + '<td><select class="form-control impl_type" name="impl_detail[impl_type][]"><?php foreach ($list_impl_type as $val => $text) : ?><option value="<?php echo $val; ?>"><?php echo $text; ?></option><?php endforeach; ?></select></td>'
  + '<td><input type="hidden" class="select2 impl_detail" name="impl_detail[impl_detail_id][]" href="<?php echo site_url('realization/ajax'); ?>" placeholder="Cari pelaksanaan..." /></td>'
  + '<td><input type="text" class="form-control" placeholder="Nama Penerima" name="impl_detail[nama_penerima][]" /></td>'
  + '<td><input type="text" class="form-control" placeholder="Keterangan Transaksi" name="impl_detail[notes][]" /></td>'
  + '<td><input type="text" class="form-control" placeholder="Nilai" name="impl_detail[value][]" /></td>'
  + '<td><a class="btn btn-danger btn-hps-detail-sppd rm-current-row">Hapus</a></td></tr>';

</script>
<div class="alert alert-warning">Pastikan telah memilih mekanisme tender, kemudian mengetikan 3 karakter atau lebih terhadap cost-component yang sudah terikat kontrak, memberikan keterangan terhadap transaksi dan menuliskan nilai(Rp) paket/kegiatan tersebut! </div>
<!-- detail transaksi -->
<table class="table table-bordered table-striped table-condensed table-sp2d-detail" align="center">
  <tr>
    <th class="very-short"><i class="glyphicon glyphicon-ok"></i></th>
    <!--
    <th>Komponen Proyek*</th>
    <th>Nama Kegiatan*</th>
    <th>Nama Penerima*</th>
    -->
    <th colspan="2"><i class="glyphicon glyphicon-th-list"></i> Detail Paket/Kegiatan Terkontrak atau Terlaksana</th>
    <th class="long"><i class="glyphicon glyphicon-paperclip"></i> Keterangan Transaksi</th>
    <th><i class="glyphicon glyphicon-leaf"></i> Nominal (Rp)</th>
  </tr>
  <?php foreach ($records as $rec) : ?>
  <tr class="sp2d-detail-row">
    <td><input type="checkbox" class="form-control with_tooltip" title="Klik kotak untuk memilih, kemudian klik tombol HAPUS" name="chbox[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" /></td>
    <td colspan="2"><span class="big">
	  <?php
	    $realization_detail = $this->Realization_model->getImplementationName($rec->impl_detail_id, $rec->impl_type);
		if ($realization_detail) {
		  echo $realization_detail->name.' - '.( $rec->impl_type=='Proc'?$realization_detail->name_of_contractor:$realization_detail->contractor );
		  echo '<div class="sp2d_detail_contractno">Contract no: '.$realization_detail->contract_no.'</div>';
		}
	  ?>
	  </span>
      <input type="hidden" name="impl_detail_updateID[<?php echo $rec->id ?>]" value="<?php echo $rec->id ?>" />
    </td>
    <!-- <td><input type="text" class="form-control" placeholder="Nama Penerima" name="impl_detail[recipient][<?php echo $rec->id ?>]" value="<?php echo $rec->recipient ?>" /></td> -->
    <td><input type="text" class="form-control" placeholder="Keterangan Transaksi" name="impl_detail[notes][<?php echo $rec->id ?>]" value="<?php echo $rec->notes ?>" /></td>
    <td><input type="text" class="form-control" placeholder="Nilai" name="impl_detail[value][<?php echo $rec->id ?>]" value="<?php echo number_format($rec->value, 0, '', '.') ?>" /></td>
  </tr>
  <?php endforeach; ?>
    <tr>
    <th class="very-short"><i class="glyphicon glyphicon-repeat"></i></th>
    <th><i class="glyphicon glyphicon-briefcase"></i> Mekanisme Penawaran</th>
     <th><i class="glyphicon glyphicon-list"></i> Paket/Kegiatan Terkontrak atau Terlaksana</th>
    <th class="long"><i class="glyphicon glyphicon-paperclip"></i> Keterangan Transaksi</th>
    <th><i class="glyphicon glyphicon-leaf"></i> Nominal (Rp)</th>
  </tr>
  <tr class="sp2d-detail-row warning">
    <td><i class="glyphicon glyphicon-plus"></i></td>
    <td><select class="form-control impl_type" name="impl_detail[impl_type][0]"><?php foreach ($list_impl_type as $val => $text) : ?><option value="<?php echo $val; ?>"><?php echo $text; ?></option><?php endforeach; ?></select></td>
    <!-- <td><select class="select2" name="impl_detail[impl_detail_id][1]" href="<?php echo site_url('realization/ajax'); ?>"><option name="0">CARI PELAKSANAAN...</option></select></td> -->
    <td style="width: 300px"><input data-select-width="300px" type="hidden" class="select2 impl_detail" name="impl_detail[impl_detail_id][0]" href="<?php echo site_url('realization/ajax'); ?>" placeholder="Cari paket/kegiatan..." /></td>
    <!-- <td><input type="text" class="form-control" placeholder="Nama Penerima" name="impl_detail[recipient][]" /></td> -->
    <td><input type="text" class="form-control with_tooltip" placeholder="Keterangan Transaksi" title="Ketikkan Keterangan Transaksi dalam SP2D" name="impl_detail[notes][0]" /></td>
    <td><input type="text" class="form-control with_tooltip" placeholder="Nilai" title="Isikan dengan nilai nominal yang tertulis di SP2D" name="impl_detail[value][0]" /></td>
  </tr>
</table>
<!-- <a class="btn btn-warning add-transaction" href="#"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Transaksi</a> -->
</div>
<div class="form-group">
  <input type="hidden" name="realizationID" value="<?php echo $realization->id ?>"/>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
   <a href="<?php echo site_url('/realization/hapus/detail'); ?>" class="btn btn-danger btn-hapus-data"><i class="glyphicon glyphicon-trash"></i> Hapus Paket/Kegiatan</a>
</div>
</form>
<!-- END of realization detail -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';