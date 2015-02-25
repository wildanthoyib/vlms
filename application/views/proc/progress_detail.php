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
  <td class="very-short"><i class="glyphicon glyphicon-plus"></i></td>
  <td><select class="form-control with_tooltip progress_select" title="Pilih berdasarkan progress yang sedang berlangsung" name="prog_id[<?php echo $rec->plan_id ?>]">
    <option value="0">Pilih progress</option>
    <?php foreach ($list_status as $komp) : ?><option value="<?php echo $komp->id; ?>"><?php echo $komp->status; ?></option><?php endforeach; ?></select></td>
  <td class="short"><input type="text" class="form-control datepicker with_tooltip prog_date" title="Isikan dengan tanggal proses perkembangan implementasi" placeholder="Tanggal progress" name="prog_date[<?php echo $rec->plan_id ?>]" data-dateformat="dd-mm-yy" /></td>
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
    <th><i class="glyphicon glyphicon-star"></i> Kontraktor</th>
    <th><i class="glyphicon glyphicon-book"></i> Nomor Referensi Kontrak</th>
    <th><i class="glyphicon glyphicon-calendar"></i> Tanggal Proses</th>
    <th><i class="glyphicon glyphicon-time"></i> Durasi Kontrak</th>
    <th><i class="glyphicon glyphicon-leaf"></i> Nominal(Rp)</th>
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
    <input type="text" class="form-control datepicker contract_date" name="contract_date" placeholder="Tgl. kontrak" data-dateformat="dd-mm-yy" value="<?php echo $rec->contract_date ?>" />
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