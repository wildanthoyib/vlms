<?php
$page_title = 'Detail Mutasi Pegawai';
ob_start();
?>
<form action="<?php echo site_url('mutasi/simpan/detail'); ?>" method="post">
<fieldset>
<legend>Detail data mutasi</legend>
<div class="well">
  No Usul: <span class="detail-item"><?php echo $detail_mutasi['no_usul']; ?></span><br/>
  Tanggal Usul: <span class="detail-item"><?php echo date('d-m-Y', strtotime($detail_mutasi['tgl_usul'])); ?></span><br/>
  Nama Pegawai: <span class="detail-item"><?php echo $detail_mutasi['nama_pegawai'].' ('.$detail_mutasi['nip'].')'; ?></span>
  <input type="hidden" name="noUsul" value="<?php echo $detail_mutasi['no_usul']; ?>" />
  <input type="hidden" name="nip" value="<?php echo $detail_mutasi['nip']; ?>" />
</div>
<div class="row">
  <div class="span4">
    <div class="control-group">
      <label class="control-label">Ubah Status:</label>
      <div class="controls">
          <select name="status">
            <?php
              foreach ($proses as $id => $pr) :
                $selected = '';
                if ($id == $detail_mutasi['status']) {
                  $selected = ' selected="selected"';
                }
                echo '<option value="'.$id.'"'.$selected.'>'.$pr.'</option>';
              endforeach;
            ?>
          </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">Unit Kerja Lama:</label>
      <div class="controls detail-item">
        <?php echo $detail_mutasi['unit_kerja_asal']; ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="unitKerjaBaru">Unit Kerja Baru:</label>
      <div class="controls">
        <select class="select2" name="unitKerjaBaru">
          <option value="0">-- PILIH UNIT KERJA --</option>
          <?php
            foreach ($unit_kerja as $uk) :
              $selected = '';
              if ($uk->id == $detail_mutasi['unit_kerja_baru']) {
                $selected = ' selected="selected"';
              }
              echo '<option value="'.$uk->id.'"'.$selected.'>'.$uk->deskripsi.'</option>';
            endforeach;
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">Jabatan Lama:</label>
      <div class="controls detail-item">
        <?php echo $detail_mutasi['jabatan_lama']; ?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="usulJabatanBaru">Usul Jabatan Baru:</label>
      <div class="controls">
        <select class="select2" name="usulJabatanBaru">
          <option value="0">-- PILIH JABATAN --</option>
          <?php
            foreach ($jabatan as $jb) :
              $selected = '';
              if ($jb->id == $detail_mutasi['jabatan_baru']) {
                $selected = ' selected="selected"';
              }
              echo '<option value="'.$jb->id.'"'.$selected.'>'.$jb->deskripsi.'</option>';
            endforeach;
          ?>
        </select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="tahunMasaKerja">Tahun Masa Kerja:</label>
      <div class="controls detail-item">
        <input type="text" id="tahunMasaKerja" name="tahunMasaKerja" value="<?php echo $detail_mutasi['tahun_masa_kerja']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="bulanMasaKerja">Bulan Masa Kerja:</label>
      <div class="controls detail-item">
        <input type="text" id="bulanMasaKerja" name="bulanMasaKerja" value="<?php echo $detail_mutasi['bulan_masa_kerja']; ?>" />
      </div>
    </div>
  </div>

  <div class="span4">
    <div class="control-group">
      <label class="control-label" for="nomorUsulMelepas">Nomor Usul Melepas:</label>
      <div class="controls">
        <input type="text" id="nomorUsulMelepas" name="nomorUsulMelepas" value="<?php echo $detail_mutasi['no_usul_lepas']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="nomorSetujuMelepas">Nomor Persetujuan Melepas:</label>
      <div class="controls">
        <input type="text" id="nomorSetujuMelepas" name="nomorSetujuMelepas" value="<?php echo $detail_mutasi['no_setuju_lepas']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="tglSetujuMelepas">Tanggal Persetujuan Melepas:</label>
      <div class="controls">
        <div class="input-append">
          <input class="span2 opencalendar" id="tglSetujuMelepas" name="tglSetujuMelepas" type="text" value="<?php echo $detail_mutasi['tgl_setuju_lepas']; ?>" />
          <button class="btn opencalendar-btn" type="button"><i class="icon-calendar"></i></button>
        </div>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="nomorUsulMenerima">Nomor Usul Menerima:</label>
      <div class="controls">
        <input type="text" id="nomorUsulMenerima" name="nomorUsulMenerima" value="<?php echo $detail_mutasi['no_usul_terima']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="nomorSetujuMenerima">Nomor Setuju Menerima:</label>
      <div class="controls">
        <input type="text" id="nomorSetujuMenerima" name="nomorSetujuMenerima" value="<?php echo $detail_mutasi['no_setuju_terima']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="tglSetujuMenerima">Tanggal Persetujuan Menerima:</label>
      <div class="controls">
        <div class="input-append">
          <input class="span2 opencalendar" id="tglSetujuMenerima" name="tglSetujuMenerima" type="text" value="<?php echo $detail_mutasi['tgl_setuju_terima']; ?>" />
          <button class="btn opencalendar-btn" type="button"><i class="icon-calendar"></i></button>
        </div>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="jabatanPenerima">NIP Pejabat Penerima:</label>
      <div class="controls">
        <input type="text" id="jabatanPenerima" name="jabatanPenerima" value="<?php echo $detail_mutasi['jab_terima']; ?>" />
      </div>
    </div>
  </div>

  <div class="span4">
    <div class="control-group">
      <label class="control-label" for="tmtPindah">TMT Pindah:</label>
      <div class="controls">
        <div class="input-append">
          <input class="span2 opencalendar" id="tmtPindah" name="tmtPindah" type="text" value="<?php echo $detail_mutasi['tgl_tmt_pindah']; ?>" />
          <button class="btn opencalendar-btn" type="button"><i class="icon-calendar"></i></button>
        </div>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="gaji">Gaji:</label>
      <div class="controls">
        <input type="text" id="gaji" name="gaji" value="<?php echo $detail_mutasi['gaji']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="kppnLama">KKPN Lama:</label>
      <div class="controls">
        <div class="input-append">
          <input type="text" id="kppnLama" name="kppnLama" value="<?php echo $detail_mutasi['kppn_lama']; ?>" />
        </div>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="kppnBaru">KPPN Baru:</label>
      <div class="controls">
        <input type="text" id="kppnBaru" name="kppnBaru" value="<?php echo $detail_mutasi['kppn_baru']; ?>" />
      </div>
    </div>
    <div class="control-group">
      <label class="control-label">Cek kelengkapan dokumen:</label>
      <?php
      if (!empty($detail_mutasi['kelengkapan'])) {
        $kelengkapan = @unserialize($detail_mutasi['kelengkapan']);
      }
      foreach ($cek_dokumen as $id => $cek) :
        $checked = '';
        if (is_array($kelengkapan) && in_array($id, $kelengkapan)) {
          $checked = ' checked="checked"';
        }
        echo '<label class="checkbox"><input type="checkbox" name="kelengkapan[]" value="'.$id.'"'.$checked.'> '.$cek.'</label>'."\n";
      endforeach;
      ?>
    </div>
  </div>
  
  <!-- tombol simpan -->
  <div class="span9">
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="simpan" class="btn btn-primary">Update data mutasi</button>
      <button type="button" name="kembali" class="btn btn-warning back">Kembali</button>
    </div>
  </div>
  </div>
</div>
</fieldset>
</form>
<?php
$main_content = ob_get_clean();

require 'templates/default/main.tpl.php';