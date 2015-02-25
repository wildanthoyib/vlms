<?php
ob_start();
?>
<h3>Polytechnic Education Development Project ADB Loan No.2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong><br />
  <div>Procurement Implementation Detail for: <strong><?php echo $proposal_detail->contract ?> (<?php echo $proposal_detail->grantee ?>)</strong></div></div></h3>
    <form role="form" id="form-proc-plan-detail" method="post" action="<?php echo site_url('/proc/simpan/impl') ?>">
  <div class="form-group">
    <a type="submit" href="<?php echo site_url('/impl/proc'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-home"></i> Kembali ke depan</a>
    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan Data</button>
    <a type="submit" href="<?php echo site_url('/proc/detail/'.$proposal_detail->id); ?>" class="btn btn-default with_tooltip bg-color-magenta txt-color-white" title="Melihat kembali data utama procurement plan"><i class="glyphicon glyphicon-inbox"></i> Lihat Data <i>Procurement Plan</i></a>
  </div>
<?php
$pesan = $this->session->flashdata('pesan_simpan');
if ($pesan) {
  echo '<div class="alert alert-success">'.$pesan.'</div>';
}
?>
<div class="alert alert-warning">Pastikan anda telah mengisi data <strong>Procurement Plan</strong> terlebih dahulu!</div>
<div class="form-table">
<!-- Form entry detail implememtation -->
<table id="tabel-form-implementation-detail" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
      <th class="very-short">Nomor</th>
      <th>Deskripsi Nama Paket</th>
    </tr>
    <?php
    $r = 1;
    $review = array('Prior', 'Post');
    foreach ($records as $rec) : ?>
    <tr<?php echo !$rec->plan_id?' class="warning"':'' ?>>
      <td><?php echo $r ?></td>
      <td class="impl_row"><strong><?php echo $rec->package_id ?></strong>
	<a class="btn btn-info with_tooltip btn-show-progress pull-right bg-color-green txt-color-white" href="<?php echo site_url('/proc/progress_detail/'.$rec->proposal_detail_id) ?>"title="Klik untuk menindaklanjuti detail program procurement implementation"><i class="glyphicon glyphicon-resize-vertical"></i> Detail Progress</a>
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
  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i>Simpan Data</button>
</div>
<input type="hidden" name="rpp_id" value="<?php echo $proposal_detail->id ?>" />
</form>
<!-- END form entry detail plan -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';

