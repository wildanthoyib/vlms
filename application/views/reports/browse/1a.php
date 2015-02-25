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

ob_start();
?>
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1A: Project Sources and Uses of Funds</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>
<!-- filter -->

<!-- end of filter -->

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1A: Project Sources and Uses of Funds</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
    <div class="panel panel-default">
    <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/1A'); ?>">
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
	    <a href="<?php echo site_url('/reports/index/1A') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
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
  <th rowspan="4" class="color_cream"><strong><align="center">Cost Component</align></strong></th>
  <th colspan="3" class="color_cream">Actual</th>
  <th colspan="3" class="color_cream">Planned</th>
  <th colspan="3" class="color_cream">Variance in %</th>
</tr>
<tr>
  <th class="color_cream">Current Quarter <?php echo $curr_quarter ?></th>
  <th class="color_cream">Year-To Date</th>
  <th class="color_cream">Cummulative-to Date/i</th>
  <th class="color_cream">Current Quarter <?php echo $curr_quarter ?></th>
  <th class="color_cream">Year-To Date</th>
  <th class="color_cream">Cummulative-to Date/i</th>
  <th class="color_cream">Current Quarter <?php echo $curr_quarter ?></th>
  <th class="color_cream">Year-To Date</th>
  <th class="color_cream">Cummulative-to Date/iv</th>
</tr>
<tr>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
  <th class="color_cream">DIPA</th>
</tr>  
<tr class="color_cream">
<?php for ($c = 1; $c < 10; $c++) {echo '<th class="color_cream">'.$c.'</td>';}?>
</tr>
<tr>
  <td class="color_cream"><strong>Source of Funds</strong></td>
  <td colspan="9" class="color_cream">&nbsp;</td>
</tr>

<!-- cummulative for each source of fund -->
<?php
if ($rpp_detail) { // RPP checking

$disbursed_total = 0;
$disbursed2_total = 0;
$disbursed3_total = 0;
$planned_total = 0;
$planned2_total = 0;
$planned3_total = 0;
foreach ($sof_list as $sof) : ?>
<tr>
  <td><?php echo $sof->source_of_fund ?></td>
  <td class="align_right"><?php
      $proc_sum_disb = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $date_start);
      $non_proc_sum_disb = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $date_start);
	  $disbursed_total += $disbursed_sum = $proc_sum_disb+$non_proc_sum_disb;
	  echo number_format($disbursed_sum, 0, '', '.');
	?></td>
  <td class="align_right"><?php
      $proc_sum_disb2 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $curr_date, $curr_year_date_start);
      $non_proc_sum_disb2 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $curr_date, $curr_year_date_start);
	  $disbursed2_total += $disbursed_sum2 = $proc_sum_disb2+$non_proc_sum_disb2;
	  echo number_format($disbursed_sum2, 0, '', '.');
	?></td>
  <td class="align_right"><?php
      $proc_sum_disb3 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $curr_date, $cummulative_date_start);
      $non_proc_sum_disb3 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, null, $sof->id, $curr_date, $cummulative_date_start);
	  $disbursed3_total += $disbursed_sum3 = $proc_sum_disb3+$non_proc_sum_disb3;
	  echo number_format($disbursed_sum3, 0, '', '.');
	?></td>
  <td class="align_right"><?php
	  $proc_sum_plan = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $date_start);
	  $non_proc_sum_plan = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $date_start);
	  $planned_total += $planned_sum = $proc_sum_plan+$non_proc_sum_plan;
	  echo number_format($planned_sum, 0, '', '.');
	?></td>
  <td class="align_right"><?php
	  $proc_sum_plan2 = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $curr_year_date_start);
	  $non_proc_sum_plan2 = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $curr_year_date_start);
	  $planned2_total += $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	  echo number_format($planned_sum2, 0, '', '.');
	?></td>
  <td class="align_right"><?php
	  $proc_sum_plan3 = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $cummulative_date_start);
	  $non_proc_sum_plan3 = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, null, $sof->id, $date_end, $cummulative_date_start);
	  $planned3_total += $planned_sum3 = $proc_sum_plan3+$non_proc_sum_plan3;
	  echo number_format($planned_sum3, 0, '', '.');
	?></td>
  <td class="align_right"><?php if ($disbursed_sum > 0 && $planned_sum > 0) { echo round(($disbursed_sum/$planned_sum)*100, 2).'%'; } ?></td>
  <td class="align_right"><?php if ($disbursed_sum2 > 0 && $planned_sum2 > 0) { echo round(($disbursed_sum2/$planned_sum2)*100, 2).'%'; } ?></td>
  <td class="align_right"><?php if ($disbursed_sum3 > 0 && $planned_sum3 > 0) { echo round(($disbursed_sum3/$planned_sum3)*100, 2).'%'; } ?></td>
