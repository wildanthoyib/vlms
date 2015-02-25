<?php
ob_start();
$year_oldest = date('Y')-1;
$year_latest = date('Y')+4;

ob_start();
if (!isset($pmu_grantee)) :
if (!isset($print_view)) {
  echo '<div class="alert alert-info">Selamat datang <i>User Kontribusi/Administrasi</i> atas nama <strong>'.$user_data['realname'].'</strong> pada Sistem Validation Logic Management System.</div>';
}
?>
<h3>Validation Logic Management System
  <br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
  <!--
  <div><strong>Recapitulation Dashboard</strong> of the <strong><?php echo $user_data['realname'] ?></strong> Accomplishment Report</div>
  <div>Contract Number of DIKTI: <strong><?php //echo $default_rpp_name ?></strong></div></h3>
  -->
<?php
else :
?>
<h3>Recapitulation of <strong>Planning vs Implementation Data</strong> for
  <div><strong><?php echo $user_data['realname']  ?></strong> - <?php echo $default_rpp_name ?></div></h3>
<?php
endif;
$header = ob_get_clean();

if (!isset($print_view)) {
  echo $header;
}

?>
<div class="panel panel-default filter-form">
  <div class="panel-heading">Pemilahan data berdasarkan nomor kontrak DIKTI</div>
  <div class="panel-body">
    <form method="get" class="form-inline" action="<?php echo site_url('/dashboard/index') ?>" role="form">
	  <div class="form-group">
		<?php if ('pmu' == $user_data['groups'] && 'admin' == $user_data['groups']) : ?>
        <!-- <select class="form-control" name="year"><?php for ($y = $year_oldest; $y < $year_latest; $y++) : ?><option value="<?php echo $y; ?>"><?php echo $y; ?></option><?php endfor; ?></select> -->
		<select class="form-control" id="rpp" name="rpp" placeholder="RPP/Tahun Anggaran"><?php foreach ($list_rpp as $komp) : ?>
		  <option value="<?php echo $komp->id; ?>" <?php echo $komp->id==$default_rpp?'selected':'' ?>><?php echo $komp->contract.' - '.$komp->year ?></option><?php endforeach; ?>
		</select>
		<?php else : ?>
		<select class="form-control" id="rpp" name="rpp" placeholder="RPP/Tahun Anggaran"><?php foreach ($list_rpp as $komp) : ?>
		  <option value="<?php echo $komp->id; ?>" <?php echo $komp->id==$default_rpp?'selected':'' ?>><?php echo $komp->contract.' - '.$komp->year ?></option><?php endforeach; ?>
		</select>
		<?php endif; ?>
      </div>
	  <div class="form-group">
	    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-share"></i> Ubah Pemilahan</button>
		<a href="<?php echo site_url('/dashboard/index') ?>?print=yes" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
	  </div>
	  <!-- <button type="button" class="btn btn-warning show-opsi-form">Tampilkan opsi data</button> -->
	</form>
  </div>
</div>

