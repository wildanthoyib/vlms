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

ob_start();
?>
<h3 class="page-title txt-color-blueDark"><div id="print">Polytechnic Education Development Project ADB Loan No.2928-INO<br />Name of Grantee: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Financial Report<br />3C: Contract Expenditure Report (Goods)</div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>3C: Contract Expenditure Report (Goods)</i></h2> 				
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
              <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/3c'); ?>">
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
          	  <a href="<?php echo site_url('/reports/index/3c') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
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
          <th class="color_cream">No.</th>
          <th class="color_cream">Komponen Pembiayaan</th>
          <th class="color_cream">Bid Packing</th>
          <th class="color_cream">Procurement Method</th>
          <th class="color_cream">Contract No.</th>
          <th class="color_cream">Supplier / Contractor</th>
          <th class="color_cream">Nationality</th>
          <th class="color_cream">Contract Value (IDR)</th>
          <th class="color_cream">Voucher No. (SP2D	)</th>
          <th class="color_cream">Voucher Date</th>
          <th class="color_cream">Amount (IDR)</th>
          <th class="color_cream">Remaining Amount (IDR)</th>
          <th class="color_cream">Note</th>
        </tr>
        <?php
		// loop tahun
		foreach ($year_list as $y) :
		echo '<tr><td colspan="13" class="centered color_cream">'.$y.'</td></tr>';
		$n = 1;
		$total_contract = 0;
		$total_sp2d = 0;
		
		$records = array();
		// replace tahun pada criteria
		// $criteria = str_ireplace('`pedp_Proposal`.`year`=\'\'', '', $criteria);
		$criteria = preg_replace('@`year`=\'[0-9]{4}\'@i', '`year`=\''.$y.'\'', $criteria);
		$records = $this->Reports_model->report_3c(100, $criteria, $total_rows, 1);
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
            <td><?php echo $n ?></td>
            <td><?php echo $rec->name_of_fpc ?></td>
            <td><?php echo $rec->package_id ?></td>
            <td><?php echo $rec->procurement_method ?></td>
            <td><?php echo $rec->contract_no ?></td>
            <td><?php echo $rec->name_of_contractor ?></td>
            <td><?php echo $rec->nationality ?></td>
            <td class="align_right"><?php echo number_format($rec->contract_value, 0, '', '.'); $total_contract += $rec->contract_value ?></td>
            <td><?php echo $sp2d->sp2d_number ?></td>
            <td><?php echo date_not_empty($sp2d->sp2d_date)?date('d-m-Y', strtotime($sp2d->sp2d_date)):'' ?></td>
            <td class="align_right"><?php echo number_format($sp2d->value, 0, '', '.'); $total_sp2d += $sp2d->value ?></td>
            <td>0</td><!-- pengembalian sisa belum ada -->
            <td><?php echo $sp2d->notes ?></td>
          </tr>
        <?php
		  $n++;
		  endforeach;
        endforeach;
		
		echo '<tr><td colspan="7" class="centered">Total '.$y.'</td>';
		echo '<td>'.$total_contract.'</td>';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo '<td>'.$total_sp2d.'</td>';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo'</tr>';
		endforeach; // akhir loop tahun
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
