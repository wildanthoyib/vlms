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
<h3><div>Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />1C: Project Cash Forecast</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>
<!-- filter -->

<!-- end of filter -->

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>1C: Project Cash Forecast</i></h2> 				
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
        <label class="sr-only" for="keywords">Kata kunci</label>
	  <input type="text" class="form-control with_tooltip" id="keywords" name="keywords" placeholder="Masukan kata kunci yang diinginkan" title="Ketikan Kata Kunci Filtering dengan menentukan salah satu kolom" />
      </div>
      <div class="form-group">
        <label class="sr-only" for="tahun_anggaran">Tahun Anggaran</label>
        <select class="form-control" id="tahun_anggaran" name="tahun_anggaran">
	      <?php foreach ($year_list as $y) { echo '<option value="'.$y.'">'.$y.'</option>'; } ?>
	    </select>
      </div>
	  <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-filter"></i>Filter Kolom</button>
	    <a href="<?php echo site_url('/reports/index/1C') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
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
        <table class="table table-bordered table-striped table-condensed" style="border:thick" style="border-color:#000000">
<tr bgcolor="#FFCC00">
  <th rowspan="4" style="background-color:#FFCC00">Cost Component</th>
</tr>
<tr>
  <th bgcolor="#FFCC00">Cash Requirement For Quarter Ending 31 March 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For Quarter Ending 30 June 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For Quarter Ending 30 Sept 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For Quarter Ending 30 Dec 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For One Year Ending 30 Dec 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For One Year Ending 30 Dec 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For One Year Ending 30 Dec 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For One Year Ending 30 Dec 2013</th>
  <th bgcolor="#FFCC00">Cash Requirement For One Year Ending 30 Dec 2013</th>
</tr>
<tr>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
  <th style="background-color:#FFCC00" align="center">DIPA</th>
</tr>  
<tr>
<?php for ($c = 1; $c < 10; $c++) {echo '<th bgcolor="#FFCC00">'.$c.'</td>';}?>
</tr>
<tr>
  <td><strong>Source of Funds</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="justify">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;ADB</td>
  <td align="center">&nbsp;26.866.988</td>
  <td align="center">&nbsp;26.866.988</td>
  <td align="center">&nbsp;26.866.988</td>
  <td>&nbsp;26.866.988</td>
  <td>&nbsp;26.866.988</td>
  <td>&nbsp;26.866.988</td>
  <td align="center">&nbsp;0,01</td>
  <td align="center">&nbsp;0,01</td>
  <td align="center">&nbsp;0,01</td>
</tr>
<tr>
  <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;GOI</td>
  <td>&nbsp;169.998.001</td>
  <td>&nbsp;169.998.001</td>
  <td>&nbsp;169.998.001</td>
  <td>&nbsp;169.998.001</td>
  <td>&nbsp;169.998.001</td>
  <td>&nbsp;169.998.001</td>
  <td align="center">&nbsp;0,09</td>
  <td align="center">&nbsp;0,09</td>
  <td align="center">&nbsp;0,09</td> 
</tr>
<tr>
  <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;DRK</td>
  <td>&nbsp;29.991.700</td>
  <td>&nbsp;29.991.700</td>
  <td>&nbsp;29.991.700</td>
  <td>&nbsp;29.991.700</td>
  <td>&nbsp;29.991.700</td>
  <td>&nbsp;29.991.700</td>
  <td align="center">&nbsp;0,19</td>
  <td align="center">&nbsp;0,19</td>
  <td align="center">&nbsp;0,19</td> 
</tr>
<tr>
  <td style="background-color:#FFCCDD"><strong>Total Sources of Fund</strong></td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD" align="center">&nbsp;0,00</td>
  <td style="background-color:#FFCCDD">&nbsp;0,00</td>
  <td style="background-color:#FFCCDD">&nbsp;0,00</td> 
</tr>
<tr>
  <td><strong>Uses of Fund</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Procurement (ADB)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Equipment(ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Material (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Peralatan Pendukung Lainnya (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Civil Work (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Capacity Development (ADB)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Domestic Non Degree (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Overseas Non Degree (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Capacity Development (GOI)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Domestic Non Degree (GOI)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Overseas Degree (GOI)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Program and Technical Learning</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Program Development (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Teaching Learning Material Development (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Studies and Workshop (ADB)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Study (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Workshop (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Technical Assistant (ADB)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Domestic Consultant (ADB)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Project Management (GOI)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Remuneration/Staff Salary (GOI)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td><strong>Project Management (DRK)</strong></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Operational Cost (DRK)</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td>Remuneration/Staff Salary</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td> 
</tr>
<tr>
  <td style="background-color:#FFCCDD"><strong>Total Sources of Fund</strong></td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD">&nbsp;1.201.050.098</td>
  <td style="background-color:#FFCCDD" align="center">&nbsp;0,00</td>
  <td style="background-color:#FFCCDD">&nbsp;0,00</td>
  <td style="background-color:#FFCCDD">&nbsp;0,00</td> 
</tr>
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
