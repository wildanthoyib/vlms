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

$sof = array();
// cache source of funds
foreach ($sof_list as $each_sof) {
  $sof[$each_sof->source_of_fund] = $each_sof->id;
}

$year_oldest = date('Y')-1;
$year_latest = date('Y')+4;
$proc_non_proc = array('Proc' => 'Procurement', 'Non-Proc' => 'Non-Procurement');
$curr_date = date('Y-m-d');
$curr_year_date_start = $curr_year.'-01-01';
$cummulative_date_start = '2013-01-01';
$year_start = $curr_year.'-01-01';
$year_end = $curr_year.'-12-31';

ob_start();
?>
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1E: Grant Disbursement & Expenditures Status
<br />For the Quarter Periode <?php echo $quarter_month_end_text.' '.$curr_year; ?></div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>
<!-- filter -->

<!-- end of filter -->

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1E: Grant Disbursement & Expenditures Status</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
    <div class="panel panel-default">
    <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/1E'); ?>">
      <div class="form-group">
        <label class="sr-only" for="keywords">Quarter</label>
        <select class="form-control" id="quarter" name="quarter">
	      <?php for ($q = 1; $q <= 4; $q++) { echo '<option value="'.$q.'"'.( $curr_quarter==$q?' selected':'' ).'>Quarter '.$q.'</option>'; } ?>
	    </select>
      </div>
      <div class="form-group">
        <label class="sr-only" for="tahun_anggaran">Tahun Anggaran</label>
        <select class="form-control" id="tahun_anggaran" name="tahun_anggaran">
	      <?php foreach ($year_list as $y) { echo '<option value="'.$y.'"'.( $y==$curr_year?' selected':'' ).'>'.$y.'</option>'; } ?>
	    </select>
      </div>
	  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-filter"></i>Filter Kolom</button>
	    <a href="<?php echo site_url('/reports/index/1E') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
    </form>
    </div>
     <!-- <div class="alert alert-info">Ditemukan <?php echo $total_rows ?> baris data Report</div> -->
    </div>

    <div class="row">
	  <div class="pull-left">
	    <?php echo $pagination; ?>
	  </div>
	</div>		  

	<!--<div class="form-table table-overflow" style="width:auto; overflow-x: scroll;">-->	
	<div class="custom-scroll table-responsive" style="height:auto; overflow: scroll;">
        
<?php ob_start(); ?>
<table class="table table-bordered table-striped table-condensed">
<tr>
  <th rowspan="2" class="color_cream"><strong>Cost Component</strong></th>
  <th rowspan="2" class="color_cream">Grant Allocation</th>
  <th rowspan="2" class="color_cream">Disbursement</th>
  <th rowspan="2" class="color_cream">Undisbursed</th>
  <th colspan="3" class="color_cream centered">Expenditures</th>
  <th class="color_cream">Commitment</th>
  <th class="color_cream">Remaining</th>
</tr>
<tr>
  <th class="color_cream">Current Quarter</th>
  <th class="color_cream">Cummulative-to Date</th>
  <th class="color_cream">Discrepancy (Cumm to Date)</th>
  <th class="color_cream">Not Yet Paid</th>
  <th class="color_cream">Loan Allocation</th>
</tr>
<tr><td colspan="9">&nbsp;</td></tr>