/*
      <!-- <td><select class="form-control" name="tahun_anggaran[<?php echo $rec->plan_id ?>]"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select></td> -->
      <td><?php echo $rec->package_id ?> <a class="btn btn-info with_tooltip btn-show-progress pull-right bg-color-green txt-color-white" title="Klik untuk menindaklanjuti detail program procurement implementation"><i class="glyphicon glyphicon-resize-vertical"></i> Detail Progress</a>
	  <!--
	  <td><select class="select2" name="contractor_id[<?php echo $rec->plan_id ?>]"><option value="0">--PILIH KONTRAKTOR--</option><?php foreach ($list_contractor as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->contractor_id?' selected':''; ?>><?php echo $komp->name_of_contractor; ?></option><?php endforeach; ?></select></td>
      <td><input type="text" class="form-control" name="contract_no[<?php echo $rec->plan_id ?>]" value="<?php echo $rec->contract_no ?>" /></td>
      <td><input type="text" class="form-control datepicker" name="contract_date[<?php echo $rec->plan_id ?>]" data-dateformat="dd-mm-yy" value="<?php echo $rec->contract_date ?>" /></td>
      <td><input type="text" class="form-control" name="contract_duration[<?php echo $rec->plan_id ?>]" value="<?php echo $rec->contract_duration ?>" /></td>
      <td><input type="text" class="form-control" name="contract_value[<?php echo $rec->plan_id ?>]" value="<?php echo $rec->contract_value?$rec->contract_value:$rec->estimated_cost ?>" /></td>
	  -->
	  <!-- detail progress -->
	  <table class="table table-bordered table-condensed table-progress">
	    
	    <tr class="bg-success">
	      <th>Nomor</th>
	      <th><i class="glyphicon glyphicon-paperclip"></i> Perkembangan Proses</th>
	      <th><i class="glyphicon glyphicon-calendar"></i> Tanggal Proses</th>
	      <th><i class="glyphicon glyphicon-tags"></i> Catatan Tahapan Kegiatan</th>
	      <th>Revisi</th>
	    </tr>
	    
	    <?php
		$p = 1;
	    foreach ($this->Proc_model->getProgressData(array('proc_id' => $rec->plan_id)) as $prog_data) :
	    ?>
	    <tr>
	      <td class="very-short"><?php echo $p; ?></td>
	      <td class="short"><?php echo $prog_data->status ?></td>
	      <td class="short"><?php echo date('d-m-Y', strtotime($prog_data->prog_date)) ?></td>
	      <td class="long"><?php echo $prog_data->description ?></td>
	      <td><a href="<?php echo site_url('/proc/hapus_progress') ?>" progid="<?php echo $prog_data->impl_type.':'.$prog_data->proc_id.':'.$prog_data->prog_id ?>" class="btn btn-danger btn-hapus-progress"><i class="glyphicon glyphicon-trash"></i> Hapus</a></td>
	    </tr>		  
	    <?php
		$p++;
	    endforeach;
	    ?>
	    <tr class="warning">
		  <td class="very-short">Nomor</td>
		  <td><select class="form-control with_tooltip progress_select" title="Pilih berdasarkan progress yang sedang berlangsung" name="prog_id[<?php echo $rec->plan_id ?>]">
		    <option value="0">Pilih progress</option>
		    <?php foreach ($list_status as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->status; ?></option><?php endforeach; ?></select></td>
		  <td class="short"><input type="text" class="form-control datepicker with_tooltip" title="Isikan dengan tanggal proses perkembangan implementasi" placeholder="Tanggal progress" name="prog_date[<?php echo $rec->plan_id ?>]" data-dateformat="dd-mm-yy" /></td>
		  <td class="long">
		    <input type="text" class="form-control with_tooltip" title="Tuliskan tentang catatan terhadap progress detail tahapan ini" placeholder="Catatan progress (bila ada)" name="description[<?php echo $rec->plan_id ?>]"/>
		  </td>
		  <td><a href="<?php echo site_url('/proc/simpan_progress/'.$rec->plan_id) ?>" class="btn btn-primary btn-simpan-progress"><i class="glyphicon glyphicon-save"></i> Simpan </a></td>
	    </tr>
		<tr class="table-contract<?php echo $rec->contract_no?' table-displayed':'' ?>">
		  <td class="very-short">&nbsp;</td>
		  <td colspan="4">
		    
	    <!-- Tabel Detail Contract-->
        <table class="table table-condensed table-bordered">
	    <tr class="bg-success">
		<th>Kontraktor</th>
		<th><i class="glyphicon glyphicon-book"></i> Nomor Referensi Kontrak</th>
		<th>Metode</th>
		<th><i class="glyphicon glyphicon-calendar"></i> Tanggal Proses</th>
		<th><i class="glyphicon glyphicon-time"></i> Durasi Kontrak</th>
		<th>Nominal(Rp)</th>
		<!--<th><i class="glyphicon glyphicon-leaf"></i> Pengembalian(Rp)</th>-->
		<th><i class="glyphicon glyphicon-save"></i>&nbsp;</th>
	      </tr>
	      <tr>
		    <td>
		    <select class="select2" name="contractor_id"><option value="0">--Pilih Kontraktor--</option><?php foreach ($list_contractor as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->contractor_id?' selected':''; ?>><?php echo $komp->name_of_contractor; ?></option><?php endforeach; ?></select>
		    </td>
                    <td>
		    <input type="text" class="form-control" name="contract_no" placeholder="Nomor kontrak" value="<?php echo $rec->contract_no ?>" />
		    </td>
		    <td>
		    <select class="select2" name="Method"><option value="0">--Pilih Metode--</option><?php foreach ($list_method as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->consultingmethod_id?' selected':''; ?>><?php echo $komp->method; ?></option><?php endforeach; ?></select>
		    </td>
                    <td>
		    <input type="text" class="form-control datepicker" name="contract_date" placeholder="Tgl. kontrak" data-dateformat="dd-mm-yy" value="<?php echo $rec->contract_date ?>" />
		    </td>
                    <td>
		    <input type="text" class="form-control" name="contract_duration" placeholder="Durasi" value="<?php echo $rec->contract_duration ?>" />
		    </td>
                    <td>
		    <input type="text" class="form-control" name="contract_value" placeholder="Nilai kontrak" value="<?php echo number_format($rec->contract_value?$rec->contract_value:$rec->estimated_cost,0,'','.') ?>" />
		    </td>
		   <!-- <td>
		    <input type="text" class="form-control with_tooltip" contract="Data pengembalian tidak boleh bernilai minus" placeholder="Pengembalian" name="refund" value="<?php echo $rec->refund ?>" />
		    </td>-->
		    <td><a href="<?php echo site_url('/proc/simpan_progress/'.$rec->plan_id) ?>" class="btn btn-primary btn-simpan-progress"><i class="glyphicon glyphicon-save"></i> Simpan </a></td>
	      </tr>
            </table>

	    </td>
	  </tr>
	  </table>
*/