</tr>
<?php endforeach; ?>
<!-- END cummulative for each source of fund -->

<tr>
  <td><strong>Total Sources of Fund</strong></td>
  <td class="align_right"><?php echo number_format($disbursed_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($disbursed2_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($disbursed3_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($planned_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($planned2_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($planned3_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php if ($disbursed_total > 0 && $planned_total > 0) { echo round(($disbursed_total/$planned_total)*100, 2).'%'; } ?></td>
  <td class="align_right"><?php if ($disbursed2_total > 0 && $planned2_total > 0) { echo round(($disbursed2_total/$planned2_total)*100, 2).'%'; } ?></td>
  <td class="align_right"><?php if ($disbursed3_total > 0 && $planned3_total > 0) { echo round(($disbursed3_total/$planned3_total)*100, 2).'%'; } ?></td>
</tr>
<tr>
  <td><strong>Uses of Fund</strong></td>
  <td colspan="9">&nbsp;</td>
</tr>
<?php
// loop data cost component
$disbursed_total = 0;
$disbursed2_total = 0;
$disbursed3_total = 0;
$planned_total = 0;
$planned2_total = 0;
$planned3_total = 0;
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
            $proc_sum_disb = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $date_start);
            $non_proc_sum_disb = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $date_start);
	        $disbursed_sum = $proc_sum_disb+$non_proc_sum_disb;
	        echo number_format($disbursed_sum, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
            $proc_sum_disb2 = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $curr_date, $curr_year_date_start);
            $non_proc_sum_disb2 = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $curr_date, $curr_year_date_start);
	        $disbursed_sum2 = $proc_sum_disb2+$non_proc_sum_disb2;
	        echo number_format($disbursed_sum2, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
            $proc_sum_disb3 = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $curr_date, $cummulative_date_start);
            $non_proc_sum_disb3 = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $curr_date, $cummulative_date_start);
	        $disbursed_sum3 = $proc_sum_disb3+$non_proc_sum_disb3;
	        echo number_format($disbursed_sum3, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $date_start);
	        $non_proc_sum_plan = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $date_start);
	        $planned_sum = $proc_sum_plan+$non_proc_sum_plan;
	        echo number_format($planned_sum, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan2 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $curr_year_date_start);
	        $non_proc_sum_plan2 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $curr_year_date_start);
	        $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	        echo number_format($planned_sum2, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan3 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $cummulative_date_start);
	        $non_proc_sum_plan3 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $cummulative_date_start);
	        $planned_sum3 = $proc_sum_plan3+$non_proc_sum_plan3;
	        echo number_format($planned_sum3, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php if ($disbursed_sum > 0 && $planned_sum > 0) { echo round(($disbursed_sum/$planned_sum)*100, 2).'%'; } ?></td>
        <td class="color_cream align_right"><?php if ($disbursed_sum2 > 0 && $planned_sum2 > 0) { echo round(($disbursed_sum2/$planned_sum2)*100, 2).'%'; } ?></td>
        <td class="color_cream align_right"><?php if ($disbursed_sum3 > 0 && $planned_sum3 > 0) { echo round(($disbursed_sum3/$planned_sum3)*100, 2).'%'; } ?></td>
		<?php
        echo '</tr>';
	
	    // level 2
        if ($data['childs']) {
           foreach ($data['childs'] as $id2 => $data2) {
            echo '<tr>';
            echo '<td style="padding-left: 20px;">'.$data2['data']->code.' '.$data2['data']->name_of_fpc.'</td>';
            ?>
            <td class="align_right"><?php
                $proc_sum_disb = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $date_start);
                $non_proc_sum_disb = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $date_start);
	            $disbursed_total += $disbursed_sum = $proc_sum_disb+$non_proc_sum_disb;
	            echo number_format($disbursed_sum, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
                $proc_sum_disb2 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $curr_date, $curr_year_date_start);
                $non_proc_sum_disb2 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $curr_date, $curr_year_date_start);
	            $disbursed2_total += $disbursed_sum2 = $proc_sum_disb2+$non_proc_sum_disb2;
	            echo number_format($disbursed_sum2, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
                $proc_sum_disb3 = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $curr_date, $cummulative_date_start);
                $non_proc_sum_disb3 = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $curr_date, $cummulative_date_start);
	            $disbursed3_total += $disbursed_sum3 = $proc_sum_disb3+$non_proc_sum_disb3;
	            echo number_format($disbursed_sum3, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
	            $proc_sum_plan = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $date_start);
	            $non_proc_sum_plan = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $date_start);
	            $planned_total += $planned_sum = $proc_sum_plan+$non_proc_sum_plan;
	            echo number_format($planned_sum, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
	            $proc_sum_plan2 = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $curr_year_date_start);
	            $non_proc_sum_plan2 = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $curr_year_date_start);
	            $planned2_total += $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	            echo number_format($planned_sum2, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
	            $proc_sum_plan3 = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $cummulative_date_start);
	            $non_proc_sum_plan3 = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $cummulative_date_start);
	            $planned3_total += $planned_sum3 = $proc_sum_plan3+$non_proc_sum_plan3;
	            echo number_format($planned_sum3, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php if ($disbursed_sum > 0 && $planned_sum > 0) { echo round(($disbursed_sum/$planned_sum)*100, 2).'%'; } ?></td>
            <td class="align_right"><?php if ($disbursed_sum2 > 0 && $planned_sum2 > 0) { echo round(($disbursed_sum2/$planned_sum2)*100, 2).'%'; } ?></td>
            <td class="align_right"><?php if ($disbursed_sum3 > 0 && $planned_sum3 > 0) { echo round(($disbursed_sum3/$planned_sum3)*100, 2).'%'; } ?></td>
			<?php
            echo '</tr>';
      	 }
        }
		$n++;
      } 
}
?>
<tr>
  <td><strong>Total Sources of Fund</strong></td>
  <td class="align_right"><?php echo number_format($disbursed_total, 0, '', '.') ?></td>
  <td class="align_right"><?php echo number_format($disbursed2_total, 0, '', '.') ?></td>
  <td class="align_right"><?php echo number_format($disbursed3_total, 0, '', '.') ?></td>
  <td class="align_right"><?php echo number_format($planned_total, 0, '', '.') ?></td>
  <td class="align_right"><?php echo number_format($planned2_total, 0, '', '.') ?></td>
  <td class="align_right"><?php echo number_format($planned3_total, 0, '', '.') ?></td>
  <td class="align_right"><?php if ($disbursed_total > 0 && $planned_total > 0) { echo round(($disbursed_total/$planned_total)*100, 2).'%'; } ?></td>
  <td class="align_right"><?php if ($disbursed2_total > 0 && $planned2_total > 0) { echo round(($disbursed2_total/$planned2_total)*100, 2).'%'; } ?></td>
  <td class="align_right"><?php if ($disbursed3_total > 0 && $planned3_total > 0) { echo round(($disbursed3_total/$planned3_total)*100, 2).'%'; } ?></td>
</tr>
</table>

         <?php
} // END RPP checking
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
