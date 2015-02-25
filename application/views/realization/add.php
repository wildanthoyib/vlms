<?php
ob_start();
$list_impl_type['Proc'] = 'Procurement';
$list_impl_type['Non-Proc'] = 'Non-Procurement';
?>
<h3>
<div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?><br />Add <strong>Financial</strong> Realization Form</div></h3>
<form role="form" id="form-rpp" method="post" action="<?php echo site_url('/realization/simpan') ?>" enctype="multipart/form-data">
<div class="form-group">
  <a type="submit" href="<?php echo site_url('/realization/index'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
</div>
<div class="alert alert-warning">Pastikan untuk mengentri nomor surat perintah pencairan dana, menuliskan tanggal terbit SP2D, menentukan nomor kontrak DIKTI, mengunggah bukti fisik berupa hasil <i>Scan file</i> SP2D, mengetikan keterangan yang tertera dalam SP2D berkaitan dengan SPM, mengentrikan nilai kurs dollar terhadap rupiah yang tertera dalam SP2D. Selanjutnya menentukan mekanisme tender, kemudian mengetikan 3 karakter atau lebih terhadap cost-component yang sudah terikat kontrak, memberikan keterangan terhadap transaksi dan menuliskan nilai(Rp) paket/kegiatan tersebut!  </div>
<div class="form-table">
<!-- Form entry Financial Realization -->
<table id="tabel-form-financial_realization" class="table table-bordered table-striped table-condensed" align="center">
    <tr>
        <!-- <th class="very-short">No.</th> -->
        <th><i class="glyphicon glyphicon-sort-by-order"></i>Nomor SP2D*</th>
        <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><th>PIU/Grantee</th><?php endif; ?>
        <th><i class="glyphicon glyphicon-calendar"></i> Tanggal diterbitkan SP2D*</th>
        <th><i class="glyphicon glyphicon-book"></i> Nomor Kontrak DIKTI*</th>
        <th><i class="glyphicon glyphicon-file"></i> Bukti Fisik/Berkas SP2D</th>
	<th><i class="glyphicon glyphicon-tag"></i> Keterangan SP2D</th>
	<th><i class="glyphicon glyphicon-transfer"></i>USD ke IDR (Kurs Dollar Amerika)</th>
    </tr>
    <?php
    $row_max = 1;
    for ($r = 1; $r <= $row_max; $r++) : ?>
    <script type="text/javascript">

    var rowSelect2 = '<tr><td><select class="form-control impl_type" name="impl_detail[impl_type][]"><?php foreach ($list_impl_type as $val => $text) : ?><option value="<?php echo $val; ?>"><?php echo $text; ?></option><?php endforeach; ?></select></td>'
      + '<td><input type="hidden" class="select2 impl_detail" name="impl_detail[impl_detail_id][]" href="<?php echo site_url('realization/ajax'); ?>" placeholder="Cari pelaksanaan..." /></td>'
      + '<td><input type="text" class="form-control" placeholder="Nama Penerima" name="impl_detail[nama_penerima][]" /></td>'
      + '<td><input type="text" class="form-control" placeholder="Keterangan Transaksi" name="impl_detail[notes][]" /></td>'
      + '<td><input type="text" class="form-control" placeholder="Nilai" name="impl_detail[value][]" /></td>'
      + '<td><a class="btn btn-danger btn-hps-detail-sppd rm-current-row">Hapus Data</a></td></tr>';
  
    </script>
    <tr>
        <!-- <td><?php echo $r ?></td> -->
        <td><input type="text" class="form-control with_tooltip" title="Isikan Nomor SP2D (Surat Perintah Pencairan Dana)" placeholder="Entry Nomor Surat Perintah Pencairan Dana" name="sp2d_number[]"></td>
        <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
        <td>
          <select placeholder="Grantee" class="select2" name="grantee_id[]">
          <?php foreach ($list_pid as $komp) : ?>
            <option value="<?php echo $komp->id; ?>"><?php echo $komp->name_of_grantee ?></option>
          <?php endforeach; ?>
          </select>
        </td>
        <?php endif; ?>
        <td><input type="text" class="form-control datepicker with_tooltip" title="Isi sesuai dengan tanggal Pencairan SP2D" placeholder="Silahkan Click" name="sp2d_date[]" data-dateformat="dd-mm-yy" /></td>
        <td><select class="form-control with_tooltip" title="Pilih sesuai dengan proposal yang diajukan" name="proposal_id[]"><?php foreach ($list_proposal as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->contract; ?></option><?php endforeach; ?></select></td>
        <td><input type="file" class="with_tooltip" title="Klik untuk mengunggah berkas SP2D" placeholder="Upload berkas" size="20" name="upload_sp2d" ></td>
	<td><input type="text" class="form-control with_tooltip" title="Silahkan menuliskan keterangan penggunaan bukti SP2D(Surat Perintah Pencairan Dana)" placeholder="Entry Penjelasan keterangan dari bukti pencairan SP2D" name="ket_sp2d[]"></td>
	<td><input type="text" class="form-control with_tooltip" title="Masukan sesuai kurs yang tertulis dalam SP2D" placeholder=" Entry Nominal Dollar Amerika" name="kurs_dollar[]"></td>
	    
	</tr>
    <tr>
        <!-- <td>&nbsp;</td> -->
        <td colspan="7">
		  <!-- detail transaksi -->
		  <table class="table table-bordered table-striped table-condensed table-sp2d-detail" align="center">
            <tr>
              <th class="short"><i class="glyphicon glyphicon-briefcase"></i> Jenis Pelaksanaan*</th>
              <th class="select2-max"><i class="glyphicon glyphicon-list-alt"></i> Pelaksanaan dan Nomor Kontrak*</th>
              <!--<th>Nama Penerima*</th>-->
              <th class="short"><i class="glyphicon glyphicon-tag"></i> Keterangan Transaksi*</th>
              <th class="short"><i class="glyphicon glyphicon-leaf"></i> Nilai (Rp)*</th>
              <th><i class="glyphicon glyphicon-off"></i> &nbsp;</th>
	    </tr>
	    <?php
	    $d_row_max = 5;
	    for ($n = 1; $n <= $d_row_max; $n++) : ?>
	    <tr class="sp2d-detail-row">
          <td><select class="form-control impl_type with_tooltip" title="Pilih mekanisme tender" name="impl_detail[impl_type][]"><?php foreach ($list_impl_type as $val => $text) : ?><option value="<?php echo $val; ?>"><?php echo $text; ?></option><?php endforeach; ?></select></td>
          <!-- <td><select class="select2" name="impl_detail[impl_detail_id][1]" href="<?php echo site_url('realization/ajax'); ?>"><option name="0">CARI PELAKSANAAN...</option></select></td> -->
          <td><input data-select-width="400px" type="text" class="select2 impl_detail with_tooltip" title="Isi sesuai dengan data implementasi yang sudah diinput sebelummnya " name="impl_detail[impl_detail_id][]" href="<?php echo site_url('realization/ajax'); ?>" placeholder="Cari pelaksanaan..." /></td>
          <!--<td><input type="text" class="form-control with_tooltip" title="Isi sesuai dengan nama penerima" placeholder="Nama Penerima" name="impl_detail[recipient][]" /></td>-->
	      <td><input type="text" class="form-control with_tooltip" title="Isi dengan detail transaksi" placeholder="Keterangan Transaksi" name="impl_detail[notes][]" /></td>
          <td><input type="text" class="form-control with_tooltip" title="Nilai yang diisi tidak boleh minus" placeholder="Nilai dalam Rupiah" name="impl_detail[value][]" /></td>
          <td><a class="btn btn-danger btn-hps-detail-sppd rm-current-row"><i class="glyphicon glyphicon-trash"></i> Hapus</a></td>
		</tr>
	    <?php endfor; ?>
		  </table>
		  <!-- <a class="btn btn-warning add-transaction" href="#"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Transaksi</a> -->
		  <!-- END detail transaksi -->
		</td>
	    </tr>
    <?php endfor; ?>
</table>
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
</div>
</form>
<!-- END form entry Proc Plan -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';