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

$year_oldest = date('Y')-1;
$year_latest = date('Y')+4;
$year_start = $curr_year.'-01-01';
$year_end = $curr_year.'-12-31';
$cummulative_date_start = '2013-01-01';

ob_start();
?>
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Output Monitoring Report</div>2B: Unit of Output by project Activity<br />
    For the Quarter Ending <?php echo $quarter_month_end_text.' '.$curr_year; ?></h3>
<?php
$header = ob_get_clean();
echo $header;
?>
<!-- filter -->

<!-- end of filter -->

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>2B: Output Monitoring Report</i></h2> 				
	<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
</header>

<!-- widget div-->
<div role="content">
	
	<!-- widget content -->
	<div class="widget-body no-padding">
	<div class="widget-body-toolbar">
    <div class="panel panel-default">
    <div class="panel-body">
    <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/2B'); ?>">
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
	    <a href="<?php echo site_url('/reports/index/2B') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
    </form>
    </div>
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
        <table class="table table-bordered table-striped table-condensed" style="border:thick" style="border-color:#000000">
<tr>
  <th rowspan="3" class="color_cream"><strong>Cost Component</strong></th>
  <th colspan="2" class="color_cream centered">Actual</th>
  <th colspan="2" class="color_cream centered">Planned</th>
  <th colspan="2" class="color_cream centered">Variance in %</th>
  <th rowspan="2" class="color_cream">Contract Value</th>
  <th rowspan="2" class="color_cream">Weight of Cost Component</th>
  <th rowspan="2" class="color_cream">Percentage of Cost Component</th>
</tr>
<tr>
  <th class="color_cream">Cummulative-to Date (IDR)</th>
  <th class="color_cream">Cummulative-to Date (%)</th>
  <th class="color_cream">Cummulative-to Date (IDR)</th>
  <th class="color_cream">Cummulative-to Date (%)</th>
  <th class="color_cream">Cummulative-to Date (IDR)</th>
  <th class="color_cream">Cummulative-to Date (%)</th>
</tr>
<tr>
<?php for ($c = 1; $c < 10; $c++) {echo '<th class="color_cream">'.$c.'</td>';}?>
</tr>
<tr>
<td colspan="10">&nbsp;</td>
</tr>

<!-- Cummulative for each cost component -->
<?php
// loop data cost component
$planned_total = 0;
$disbursed_total = 0;
$impl_total = 0;
$impl_total_all = 0;

