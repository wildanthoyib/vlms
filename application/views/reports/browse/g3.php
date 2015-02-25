<?php
ob_start();
$year_list = array('2013', '2014', '2015', '2016', '2017');
function check_withdrawal_plan_date($month_to_check, $dates) {
  $result = 0;
  foreach($dates as $d) {
    // var_dump($d); die();
    $m = (integer)$d['q_date'];
    if($m == $month_to_check) {
      return $d['q_value'];
      // return number_format($d['q_value'], 0, '', '.');
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
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1G: Summary Statement Expenditures</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>
<!-- filter -->

<!-- end of filter -->

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1 G3: Monitoring Activity Report</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
    <div class="panel panel-default">
    <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/g3'); ?>">
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
	    <a href="<?php echo site_url('/reports/index/g3') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
    </form>
    </div>
     <div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Report</div>
    </div>

    <div class="row">
	  <div class="pull-left">
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
          <th rowspan="2" class="column-mid color_cream">Fokus Utama <br />Kegiatan(A,B,C atau D)</th>
          <th rowspan="2" class="column-mid color_cream">Nama Penerima</th> 
          <th rowspan="2" class="column-mid color_cream">Rencana(Rp)</th>
          
          <th colspan="3" class="column-centered color_cream">Rencana Penarikan Q1</th>
          <th colspan="3" class="column-centered color_cream">Rencana Penarikan Q2</th>
          <th colspan="3" class="column-centered color_cream">Rencana Penarikan Q3</th>
          <th colspan="3" class="column-centered color_cream">Rencana Penarikan Q4</th>
        
          <!--
          <th rowspan="2">Tahun Voucher</th>
          <th rowspan="2">Nomor dan Tanggal Kontrak</th>
          -->
          <th rowspan="2" class="color_cream">Keterangan</th>
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
		$total_plan = 0;
		for ($mp = 1; $mp <= 12; $mp++) {
		  $total_plan_month[$mp] = 0;
		}
        foreach($records as $rec) :
          $withdrawal_plan_dates[1] = array('q_date' => $rec->plan_q1, 'q_value' => $rec->plan_q1_value);
          $withdrawal_plan_dates[2] = array('q_date' => $rec->plan_q2, 'q_value' => $rec->plan_q2_value);
          $withdrawal_plan_dates[3] = array('q_date' => $rec->plan_q3, 'q_value' => $rec->plan_q3_value);
          $withdrawal_plan_dates[4] = array('q_date' => $rec->plan_q4, 'q_value' => $rec->plan_q4_value);
          // var_dump($withdrawal_plan_dates);
        ?>
        <tr>
          <td><?php echo $rec->year ?></td>
          <td><?php echo $rec->parent_fpc ?></td>
          <td><?php echo $rec->name_of_fpc ?></td>
          <td><?php echo $rec->source_of_fund ?></td>
          <td><?php echo $rec->package_id ?></td>
          <td>-</td>
          <td>-</td>
          <td><?php
		    $total_plan += $rec->estimated_cost;
		    echo number_format($rec->estimated_cost, 0, '', '.'); ?></td>
          <!--
          <td>Rp. 0,</td>
          <td>--</td>
          -->
		  <?php for ($mp = 1; $mp <= 12; $mp++) : ?>
          <td class="align_right"><?php
		    $plan_value = check_withdrawal_plan_date($mp, $withdrawal_plan_dates);
			$total_plan_month[$mp] +=  $plan_value;
			echo number_format($plan_value, 0, '', '.'); ?></td>
		  <?php endfor; ?>
          <!--
          <td><?php echo $rec->sp2d_date ?></td>
          <td><?php echo $rec->contract_no ?></td>
          -->
          <td>-</td>
        </tr>
        <?php
        endforeach;
        ?>
		<!-- total -->
        <tr>
          <td class="centered" colspan="7">TOTAL</td>
          <td><?php echo number_format($total_plan, 0, '', '.') ?></td>
          <!--
          <td>Rp. 0,</td>
          <td>--</td>
          -->
		  <?php for ($mp = 1; $mp <= 12; $mp++) : ?>
          <td class="align_right"><?php
			echo number_format($total_plan_month[$mp], 0, '', '.'); ?></td>
		  <?php endfor; ?>
          <!--
          <td>--</td>
          <td>--</td>
          -->
          <td>-</td>
        </tr>		
		<!- end total -->
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