<!-- Cummulative for each cost component -->
<?php
if ($rpp_detail) { // RPP checking
  
// loop data cost component
$grant_alloc_total = 0;
$disbursed_total = 0;
$undisbursed_total = 0;
$curr_quarter_total = 0;
$cummulative_total = 0;

foreach ($user_data['schema'] as $schema) {
      $fpc = $this->Master_model->getRecursiveFPC(null, $schema['id'], null, null, 'PIU');
	  if (!$fpc) {
		break;
	  }
	  $n = 1;
      foreach ($fpc as $id => $data) {
		if (!$data['childs']) {
		  continue;
		}
        echo '<tr>';
        echo '<th class="color_cream">'.$n.'. '.$data['data']->name_of_fpc.'</th>';
		?>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan2 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $year_end, $year_start);
	        $non_proc_sum_plan2 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $year_end, $year_start);
	        $grant_alloc_total += $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	        echo number_format($planned_sum2, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
            $proc_sum_disb2 = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $year_end, $year_start);
            $non_proc_sum_disb2 = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $year_end, $year_start);
	        $disbursed_total += $disbursed_sum2 = $proc_sum_disb2+$non_proc_sum_disb2;
	        echo number_format($disbursed_sum2, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
		  $undisbursed_total += $undisbursed_sum = $planned_sum2-$disbursed_sum2;
		  echo number_format($undisbursed_sum, 0, '', '.'); ?></td>
        <td class="color_cream align_right"><?php
            $proc_sum_disb3 = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $date_start);
            $non_proc_sum_disb3 = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $date_start);
	        $curr_quarter_total += $disbursed_sum3 = $proc_sum_disb3+$non_proc_sum_disb3;
	        echo number_format($disbursed_sum3, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
            $proc_sum_disb4 = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $curr_date, $cummulative_date_start);
            $non_proc_sum_disb4 = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $curr_date, $cummulative_date_start);
	        $cummulative_total += $disbursed_sum4 = $proc_sum_disb4+$non_proc_sum_disb4;
	        echo number_format($disbursed_sum4, 0, '', '.');
	      ?></td>
        <td class="color_cream">#</td>
        <td class="color_cream">#</td>
        <td class="color_cream">#</td>
		<?php
        echo '</tr>';
	
	    // level 2
        if ($data['childs']) {
           foreach ($data['childs'] as $id2 => $data2) {
            echo '<tr>';
            echo '<td style="padding-left: 20px;">'.$data2['data']->code.' '.$data2['data']->name_of_fpc.'</td>';
            ?>
            <td class="align_right"><?php
	            $proc_sum_plan2 = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $year_end, $year_start);
	            $non_proc_sum_plan2 = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $year_end, $year_start);
	            $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	            echo number_format($planned_sum2, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
                $proc_sum_disb2 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $year_end, $year_start);
                $non_proc_sum_disb2 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $year_end, $year_start);
	            $disbursed_sum2 = $proc_sum_disb2+$non_proc_sum_disb2;
	            echo number_format($disbursed_sum2, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php echo number_format($planned_sum2-$disbursed_sum2, 0, '', '.'); ?></td>
            <td class="align_right"><?php
                $proc_sum_disb3 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $date_start);
                $non_proc_sum_disb3 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $date_start);
	            $disbursed_sum3 = $proc_sum_disb3+$non_proc_sum_disb3;
	            echo number_format($disbursed_sum3, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
                $proc_sum_disb4 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $curr_date, $cummulative_date_start);
                $non_proc_sum_disb4 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $curr_date, $cummulative_date_start);
	            $disbursed_sum4 = $proc_sum_disb4+$non_proc_sum_disb4;
	            echo number_format($disbursed_sum3, 0, '', '.');
	          ?></td>
            <td>#</td>
            <td>#</td>
            <td>#</td>
			<?php
            echo '</tr>';
      	 }
        }
		$n++;
      } 
}
?>
<!-- END cummulative for each cost component -->

<tr><td colspan="9">&nbsp;</td></tr>
<!-- cummulative for each source of fund -->
<?php
$disbursed_total = 0;
$disbursed2_total = 0;
$disbursed3_total = 0;
$planned_total = 0;
$planned2_total = 0;
$planned3_total = 0;
foreach ($sof_list as $sof) : ?>
<tr>
  <td style="padding-left: 20px" class="align_right"><?php echo $sof->source_of_fund ?></td>
  <td><?php
	  $proc_sum_plan2 = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $year_end, $year_start);
	  $non_proc_sum_plan2 = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $year_end, $year_start);
	  $planned2_total += $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	  echo number_format($planned_sum2, 0, '', '.');
	  ?></td>
  <td class="align_right"><?php
      $proc_sum_disb2 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $year_end, $year_start);
      $non_proc_sum_disb2 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $year_end, $year_start);
	  $disbursed_sum2 = $proc_sum_disb2+$non_proc_sum_disb2;
	  echo number_format($disbursed_sum2, 0, '', '.');
	  ?></td>
  <td class="align_right"><?php echo number_format($planned_sum2-$disbursed_sum2, 0, '', '.'); ?></td>
  <td class="align_right"><?php
      $proc_sum_disb3 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $date_start);
      $non_proc_sum_disb3 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $date_start);
	  $disbursed_sum3 = $proc_sum_disb3+$non_proc_sum_disb3;
	  echo number_format($disbursed_sum3, 0, '', '.');
	  ?></td>
  <td class="align_right"><?php
      $proc_sum_disb4 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $curr_date, $cummulative_date_start);
      $non_proc_sum_disb4 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $curr_date, $cummulative_date_start);
	  $disbursed_sum4 = $proc_sum_disb4+$non_proc_sum_disb4;
	  echo number_format($disbursed_sum3, 0, '', '.');
	  ?></td>
  <td>#</td>
  <td>#</td>
  <td>#</td>
</tr>
<?php endforeach; ?>

<tr>
  <td style="padding-left: 20px">Grand Total</td>
  <td><?php echo number_format($grant_alloc_total, 0, '', '.'); ?></td>
  <td><?php echo number_format($disbursed_total, 0, '', '.'); ?></td>
  <td><?php echo number_format($undisbursed_total, 0, '', '.'); ?></td>
  <td><?php echo number_format($curr_quarter_total, 0, '', '.'); ?></td>
  <td><?php echo number_format($cummulative_total, 0, '', '.'); ?></td>
  <td>#</td>
  <td>#</td>
  <td>#</td>
</tr>
<!-- END cummulative for each source of fund -->

</table>

         <?php
} // END RPP Checking
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
