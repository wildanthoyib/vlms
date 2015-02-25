<table class="table table-bordered table-condensed table-progress">
<tr class="bg-success">
  <th>Nomor</th>
  <th><i class="glyphicon glyphicon-paperclip"></i> Perkembangan Proses</th>
  <th><i class="glyphicon glyphicon-calendar"></i> Tanggal Proses</th>
  <th><i class="glyphicon glyphicon-tags"></i> Catatan Tahapan Kegiatan</th>
  <th><i class="glyphicon glyphicon-check"></i> Revisi</th>
</tr>
  <?php
  $p = 1;
  foreach ($this->Non_proc_model->getProgressData(array('proc_id' => $rec->plan_id)) as $prog_data) :
  ?>
  <tr>
    <td class="very-short centered"><?php echo $p; ?></td>
    <td class="short"><?php echo $prog_data->status ?></td>
    <td class="short"><?php echo date('d-m-Y', strtotime($prog_data->prog_date)) ?></td>
    <td class="long"><?php echo $prog_data->description ?></td>  
    <td><a href="<?php echo site_url('/non_proc/hapus_progress') ?>" progid="<?php echo $prog_data->impl_type.':'.$prog_data->proc_id.':'.$prog_data->prog_id ?>" class="btn btn-danger btn-hapus-progress"><i class="glyphicon glyphicon-trash"></i> Hapus </a></td>
  </tr>		  
  <?php
  $p++;
  endforeach;
  ?>
  <tr class="warning">
    <td class="very-short"><i class="glyphicon glyphicon-plus"></i></td>
    <td><select class="form-control with_tooltip progress_select" title="Pilih berdasarkan progress yang sedang berlangsung" name="prog_id[<?php echo $rec->plan_id ?>]">
	  <option value="0">Pilih progress</option>
	  <?php foreach ($list_status as $komp) : ?><option value="<?php echo $komp->id; ?>"<?php echo $komp->id==$rec->estimated_prog?' selected':''; ?>><?php echo $komp->status; ?></option><?php endforeach; ?></select></td>
    <td class="short"><input type="text" class="form-control datepicker prog_date" title="Isi sesuai dengan tanggal pengubahan status" placeholder="Tanggal progress" name="prog_date[<?php echo $rec->plan_id ?>]" data-dateformat="dd-mm-yy" /></td>
    <td class="long">
	  <input type="text" class="form-control" class="form-control with_tooltip" title="Isi catatan singkat mengenai progress ini bila ada" placeholder="Catatan progress (bila ada)" name="description[<?php echo $rec->plan_id ?>]"/>
	</td>
	<td><a href="<?php echo site_url('/non_proc/simpan_progress/'.$rec->plan_id) ?>" type="button" class="btn btn-primary btn-simpan-progress"><i class="glyphicon glyphicon-save"></i> Simpan </a></td>
  </tr>
  <tr class="table-contract<?php echo $rec->contract_no?' table-displayed':'' ?>">
    <td class="very-short">&nbsp;</td>
    <td colspan="4">
      
  <!-- Detail Tabel Kontrak-->
<table class="table table-condensed table-bordered">
<tr class="bg-success">
<th><i class="glyphicon glyphicon-star"></i> Pelaksana*</th>
<th><i class="glyphicon glyphicon-envelope"></i> Nomor Referensi Kontrak*</th>
<th><i class="glyphicon glyphicon-calendar"></i> Tanggal Pengajuan Progress*</th>
<th><i class="glyphicon glyphicon-time"></i> Durasi/Lama Waktu*</th>
<th><i class="glyphicon glyphicon-leaf"></i> Nominal (Rp)</th>
<!--<th><i class="glyphicon glyphicon-leaf"></i> Pengembalian (Rp)</th>-->
<th><i class="glyphicon glyphicon-save"></i> &nbsp;</th>
  </tr>
      <tr>
      <td>
        <input type="text" class="form-control with_tooltip" title="Nama pelaksana kegiatan" name="contractor" value="<?php echo $rec->contractor ?>" />
      </td>
      <td>
        <input type="text" class="form-control with_tooltip" title="Nomor Kontrak" placeholder="Nomor kontrak" name="contract_no" value="<?php echo $rec->contract_no ?>" />
      </td>
      <td>
        <input type="text" class="form-control datepicker with_tooltip contract_date" title="Isi sesuai dengan tanggal pelaksanaan kegiatan" placeholder="Tgl. pelaksanaan" name="impl_date" data-dateformat="dd-mm-yy" value="<?php echo $rec->impl_date ?>" />
      </td>
      <td>
        <input type="text" class="form-control with_tooltip" title="Isi sesuai dengan durasi pelaksanaan kegiatan" placeholder="Durasi" name="impl_duration" value="<?php echo $rec->impl_duration ?>" />
      </td>
      <td>
        <input type="text" class="form-control" name="impl_value" placeholder="Biaya" value="<?php echo number_format($rec->impl_value?$rec->impl_value:$rec->estimated_cost, 0, '', '.') ?>" />
      </td>
     <!--
 <td>
        <input type="text" class="form-control with_tooltip" title="Data pengembalian tidak boleh bernilai minus" placeholder="Pengembalian" name="refund" value="<?php echo $rec->refund ?>" />
      </td>
 -->
 <td><a href="<?php echo site_url('/non_proc/simpan_progress/'.$rec->plan_id) ?>" type="button" class="btn btn-primary btn-simpan-progress"><i class="glyphicon glyphicon-save"></i> Simpan </a></td>
      </tr>
      </table>

  </td>
  </tr>
</table>