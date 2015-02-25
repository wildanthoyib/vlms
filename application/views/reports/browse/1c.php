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
$year_start = $curr_year.'-01-01';
$year_end = $curr_year.'-12-31';

$first_quarter_start = $curr_year.'-01-01';
$first_quarter_end = $curr_year.'-03-31';

$second_quarter_start = $curr_year.'-04-01';
$second_quarter_end = $curr_year.'-06-30';

$third_quarter_start = $curr_year.'-07-01';
$third_quarter_end = $curr_year.'-09-30';

$fourth_quarter_start = $curr_year.'-10-01';
$fourth_quarter_end = $curr_year.'-12-31';

ob_start();
?>
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1C: Project Cash Forecast (in IDR)
<br />For the Quarter Ending <?php echo 'December '.$curr_year; ?></div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>
<!-- filter -->

<!-- end of filter -->

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1C: Project Cash Forecast (in IDR)</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
    <div class="panel panel-default">
    <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/1C'); ?>">
      <div class="form-group">
        <label class="sr-only" for="tahun_anggaran">Tahun Anggaran</label>
        <select class="form-control" id="tahun_anggaran" name="tahun_anggaran">
	      <?php foreach ($year_list as $y) { echo '<option value="'.$y.'"'.( $y==$curr_year?' selected':'' ).'>'.$y.'</option>'; } ?>
	    </select>
      </div>
	  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-filter"></i>Filter Kolom</button>
	    <a href="<?php echo site_url('/reports/index/1C') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
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
  <th rowspan="3" class="color_cream"><strong>Cost Component</strong></th>
  <th class="color_cream">Cash Requirement for quarter ending 31 March <?php echo $curr_year; ?></th>
  <th class="color_cream">Cash Requirement for quarter ending 30 June <?php echo $curr_year; ?></th>
  <th class="color_cream">Cash Requirement for quarter ending 30 September <?php echo $curr_year; ?></th>
  <th class="color_cream">Cash Requirement for quarter ending 31 December <?php echo $curr_year; ?></th>
  <th class="color_cream">Total Cash Requirement for One Year Ending 31 December <?php echo $curr_year; ?></th>
  <?php foreach ($sof_list as $sof) : ?>
  <th class="color_cream"><div><?php echo $sof->source_of_fund ?></div>Total Cash Requirement for One Year Ending 31 December <?php echo $curr_year; ?></th>
  <?php endforeach; ?>
</tr>
<tr>
  <?php for ($c = 1; $c < 6; $c++) { ?><th class="color_cream">DIPA</th><?php } ?>
  <?php for ($c = 1; $c <= count($sof_list); $c++) { ?><th class="color_cream">DIPA</th><?php } ?>
</tr>
<tr>
  <?php for ($c = 1; $c < 6; $c++) { ?><th class="color_cream"><?php echo $c ?></th><?php } ?>
  <?php for ($c = 7; $c <= 6+count($sof_list); $c++) { ?><th class="color_cream"><?php echo $c ?></th><?php } ?>
</tr>
<tr><td colspan="9">&nbsp;</td></tr>

<!-- Cummulative for each cost component -->
<?php

