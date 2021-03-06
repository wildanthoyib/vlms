<?php
ob_start();
?>
<h3>Polytechnic Education Development Project (PEDP) ADB Loan No. 2928-INO<div>Name of Grantee: <strong><?php echo $user_data['realname']  ?><br />Main of Non-Procurement Implementation</strong></div></h3>
<!-- filter -->

<div class="panel panel-default search-box">
  <div class="panel-heading">Filtering data nomor kontrak implementasi non-procurement</div>
  <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/non_proc/impl'); ?>">
	  <div class="form-group">
        <label class="sr-only" for="keywords">Kata kunci</label>
		<input type="text" class="form-control" id="keywords" name="keywords" placeholder="Nomor Kontrak" />
	    <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?>
          <div class="make-inline-block">
	      <select placeholder="Grantee" class="select2" name="search_grantee" data-select-width="250px">
            <option value=''>-- PIU/Grantee --</option>
	      <?php foreach ($list_pid as $komp) : ?>
	        <option value="<?php echo $komp->id; ?>"><?php echo $komp->name_of_grantee ?></option>
	      <?php endforeach; ?>
	      </select>
          </div>
	    <?php endif; ?>
      </div>	  
	  <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-filter"></i> Filter Data</button>
	</form>
  </div>
<div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data</div>
</div>
<!-- end of filter -->

<div class="alert alert-warning">Pastikan menentukan nomor kontrak implementasi Non-Procurement untuk tindak lanjut proses progress detail</div>
<!-- daftar Proposal -->
<table id="tabel-form-proc" class="table table-bordered table-striped table-condensed" align="center" valign="middle">
    <tr>
        <th class="short">Nomor</th>
        <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><th>PIU/Grantee</th><?php endif; ?>
        <th class="long"><i class="glyphicon glyphicon-book"></i> Kontrak</th>
        <th><i class="glyphicon glyphicon-calendar"></i> Tahun Anggaran</th>
        <th><i class="glyphicon glyphicon-list"></i> Detail Pelaksanaan <i>Non-Procurement</i></th>
    </tr>
    <?php
    $row_max = 5;
    $r = 1;
    foreach ($records as $rec) : ?>
    <tr>
        <td><?php echo $r ?></td>
        <?php if ('pmu' == $user_data['groups'] || 'admin' == $user_data['groups']) : ?><td><?php echo $rec->name_of_grantee ?></td><?php endif; ?>
        <td><?php echo $rec->contract ?></td>
        <td><?php echo $rec->year ?></td>
        <td><a href="<?php echo site_url('/non_proc/impl_detail/'.$rec->id); ?>" class="btn btn-default with_tooltip bg-color-green txt-color-white" title="Klik untuk mengisi detail program non-procurement plan"><i class="glyphicon glyphicon-tasks"></i> Detail Pelaksanaan <i>Non-Procurement</i></a></td>
    </tr>
    <?php
      $r++;
    endforeach;
    ?>
</table>
<!-- END daftar Proposal -->
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';