// get total contracted value
$proc_impl_total = $this->Proc_model->getImpSum($grantee_id, $rpp_detail->id, null, null, $year_end, $year_start);
$non_proc_impl_total = $this->Non_proc_model->getImpSum($grantee_id, $rpp_detail->id, null, null, $year_end, $year_start);
$impl_total_all = $proc_impl_total+$non_proc_impl_total;

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
		// get contracted value for current cost component
        $proc_sum_impl_cc = $this->Proc_model->getRecImpSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $year_end, $year_start);
        $non_proc_impl_disb_cc = $this->Non_proc_model->getRecImpSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $year_end, $year_start);
	    $impl_total += $impl_sum = $proc_sum_impl_cc+$non_proc_impl_disb_cc;
        echo '<tr>';
        echo '<th class="color_cream">'.$n.'. '.$data['data']->name_of_fpc.'</th>';
		?>
        <td class="color_cream align_right"><?php
		    // 1
            $proc_sum_disb = $this->Proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $cummulative_date_start);
            $non_proc_sum_disb = $this->Non_proc_model->getRecDisbursedSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $cummulative_date_start);
	        $disbursed_total += $disbursed_sum = $proc_sum_disb+$non_proc_sum_disb;
	        echo number_format($disbursed_sum, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
		    // 2
		    $disb_procentage = 0;
            if ($impl_sum > 0 && $disbursed_sum > 0) {
			  $disb_procentage = round($disbursed_sum/$impl_sum, 2);
			  echo ($disb_procentage*0.01).'%';
			}
	      ?></td>
        <td class="color_cream align_right"><?php
		    // 3
            $proc_sum_plan = $this->Proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $cummulative_date_start);
            $non_proc_sum_plan = $this->Non_proc_model->getRecPlanSum($grantee_id, $rpp_detail->id, $data['data']->id, null, $date_end, $cummulative_date_start);
	        $planned_total += $plan_sum = $proc_sum_plan+$non_proc_sum_plan;
	        echo number_format($plan_sum, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
		    // 4
		    $plan_procentage = 0;
            if ($impl_sum > 0 && $plan_sum > 0) {
			  $plan_procentage = round($plan_sum/$impl_sum, 2);
			  echo ($plan_procentage*0.01).'%';
			}
	      ?></td>
        <td class="color_cream align_right"><?php
		    // 5
		    echo number_format($plan_sum-$disbursed_sum, 0, '', '.');
	      ?></td>
        <td class="color_cream align_right"><?php
		    // 6
			$cummulative_procentage = round($plan_procentage-$disb_procentage, 2);
		    echo ($cummulative_procentage*0.01).'%';
	      ?></td>
        <td class="color_cream align_right"><?php
		    // 7
		    echo number_format($impl_sum, 0, '', '.')
		  ?></td>
        <td class="color_cream align_right"><?php
		  // 8
		  $weight_procentage = 0;
		  if ($impl_sum > 0 && $impl_total_all > 0) {
			$weight_procentage = round($impl_sum/$impl_total_all, 2);
			echo ($weight_procentage*0.01).'%';
		  }
		  ?></td>
        <td class="color_cream align_right"><?php
		  // 9
		  $cc_procentage = 0;
		  if ($weight_procentage > 0 && $disb_procentage > 0) {
			$cc_procentage = round($disb_procentage*$weight_procentage, 2);
			echo ($cc_procentage*0.01).'%';
			// echo $cc_procentage;
		  }
		  ?></td>
		<?php
        echo '</tr>';
	
	    // level 2
        if ($data['childs']) {
           foreach ($data['childs'] as $id2 => $data2) {
		    // get contracted value for current cost component
            $proc_sum_impl_cc = $this->Proc_model->getImpSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $year_end, $year_start);
            $non_proc_impl_disb_cc = $this->Non_proc_model->getImpSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $year_end, $year_start);
	        $impl_total += $impl_sum = $proc_sum_impl_cc+$non_proc_impl_disb_cc;
            
			echo '<tr>';
            echo '<td style="padding-left: 20px;">'.$data2['data']->code.' '.$data2['data']->name_of_fpc.'</td>';
            ?>
            <td class="align_right"><?php
                $proc_sum_disb = $this->Proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $cummulative_date_start);
                $non_proc_sum_disb = $this->Non_proc_model->getDisbursedSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $cummulative_date_start);
	            $disbursed_sum = $proc_sum_disb+$non_proc_sum_disb;
	            echo number_format($disbursed_sum, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
		        $disb_procentage = 0;
                if ($impl_sum > 0 && $disbursed_sum > 0) {
		    	  $disb_procentage = round($disbursed_sum/$impl_sum, 2);
		    	  echo ($disb_procentage*0.01).'%';
		    	}
	          ?></td>
            <td class="align_right"><?php
                $proc_sum_plan = $this->Proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $cummulative_date_start);
                $non_proc_sum_plan = $this->Non_proc_model->getPlanSum($grantee_id, $rpp_detail->id, $data2['data']->id, null, $date_end, $cummulative_date_start);
	            $plan_sum = $proc_sum_plan+$non_proc_sum_plan;
	            echo number_format($plan_sum, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
		        $plan_procentage = 0;
                if ($impl_sum > 0 && $plan_sum > 0) {
		    	  $plan_procentage = round($plan_sum/$impl_sum, 2);
		    	  echo ($plan_procentage*0.01).'%';
		    	}
	          ?></td>
            <td class="align_right"><?php
		        echo number_format($plan_sum-$disbursed_sum, 0, '', '.');
	          ?></td>
            <td class="align_right"><?php
			    $cummulative_procentage = round($plan_procentage-$disb_procentage, 2);
		        echo ($cummulative_procentage*0.01).'%';
	          ?></td>
            <td class="align_right"><?php echo number_format($impl_sum, 0, '', '.') ?></td>
            <td class="align_right"><?php
		      $weight_procentage = 0;
		      if ($impl_sum > 0 && $impl_total_all > 0) {
		    	$weight_procentage = round($impl_sum/$impl_total_all, 2);
		    	echo ($weight_procentage*0.01).'%';
		      }
		      ?></td>
            <td class="align_right"><?php
		      $cc_procentage = 0;
		      if ($weight_procentage > 0 && $disb_procentage > 0) {
		    	$cc_procentage = round($disb_procentage*$weight_procentage, 2);
		    	echo ($cc_procentage*0.01).'%';
		      }
		      ?></td>
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
<td colspan="10">&nbsp;</td>
</tr>

<tr>
<td style="padding-left: 20px;">TOTAL</td>
<td class="align_right"><?php echo number_format($disbursed_total, 0, '', '.'); ?></td>
<td class="align_right"><?php
  $disbursed_total_procentage = round($disbursed_total/$impl_total_all, 2);
  if ($disbursed_total > 0 && $impl_total_all > 0) {
    echo ($disbursed_total_procentage*0.01).'%';
  }
  ?></td>
<td class="align_right"><?php echo number_format($planned_total, 0, '', '.'); ?></td>
<td class="align_right"><?php
  $planned_total_procentage = round($planned_total/$impl_total_all, 2);
  if ($planned_total > 0 && $impl_total_all > 0) {
    echo ($planned_total_procentage*0.01).'%';
  }
  ?></td>
<td class="align_right"><?php echo number_format($planned_total-$disbursed_total, 0, '', '.'); ?></td>
<td class="align_right"><?php
    echo (($planned_total_procentage-$disbursed_total_procentage)*0.01).'%';
  ?></td>
<td class="align_right"><?php echo number_format($impl_total_all, 0, '', '.') ?></td>
<td class="align_right"><?php
  $weight_total_procentage = 0;
  if ($impl_total_all > 0) {
	$weight_total_procentage = round($impl_total_all/$impl_total_all, 2);
    echo (($weight_total_procentage)*0.01).'%';
  }
  ?></td>
<td class="align_right"><?php
  if ($disbursed_total_procentage > 0 && $weight_total_procentage > 0) {
    echo (($disbursed_total_procentage*$weight_total_procentage)*0.01).'%';
  }
?></td>

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
