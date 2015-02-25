<?php
$year_list = array('2013', '2014', '2015', '2016', '2017');
ob_start();
function get_quarter($monthNumber) {
  return floor(($monthNumber - 1) / 3) + 1;
}

function build_query() {
  $ci = &get_instance();
  $gets = $ci->input->get();
  if ($gets) {
	array_push($gets, array('print' => 'yes'));
	return http_build_query($gets);
  } else {
	return 'print=yes';
  }
}

$year_oldest = date('Y')-1;
$year_latest = date('Y')+4;

ob_start();
?>
<h3 class="page-title txt-color-blueDark"><div id="print">Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1G: Summary Statement Expenditures</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1 G1: Recapitulation of Payment Report</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	    <!-- start toolbar -->
		<div class="widget-body-toolbar">

          <div class="panel panel-default">
             <div class="panel-body">
              <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/g1'); ?>">
                <div class="form-group">
                  <label class="sr-only" for="keywords">Kata kunci</label>
          	      <input type="text" class="form-control with_tooltip" id="keywords" name="keywords" placeholder="Masukan kata kunci yang diinginkan" title="Ketikan Kata Kunci Filtering dengan menentukan salah satu kolom" />
				</div>
                <div class="form-group">
                  <label class="sr-only" for="tahun_anggaran">Tahun Anggaran</label>
          	      <select class="form-control" id="tahun_anggaran" name="tahun_anggaran">
					<?php foreach ($year_list as $y) { echo '<option value="'.$y.'"'.( $y==$curr_year?' selected':'' ).'>'.$y.'</option>'; } ?>
				  </select>
				</div>
          	  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-filter"></i>Filter Kolom</button>
          	  <a href="<?php echo site_url('/reports/index/g1') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
          	</form>
            </div>
             <div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Report</div>
          </div>
          
		  <div class="row">
		    <div>
			  <?php echo $pagination ?>
		    </div>
		  </div>
		  
		</div>
		<!-- END start toolbar -->
		
		<div class="custom-scroll table-responsive" style="height:auto; overflow: scroll;">
        
		<?php ob_start(); ?>
        <table id="datatable_tabletools" class="table table-bordered table-striped table-condensed table-hover">
        <tr>
          <th>Tahun Anggaran</th>
          <th>Komponen Pembiayaan</th>
          <th>Sub Komponen Pembiayaan</th>
          <th>Sumber Pembiayaan</th>
          <th>Nama Kegiatan/Paket</th>
          <th>Nama Penerima</th>
          <th>Keterangan Transaksi</th>
          <th>Quartal Pembayaran (Q1,Q2,Q3,Q4)</th>
          <th>Nomor Voucher (SP2D)</th>
          <th>Tanggal Voucher</th>
          <th>Bulan Voucher</th>
          <th>Tahun Voucher</th>
          <th>Nilai Voucher (Rp)</th>
          <!--<th>Pengembalian Sisa (Rp)</th>
          <th>Realisasi</th>-->
          <th>Post/Prior Review</th>
        </tr>
        <?php
        // var_dump($records);
        foreach ($records as $rec) :
		  // get sp2d detail
		  $sp2ds = $this->Reports_model->get_sp2d_detail($rec->pid, $rec->proc_or_non_proc);
		  if (!$sp2ds) {
			$sp2ds[0] = new stdClass();
			$sp2ds[0]->sp2d_number = null;
			$sp2ds[0]->notes = '';
			$sp2ds[0]->sp2d_date = null;
			$sp2ds[0]->value = 0;
		  }
          foreach ($sp2ds as $sp2d) :
		?>
          <tr>
            <td><?php echo $rec->year ?></td>
            <td><?php echo $rec->parent_fpc ?></td>
            <td><?php echo $rec->name_of_fpc ?></td>
            <td class="centered"><?php echo $rec->source_of_fund ?></td>
            <td><?php echo $rec->package_id ?></td>
            <td><?php echo $rec->name_of_contractor ?></td>
            <td><?php echo $sp2d->notes ?></td>
            <td class="centered"><?php echo $sp2d->sp2d_date?'Q'.get_quarter(date('n', strtotime($sp2d->sp2d_date))):''  ?></td>
            <td><?php echo $sp2d->sp2d_number ?></td>
            <!--<td><?php echo $rec->sp2d_date ?></td>-->
	        <td class="centered"><?php echo $sp2d->sp2d_date?date('d', strtotime($sp2d->sp2d_date)):'' ?></td>
            <td class="centered"><?php echo $sp2d->sp2d_date?date('M', strtotime($sp2d->sp2d_date)):'' ?></td>
            <td class="centered"><?php echo $sp2d->sp2d_date?date('Y', strtotime($sp2d->sp2d_date)):'' ?></td>
            <td><?php echo $sp2d->value?number_format($sp2d->value, 0, '', '.'):0 ?></td>
            <!--<td>0 (Rp)</td>
            <td>Realisasi</td>-->
            <td><?php echo $rec->prior_or_post ?></td>
          </tr>
        <?php
		  endforeach;
        endforeach;
        ?>
        </table>
        <?php
		  $data_table = ob_get_clean();
		  if (!isset($print_view)) {
			echo $data_table;
		  }
		?>
		
		</div>
	</div>
	<!-- end widget content -->
</div>
<!-- end widget div -->
</div>
<!-- end widget main -->

<?php
$main_content = ob_get_clean();
if (isset($print_view)) {
  $main_content = null;
  $main_content = $header.$data_table;
  require './assets/smartadmin/index-print.tpl.php';
} else {
  require './assets/smartadmin/index-blank.tpl.php';  
}