<?php ob_start(); ?>
<table class="table table-bordered">
<?php
$proc_non_proc = array('Proc' => 'Procurement', 'Non-Proc' => 'Non-Procurement');
if ($user_data['grantee_id']) {
  foreach ($user_data['schema'] as $schema) {
    echo '<tr>';
    echo '<th colspan="12"><h4>Metoda Seleksi: <strong>'.$schema['name'].'</strong></h4></th>';
    echo '</tr>';
    echo '<tr class="info">';
    echo '<th>Project Components</th>';
   /*echo '</tr>';
    echo '<tr>';*/
    echo '<th>RPP (IDR)</th>';
   /* echo '</tr>';
    echo '<tr><th>ADB</th>';
    echo '<th>GOI</th>';
    echo '</tr>';*/
    echo '<th>DIPA (IDR)</th>';
    echo '<th>Contracted (IDR)</th>';
    echo '<th>Disbursed (IDR)</th>';
    echo '<th>% of Disbursed to DIPA</th>';
    echo '<th>% of Disbursed to Contracted</th>';
   // echo '<th>% of Accomplishment</th>';
    echo '</tr>';
    
  foreach ($proc_non_proc as $val => $pnp) {
      echo '<tr class="active">';
      echo '<th colspan="12"><h4>'.$pnp.'</h4></th>';
      echo '</tr>';
      $fpc = '';//$this->Master_model->getRecursiveFPC(null, $schema['id'], null, $val, 'PIU');
	  if (!$fpc) {
		break;
	  }
      foreach ($fpc as $id => $data) {
	/*if ($data['grantee_type'] == 'PMU') {
	  continue; 
	}*/
        echo '<tr>';
        echo '<th>'.$data['data']->code.' '.$data['data']->name_of_fpc.'</th>';     /*stream project component*/
		$total_component_top = $this->Rpp_model->getRecRppTotalComponent($default_rpp, $data['data']->id);  
	    echo '<td>'.number_format($total_component_top, 0, '', '.'). '</td>'; /*RPP IDR*/  
  
		if ($val == 'Proc') {
		  $plan_sum = $this->Proc_model->getRecPlanSum($user_data['grantee_id'], $default_rpp, $data['data']->id);  
		} else {
		  $plan_sum = $this->Non_proc_model->getRecPlanSum($user_data['grantee_id'], $default_rpp, $data['data']->id);  
		}
		
            echo '<td>'.number_format($plan_sum, 0, '', '.').'</td>'; /*DIPA IDR*/
		
		if ($val == 'Proc') {
		  $impl_sum = $this->Proc_model->getRecImpSum($user_data['grantee_id'], $default_rpp, $data['data']->id);  
		} else {
		  $impl_sum = $this->Non_proc_model->getRecImpSum($user_data['grantee_id'], $default_rpp, $data['data']->id);
		}
		
           echo '<td>'.number_format($impl_sum, 0, '', '.').'</td>'; /*Contracted IDR*/

		if ($val == 'Proc') {
		  $disb_sum = $this->Proc_model->getRecDisbursedSum($user_data['grantee_id'], $default_rpp, $data['data']->id);  
		} else {
		  $disb_sum = $this->Non_proc_model->getRecDisbursedSum($user_data['grantee_id'], $default_rpp, $data['data']->id);
		}		
		
	    echo '<td>'.number_format($disb_sum, 0, '', '.').'</td>'; /*Disbursed IDR*/
	    echo '<td>'.@(round(($disb_sum/$plan_sum)*100, 2)).'%</td>'; /*% of disbursed to DIPA*/
	    echo '<td>'.@(round(($disb_sum/$impl_sum)*100, 2)).'%</td>'; /*% of Disbursed to Contracted*/
        echo '</tr>';
	
	    // level 2
        if ($data['childs']) {
           foreach ($data['childs'] as $id2 => $data2) {
            echo '<tr>';
	    
             echo '<td style="padding-left: 20px;">'.$data2['data']->code.' '.$data2['data']->name_of_fpc.'</td>'; /*RPP IDR*/
	         // get total per component
			 $total_component = $this->Rpp_model->getRppTotalComponent($default_rpp, $data2['data']->id);
	     echo '<td>'.( isset($total_component->value)?number_format($total_component->value, 0, '', '.'):'0' ).'</td>'; /*DIPA IDR*/
  		 
			 if ($val == 'Proc') {
			   $plan_sum2 = $this->Proc_model->getPlanSum($user_data['grantee_id'], $default_rpp, $data2['data']->id);
			 } else {
			   $plan_sum2 = $this->Non_proc_model->getPlanSum($user_data['grantee_id'], $default_rpp, $data2['data']->id);
			 }
			 
             echo '<td>'.number_format($plan_sum2, 0, '', '.').'</td>'; /*Contracted IDR*/
			 
			 if ($val == 'Proc') {
			   $impl_sum2 = $this->Proc_model->getImpSum($user_data['grantee_id'], $default_rpp, $data2['data']->id); 
			 } else {
			   $impl_sum2 = $this->Non_proc_model->getImpSum($user_data['grantee_id'], $default_rpp, $data2['data']->id);
			 }
			 
             echo '<td>'.number_format($impl_sum2, 0, '', '.').'</td>'; /*Contracted IDR*/

		     if ($val == 'Proc') {
		       $disb_sum2 = $this->Proc_model->getDisbursedSum($user_data['grantee_id'], $default_rpp, $data2['data']->id);
		     } else {
		       $disb_sum2 = $this->Non_proc_model->getDisbursedSum($user_data['grantee_id'], $default_rpp, $data2['data']->id);
		     }

	        echo '<td>'.number_format($disb_sum2, 0, '', '.').'</td>'; /*Disbursed IDR*/
            echo '<td>'.@(round(($disb_sum2/$plan_sum2)*100, 2)).'%</td>'; /*% of disbursed to DIPA = Disbursed/DIPA*100% */
	        echo '<td>'.@(round(($disb_sum2/$impl_sum2)*100, 2)).'%</td>'; /*% of Disbursed to Contracted = Contracted/DIPA*100% */
	      
            echo '</tr>';
      	 }
        }
      } 
    }
  }
}
?>
</table>
<?php
$data_table = ob_get_clean();
if (!isset($print_view)) {
  echo $data_table;
}

$main_content = ob_get_clean();
if (isset($print_view)) {
  $main_content = null;
  $main_content = $header.$data_table;
  require './assets/smartadmin/index-print.tpl.php';
} else {
  require './assets/smartadmin/index-blank.tpl.php';  
}
