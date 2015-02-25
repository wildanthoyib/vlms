<?php
$year_list = array('2013', '2014', '2015', '2016', '2017');
ob_start();
function get_quarter($monthNumber) {
  return floor(($monthNumber - 1) / 3) + 1;
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
<h3 class="page-title txt-color-blueDark"><div id="print">VLMS<br />Kontributor / Administrator: <strong><?php echo $user_data['realname']  ?></strong>
<div><i class="fa fa-table fa-fw "></i>Data Aktivitas Dosen<br /></div></h3>
<?php
$header = ob_get_clean();
echo $header;
?>

<!-- start widget main -->
<div role="widget" class="jarviswidget jarviswidget-color-greenDark jarviswidget-sortable" id="wid-id-18" data-widget-colorbutton="false" data-widget-editbutton="false">
<header role="heading" style="background-color:grey;"><div role="menu" class="jarviswidget-ctrls">   <a data-original-title="Fullscreen" href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom"><i class="fa fa-resize-full "></i></a></div>
	<h2><strong>Form</strong> <i>Data Aktivitas Dosen</i></h2> 				
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
              <form method="get" role="form" class="form-inline" action="<?php echo site_url('/reports/index/g1'); ?>">
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
          	  <a href="<?php echo site_url('/reports/index/g1') ?>?<?php echo build_query() ?>" class="btn btn btn-success" target="blank"><i class="fa fa-print"></i> Cetak Report</a> 
          	</form>
            </div>
             <div class="alert alert-info">Ditemukan <?php //echo $total_rows ?> baris data Report</div>
          </div>
          
		  <div class="row">
		    <div>
			  <?php //echo $pagination ?>
		    </div>
		  </div>
		  
		</div>
		<!-- END start toolbar -->
		
		<div class="custom-scroll table-responsive" style="height:auto; overflow: scroll;">
        
		<?php ob_start(); ?>
        <table id="datatable_tabletools" class="table table-bordered table-striped table-condensed table-hover">
        <tr>
          <th>No</th>
          <th>Nama Dosen</th>
		  <th>NIDN</th>
          <th>Jenis Kelamin</th>
		  <th>Tempat Lahir</th>
		  <th>Tgl Lahir</th>
		  
		  <th>Pendidikan Terakhir</th>
		  <th>Pangkat/Golongan</th>
		  <th>Nama MK</th>
		  <th>Jumlah SKS</th>
		  <th>TM Rencana</th>
		  <th>TM Realisasi</th>
        </tr>
        <?php
        //var_dump($records);
		$a=1;
		//print_r($records);
        foreach ($records as $rec) :
          
		?>
          <tr>
            <td><?php echo $a; ?></td>
            <td><?php echo $rec->nm_ptk; ?></td>
			<td><?php echo $rec->nidn; ?></td>
            <td><?php echo $rec->jk; ?></td>
			<td><?php echo $rec->tmpt_lahir; ?></td>
			<td><?php echo $rec->tgl_lahir; ?></td>
			
			<td><?php echo $rec->id_jenj_didik; ?></td>
			<td><?php echo $rec->nm_mk; ?></td>
			<td><?php echo $rec->sks_mk; ?></td>
			<td><?php echo $rec->sks_tm; ?></td>
			<td><?php echo $rec->sks_prak_lap; ?></td>
			<td><?php echo '#'; ?></td>
          </tr>
        <?php
		$a++;
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
