<h3>Polytechnics Education Development Project (PEDP) ADB Loan No. 2928-INO<div><strong>Helps & Manual SIMONE</strong></div></h3>
<h2>
<div class="alert alert-info">Manual Entry Data</div>
</h2>


<table class="table table-condensed table-bordered">
 <tr class="bg-success">
	      <th class="very-short">Nomor</th>
	      <th class="short">Pilihan Panduan</th>
	     <!-- <th class="short">Download Panduan</th> -->
</tr>
<tr>
    <td class="very-short">1</td> 
    <td class="short"><a href="<?php echo site_url('/dashboard/introduction') ?>" > Pengenalan Sistem Informasi</a></td>
   <!-- <td class="short"><a href="<?php echo base_url()."assets/panduan/"; ?>" target="blank" class="alert alert-info" class="form-control with_tooltip" title="Silahkan dipelajari dan diunduh!"><strong>Panduan Pengenalan.pdf</strong></td>-->
</tr>
<tr>
    <td class="very-short">2</td> 
    <td class="short"><a href="<?php echo site_url('/dashboard/input_rpp') ?>" > Manual Data Entry Program Plan</a></td>
    <!--<td class="short"><a href="<?php echo base_url()."assets/panduan/"; ?>" target="blank" class="alert alert-info" class="form-control with_tooltip" title="Silahkan dipelajari dan diunduh!"><strong>Panduan Input Data RPP.pdf</strong></td>-->
</tr>
<tr>
    <td class="very-short">3</td> 
    <td class="short"><a href="<?php echo site_url('/dashboard/proc_help') ?>" > Manual Data Entry Program Implementation-Procurement (Contracted)</a></td>
    <!--<td class="short"><a href="<?php echo base_url()."assets/panduan/"; ?>" target="blank" class="alert alert-info" class="form-control with_tooltip" title="Silahkan dipelajari dan diunduh!"><strong>Panduan Input Data Procurement Plan.pdf</strong></td>-->
</tr>
<tr>
    <td class="very-short">4</td> 
    <td class="short"><a href="<?php echo site_url('/dashboard/nonproc_help') ?>" > Manual Data Entry Program Implementation-Non Procurement (Contracted)</a></td>
    <!--<td class="short"><a href="<?php echo base_url()."assets/panduan/"; ?>" target="blank" class="alert alert-info" class="form-control with_tooltip" title="Silahkan dipelajari dan diunduh!"><strong>Panduan Input Data Non-Procurement Plan.pdf</strong></td>-->
</tr>
<tr>
    <td class="very-short">5</td> 
    <td class="short"><a href="<?php echo site_url('/dashboard/disbursement_help') ?>" > Manual Entry Data Surat Perintah Pencairan Dana(SP2D)</a></td>
    <!--<td class="short"><a href="<?php echo base_url()."assets/panduan/"; ?>" target="blank" class="alert alert-info" class="form-control with_tooltip" title="Silahkan dipelajari dan diunduh!"><strong>Panduan Input Data Non-Procurement Plan.pdf</strong></td>-->
</tr>
<?php
$main_content = ob_get_clean();
require './assets/smartadmin/index-blank.tpl.php';