if ($rpp_detail) { // RPP checking
  
// loop data cost component
$plan_total = 0;
$plan2_total = 0;
$plan3_total = 0;
$plan4_total = 0;
$plan5_total = 0;
foreach ($sof_list as $sof) {
  $plan_sof_total[$sof->id] = 0;
}
  
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
		$planned_sum = 0;
		$planned_sum2 = 0;
		$planned_sum3 = 0;
		$planned_sum4 = 0;
        echo '<tr>';
        echo '<th class="color_cream">'.$n.'. '.$data['data']->name_of_fpc.'</th>';
		?>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $first_quarter_end, $first_quarter_start);
	        $non_proc_sum_plan = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $first_quarter_end, $first_quarter_start);
	        $plan_total += $planned_sum = $proc_sum_plan+$non_proc_sum_plan;
	        echo number_format($planned_sum, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan2 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $second_quarter_end, $second_quarter_start);
	        $non_proc_sum_plan2 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $second_quarter_end, $second_quarter_start);
	        $plan2_total += $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	        echo number_format($planned_sum2, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan3 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $third_quarter_end, $third_quarter_start);
	        $non_proc_sum_plan3 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $third_quarter_end, $third_quarter_start);
	        $plan3_total += $planned_sum3 = $proc_sum_plan3+$non_proc_sum_plan3;
	        echo number_format($planned_sum3, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
	        $proc_sum_plan4 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $fourth_quarter_end, $fourth_quarter_start);
	        $non_proc_sum_plan4 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $fourth_quarter_end, $fourth_quarter_start);
	        $plan4_total += $planned_sum4 = $proc_sum_plan4+$non_proc_sum_plan4;
	        echo number_format($planned_sum4, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
		  echo number_format($planned_sum+$planned_sum2+$planned_sum3+$planned_sum4, 0, '', '.');
		  // echo $planned_sum.' - '.$planned_sum2.' - '.$planned_sum3.' - '.$planned_sum4;
		  ?></td>
        <?php foreach ($sof_list as $sof) : ?>
          <td class="color_cream align_right"><?php
	          $proc_sum_plan5 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, $sof->id, $year_end, $year_start);
	          $non_proc_sum_plan5 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, $sof->id, $year_end, $year_start);
	          $plan_sof_total[$sof->id] += $planned_sum5 = $proc_sum_plan5+$non_proc_sum_plan5;
	          echo number_format($planned_sum5, 0, '', '.');
	        ?></td>
        <?php endforeach; ?>
		<?php
        echo '</tr>';
	
	    // level 2
        if ($data['childs']) {
           foreach ($data['childs'] as $id2 => $data2) {
            echo '<tr>';
            echo '<td style="padding-left: 20px;">'.$data2['data']->code.' '.$data2['data']->name_of_fpc.'</td>';
            ?>
            <td class="align_right"><?php
	            $proc_sum_plan = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $first_quarter_end, $first_quarter_start);
	            $non_proc_sum_plan = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $first_quarter_end, $first_quarter_start);
	            $planned_sum = $proc_sum_plan+$non_proc_sum_plan;
	            echo number_format($planned_sum, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
	            $proc_sum_plan2 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $second_quarter_end, $second_quarter_start);
	            $non_proc_sum_plan2 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $second_quarter_end, $second_quarter_start);
	            $planned_sum2 = $proc_sum_plan2+$non_proc_sum_plan2;
	            echo number_format($planned_sum2, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
	            $proc_sum_plan3 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $third_quarter_end, $third_quarter_start);
	            $non_proc_sum_plan3 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $third_quarter_end, $third_quarter_start);
	            $planned_sum3 = $proc_sum_plan3+$non_proc_sum_plan3;
	            echo number_format($planned_sum3, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
	            $proc_sum_plan4 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $fourth_quarter_end, $fourth_quarter_start);
	            $non_proc_sum_plan4 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $fourth_quarter_end, $fourth_quarter_start);
	            $planned_sum4 = $proc_sum_plan4+$non_proc_sum_plan4;
	            echo number_format($planned_sum4, 0, '', '.');
	          ?></td>
            <td><?php echo number_format($planned_sum+$planned_sum2+$planned_sum3+$planned_sum4, 0, '', '.'); ?></td>
            <?php foreach ($sof_list as $sof) : ?>
              <td class="align_right"><?php
	              $proc_sum_plan5 = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, $sof->id, $year_end, $year_start);
	              $non_proc_sum_plan5 = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, $sof->id, $year_end, $year_start);
	              $planned_sum5 = $proc_sum_plan5+$non_proc_sum_plan5;
	              echo number_format($planned_sum5, 0, '', '.');
	            ?></td>
            <?php endforeach; ?>
			<?php
            echo '</tr>';
      	 }
        }
		$n++;
      } 
}
?>
<!-- END cummulative for each cost component -->

<tr>
  <td style="padding-left: 20px">TOTAL</td>
  <td class="align_right"><?php echo number_format($plan_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($plan2_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($plan3_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($plan4_total, 0, '', '.'); ?></td>
  <td class="align_right"><?php echo number_format($plan5_total, 0, '', '.'); ?></td>
  <?php foreach ($sof_list as $sof) : ?>
    <td class="align_right"><?php echo number_format($plan_sof_total[$sof->id], 0, '', '.'); ?></td>
  <?php endforeach; ?>
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
