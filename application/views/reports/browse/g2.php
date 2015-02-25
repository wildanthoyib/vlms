<?php
ob_start();
$year_list = array('2013', '2014', '2015', '2016', '2017');
function check_spd2d_date($month_to_check, $dates) {
  $result = '-';
  foreach($dates as $d) {
    // var_dump($d); die();
    $m = date('n', strtotime($d->sp2d_date));
    if($m == $month_to_check) {
      return number_format($d->total_sp2d, 0, '', '.');
    }
  }
  return $result;
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
<h3 class="page-title txt-color-blueDark"><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1G: Summary Statement Expenditures</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1 G2: Monitoring Activity Report</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
		<div class="widget-body-toolbar">
<div class="panel panel-default">
   <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/g2'); ?>">
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
	  <a href="<?php echo site_url('/reports/index/g2') ?>?<?php echo build_query() ?>" class="btn btn btn-success"><i class="fa fa-print"></i> Cetak Report</a> 
	</form>
  </div>
   <div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Report</div>
</div>

    <div class="row">
	  <div>
			<?php echo $pagination; ?>
	  </div>
	</div>		  

	<!--<div class="form-table table-overflow" style="width:auto; overflow-x: scroll;">-->	
	<div class="custom-scroll table-responsive" style="height:auto; overflow: scroll;">
        
        <?php ob_start(); ?>
        <table id="datatable_tabletools" class="table table-bordered table-striped table-condensed table-hover">
        <tr>
          <th rowspan="2" class="column-mid color_cream">Tahun<br> Anggaran</th>
          <th rowspan="2" class="column-mid color_cream">Komponen Pembiayaan</th>
          <th rowspan="2" class="column-mid color_cream">Sub Komponen Pembiayaan</th>
          <th rowspan="2" class="column-mid color_cream">Sumber Pembiayaan</th>
          <th rowspan="2" class="column-mid color_cream">Nama Kegiatan/Paket</th>
          <th rowspan="2" class="column-mid color_cream">Nama Penerima</th>
          <th rowspan="2" class="column-mid color_cream">Rencana(RP)</th> 
          <th rowspan="2" class="column-mid color_cream">Nol Disetujui</th>
          
          <th colspan="3" class="column-centered color_cream">Pembayaran Q1</th>
          <th colspan="3" class="column-centered color_cream">Pembayaran Q2</th>
          <th colspan="3" class="column-centered color_cream">Pembayaran Q3</th>
          <th colspan="3" class="column-centered color_cream">Pembayaran Q4</th>
        
          <th rowspan="2" class="color_cream">Pengembalian Sisa</th>
          <!-- <th rowspan="2">Surat Pengajuan Nol</th> -->
          <!-- <th rowspan="2">Surat Persetujuan Nol</th> -->
          <th rowspan="2" class="color_cream">Tahun Voucher</th>
          <th rowspan="2" class="color_cream">Nomor dan Tanggal Kontrak</th>
          <!-- <th rowspan="2">Keterangan Pengadaan<br />(Prior/Post)</th> -->
        </tr>
        <tr>
          <td class="column-centered">Januari</td>
          <td class="column-centered">Februari</td>
          <td class="column-centered">Maret</td>
          <td class="column-centered">April</td>
          <td class="column-centered">Mei</td>
          <td class="column-centered">Juni</td>    
          <td class="column-centered">Juli</td>
          <td class="column-centered">Agustus</td>
          <td class="column-centered">September</td>
          <td class="column-centered">Oktober</td>
          <td class="column-centered">Nopember</td>
          <td class="column-centered">Desember</td>
        </tr>
        <?php
        foreach($records as $rec) :
        $sp2d_dates = $this->Reports_model->get_sp2d_date($rec->pid, $rec->proc_or_non_proc);
        // var_dump($sp2d_dates); die();
        ?>
        <tr>
          <td><?php echo $rec->year ?></td>
          <td><?php echo $rec->parent_fpc ?></td>
          <td><?php echo $rec->name_of_fpc ?></td>
          <td><?php echo $rec->source_of_fund ?></td>
          <td><?php echo $rec->package_id ?></td>
          <td><?php echo $rec->contractor ?></td>
          <td class="align_right"><?php echo number_format($rec->plan_value, 0, '', '.') ?></td>
          <td class="align_right"><?php echo number_format($rec->contract_value, 0, '', '.') ?></td>
          <td class="align_right"><?php echo check_spd2d_date(1, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(2, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(3, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(4, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(5, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(6, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(7, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(8, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(9, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(10, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(11, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(12, $sp2d_dates); ?></td>
          <td class="align_right"><?php echo check_spd2d_date(13, $sp2d_dates); ?></td>
          <!-- <td>-</td> -->
          <!-- <td>-</td> -->
          <td><?php echo $rec->sp2d_date ?></td>
          <td><!-- salah nmr kontraknya<?php echo $rec->contract_no ?>--></td>
          <!-- <td><?php /* echo $rec->prior_or_post */ ?></td> -->
        </tr>
        <?php
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
</table>
<!--</div>-->

<?php
$main_content = ob_get_clean();
if (isset($print_view)) {
  $main_content = null;
  $main_content = $header.$data_table;
  require './assets/smartadmin/index-print.tpl.php';
} else {
  require './assets/smartadmin/index-blank.tpl.php';  
}
