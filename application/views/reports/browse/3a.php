<?php
ob_start();
$year_list = array('2013', '2014', '2015', '2016', '2017');
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

function is_progress($prog_detail, $prog_to_compare) {
  foreach ($prog_detail as $dtl) {
	if ($dtl->prog_id == $prog_to_compare) {
	  return date('d-m-Y', strtotime($dtl->prog_date));
	}
  }
  return null;
}

$no = 1;
ob_start();
?>
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>3A: Procurement Monitoring for Goods</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>3A: Procurement Monitoring for Goods</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
    <div class="panel panel-default">
    <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/3a'); ?>">
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
	    <a href="<?php echo site_url('/reports/index/3a') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
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
          <th rowspan="2" class="column-mid color_cream">No.</th>
          <th rowspan="2" class="column-mid color_cream">Package</th>
          <th rowspan="2" class="column-mid color_cream">Quantity</th>
          <th rowspan="2" class="column-mid color_cream">Reference No.</th>
          <th rowspan="2" class="column-mid color_cream">Projects Item</th>
		  <th rowspan="2" class="column-mid color_cream">Estimated Cost (IDR)</th>
          <th rowspan="2" class="column-mid color_cream">Proc. Method</th>
          <th rowspan="2" class="column-mid color_cream">Prior/Post Review</th>
          <th rowspan="2" class="column-mid color_cream">&nbsp;</th>
          <th colspan="<?php echo $progress_num ?>" class="centered color_cream">Schedule</th>
          <th rowspan="2" class="color_cream">Remarks</th>
        </tr>
        <tr>
          <?php foreach ($progress_status as $prog_status) : ?>
		    <th class="color_cream"><?php echo $prog_status->status ?></th>
          <?php endforeach; ?>
        </tr>
        <?php
        foreach($records as $rec) :
		  // progress detail
		  $prog_detail = $this->Reports_model->getProgressData($rec->proc_id, 'Proc');
		  // var_dump($prog_detail); die();
          // var_dump($sp2d_dates); die();
        ?>
        <tr>
          <td rowspan="3"><?php echo $no ?></td>
          <td rowspan="3"><?php echo $rec->package_id ?></td>
          <td rowspan="3">&nbsp;</td><!-- data Quantity ini belum ada pada form isian -->
          <td rowspan="3"><?php echo $rec->contract_no ?></td>
          <td rowspan="3">&nbsp;</td><!-- data Project Item ini belum ada pada form isian -->
		  <td rowspan="3"><?php echo number_format($rec->estimated_cost, 0, '', '.') ?></td>
          <td rowspan="3"><?php echo $rec->procurement_method ?></td>
          <td rowspan="3"><?php echo $rec->prior_or_post ?></td>
          <td>Planned</td>
          <?php foreach ($progress_status as $prog_status) : ?>
		    <td>#</td><!-- progress plan -->
          <?php endforeach; ?>
		  <td rowspan="3">&nbsp;</td>
        </tr>
        <tr>
		  <td>Revised</td>
          <?php foreach ($progress_status as $prog_status) : ?>
		    <td>#</td><!-- progress revised -->
          <?php endforeach; ?>
        </tr>
        <tr>
		  <td>Actual</td>
          <?php foreach ($progress_status as $prog_status) : ?>
		    <td><?php echo is_progress($prog_detail, $prog_status->id); ?></td><!-- progress actual -->
          <?php endforeach; ?>
        </tr>
        <?php
		$no++;
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
