<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Master extends CI_Controller {
    private $data = array();

	public function __construct()
	{
	  parent::__construct();
	  $this->data['main_content'] = '';
	  $this->data['user_data'] = $this->session->userdata('is_logged_in');
	  if (!$this->data['user_data']) {
		redirect('/login');
		return;
	  }
	  $this->load->model('Master_model');
	}
    
	/**
	 * Browser data Master 
	 */
	public function index($type, $page = 1)
	{
	  $this->load->library('pagination');
      //pagination settings
      $config['per_page'] = 20;
      $config['base_url'] = site_url('/master/index/'.$type);
      $config['use_page_numbers'] = TRUE;
      $config['num_links'] = 10;
      $config['uri_segment'] = 4;
      $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a>';
      $config['cur_tag_close'] = '</a></li>';
      $config['next_link'] = ' Next';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['prev_link'] = ' Prev';
      $config['prev_tag_open'] = '<li>';
      $config['prev_tag_close'] = '</li>';
      $total_rows = 0;
	  
	  $keywords = $this->input->get('keywords');
	  $filter = null;

	  if ($type == 'contractor') {
	  		// filter data based on search keywords
		if ($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $filter = "name_of_contractor LIKE $keywords OR id LIKE $keywords";

		}
	     $this->data['list_category'] =  $this->Master_model->getMasterData('Contractor');	  
	     $this->data['records'] = $this->Master_model->getMasterData('Contractor', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  } 
	  
	  else if ($type == 'grantee') {
		// filter data based on search keywords
		if ($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $filter = "name_of_grantee LIKE $keywords OR id LIKE $keywords";
		}
		$this->data['list_of_schemas'] = $this->Master_model->getMasterData('Schema');
	  	$this->data['records'] = $this->Master_model->getMasterData('Grantee', $config['per_page'], $filter, $total_rows, $page);
		$this->data['list_wilayah'] = $this->Master_model->getMasterData('WilayahIndonesia', 1000);
	  	$config['total_rows'] = $total_rows;
	  }
	  
	  else if ($type == 'procurement_method') {
	  // filter data based on search keywords
		if ($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $filter = "procurement_method LIKE $keywords OR id LIKE $keywords";
		}
		$this->data['records'] = $this->Master_model->getMasterData('ProcurementMethod', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	 
	  else if ($type == 'schema') {
	  //filer data based on search keywords
	  if($keywords) {
	  	$keywords = $this->db->escape('%'. $keywords.'%');
		$filter = "schema_name LIKE $keywords OR id LIKE $keywords";
	  }
		$this->data['records'] = $this->Master_model->getMasterData('Schema', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	 
	  else if ($type == 'source_of_fund') {
	  if($keywords) {
	  	$keywords = $this->db->escape('%'.$keywords.'%');
		$filter = "source_of_fund LIKE $keywords OR id LIKE $keywords";
	  }
		$this->data['records'] = $this->Master_model->getMasterData('SourceOfFund', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == 'financial_project_component') {
        $curr_schema = $this->session->userdata('curr_schema');
        $filter_schema = $this->input->get('schema');
        if ($filter_schema) {
          $curr_schema = $filter_schema;
          $this->session->set_userdata('curr_schema', $filter_schema);
        }
	  
		$filter = "parent_id IS NOT NULL";	
	    if($keywords) {
	  	  $keywords = $this->db->escape('%'.$keywords.'%');
		  $filter .= "(name_of_fpc LIKE $keywords OR code LIKE $keywords)";
	    }
		if ($curr_schema) {
		  $filter .= sprintf(" AND subject=%d", $curr_schema);	
		} else {
		  $filter .= " AND subject=1";
		}
		$this->data['curr_schema'] = $curr_schema;
		$this->data['list_fund'] = $this->Master_model->getMasterData('SourceOfFund', 1000);
		$this->data['list_component'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, 'parent_id IS NULL');
		$this->data['list_schema'] = $this->Master_model->getMasterData('Schema', 1000);
		$this->data['list_proc_or_nonproc'] = $this->Master_model->getMasterData('FinancialProjComp');
		$this->data['list_grantee_type'] = $this->Master_model->getMasterData('FinancialProjComp');
		$this->data['records'] = $this->Master_model->getMasterData('FinancialProjComp', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == 'activity_package') {
	  if ($keywords) {
	  	$keywords = $this->db->escape('%'.$keywords.'%');
		$filter = "package_name LIKE $keywords OR id LIKE $keywords";
	  }
		$this->data['list_activity'] = $this->Master_model->getMasterData('ActivityPackage', 1000);
		$this->data['records'] = $this->Master_model->getMasterData('ActivityPackage', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }	
	  else if ($type == 'status') {
	  if($keywords) {
	  	$keywords = $this->db->escape('%'.$keywords.'%');
		$filter = "status LIKE $keywords OR id LIKE $keywords";
	  }
		$this->data['records'] = $this->Master_model->getMasterData('Status', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == 'quartal'){
	  	if($keywords) {
			$keywords = $this->db->escape('%'.$keywords.'%');
			$filter = "quartal LIKE $keywords OR id LIKE $keywords";
		}
		$this->data['records'] = $this->Master_model->getMasterData('Quartal', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	   else if ($type == 'users') {
	   $filter = 'id <> 1';
	   $this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 1000);
	   if($keywords) {
			$keywords = $this->db->escape('%'.$keywords.'%');
			$filter .= " AND (username LIKE $keywords OR realname LIKE $keywords OR grantee_id LIKE $keywords)";	   
	   }
	        $this->data['groups'] = array('admin' => 'ADMIN','pmu' => 'PMU','piu' => 'PIU', 'reviewer' => 'Reviewer');   
		$this->data['list_grantees'] = $this->Master_model->getMasterData('Grantee',1000);
		$this->data['records'] = $this->Master_model->getMasterData('Users', $config['per_page'], $filter, $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	  else if($type == 'wilayah_pt'){
		$this->data['list_wilayah'] = $this->Master_model->getMasterData('WilayahIndonesia',1000);
		$this->data['records'] = $this->Master_model->getMasterData('WilayahIndonesia', $config['per_page'], '', $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
	  else if($type == 'loan_proceeds') {
		$this->data['list_fund'] = $this->Master_model->getMasterData('SourceOfFund', 1000);
		$this->data['list_schema'] = $this->Master_model->getMasterData('Schema', 1000);
		$this->data['list_loan'] = $this->Master_model->getMasterData('LoanProceeds', 1000);
		$this->data['records'] = $this->Master_model->getMasterData('LoanProceeds', $config['per_page'], '', $total_rows, $page);
		$config['total_rows'] = $total_rows;
	  }
      
	  $this->data['total_rows'] = $total_rows;
	  $this->pagination->initialize($config);
	  $this->data['pagination'] = $this->pagination->create_links();
	  $this->load->view('master/browse/'.$type, $this->data);
	}

	/**
	 * Tambah data Master Data
	 */
	public function add($type)
	{
	  if ($type == 'contractor') {
	      $this->data['list_category'] =  $this->Master_model->getMasterData('Contractor', 1000);
	      $this->load->view('master/add/contractor', $this->data);
	  } 
	  else if ($type == 'grantee') {
		$this->data['list_of_schemas'] = $this->Master_model->getMasterData('Schema');
		$this->data['list_wilayah'] = $this->Master_model->getMasterData('WilayahIndonesia', 1000);
	    $this->load->view('master/add/grantee', $this->data);
	  }
	  else if ($type == 'procurement_method') {
		$this->load->view('master/add/procurement_method', $this->data);
	  }
	  else if ($type == 'activity') {
		$this->load->view('master/add/activity', $this->data);
	  }
	  else if ($type == 'schema') {
		$this->load->view('master/add/schema', $this->data);
	  }
	  else if ($type == 'source_of_fund') {
		$this->load->view('master/add/source_of_fund', $this->data);
	  }
	  else if ($type == 'financial_project_component') {
		$this->data['list_fund'] = $this->Master_model->getMasterData('SourceOfFund', 1000);
		$this->data['list_component'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, 'parent_id IS NULL');
		$this->data['list_schema'] = $this->Master_model->getMasterData('Schema', 1000);
		$this->data['list_proc_or_nonproc'] = $this->Master_model->getMasterData('FinancialProjComp',1000);
		$this->data['list_grantee_type'] = $this->Master_model->getMasterData('FinancialProjComp');
		$this->load->view('master/add/financial_project_component', $this->data);
	  }
	  else if ($type == 'activity_package') {
		$this->data['list_activity'] = $this->Master_model->getMasterData('ActivityPackage', 1000);
		$this->load->view('master/add/activity_package', $this->data);
	  }
	  else if ($type == 'status') {
		$this->load->view('master/add/status', $this->data);
	  }
	  else if ($type == 'quartal') {
		$this->load->view('master/add/quartal', $this->data);
	  }
	  else if ($type == 'users') {
		$this->data['list_grantee'] = $this->Master_model->getMasterData('Grantee', 1000);
		$this->data['groups'] = array('admin' => 'ADMIN','pmu' => 'PMU','piu' => 'PIU', 'reviewer' => 'Reviewer');
		$this->load->view('master/add/users', $this->data); 
	  }
	  else if($type == 'wilayah_pt'){
		$this->data['list_wilayah'] = $this->Master_model->getMasterData('WilayahIndonesia', 1000);
 		$this->load->view('master/add/wilayahindonesia', $this->data);
	  }
	  else if($type == 'loan_proceeds') {
		$this->data['list_loan'] = $this->Master_model->getMasterData('LoanProceeds', 1000);
		$this->load->view('master/add/loan_proceeds', $this->data);
	  }
	}

	/**
	 * Proses simpan data master dari form
	 */
	public function simpan($type)
	{
	  if ($type == 'contractor') {
		$name_of_contractors = $this->input->post('name_of_contractor');
		$company_profiles = $this->input->post('company_profile');
		$addresses = $this->input->post('address');
		$contact_persons = $this->input->post('contact_person');
		$nationalities = $this->input->post('nationality');
		$email_addresses = $this->input->post('email_address');
		$telp_numberss = $this->input->post('telp_number');
		$fax_numberss = $this->input->post('fax_number');
		$category_of_contractors = $this->input->post('category_of_contractor');
		$updateIDs = $this->input->post('updateID');
		foreach ($name_of_contractors as $id => $value) {
		  $insert_data = array();
		  if (trim($name_of_contractors[$id]) != '') {
			$insert_data['name_of_contractor'] = $name_of_contractors[$id];
			$insert_data['company_profile'] = $company_profiles[$id];
			$insert_data['address'] = $addresses[$id];
			$insert_data['contact_person'] = $contact_persons[$id];
			$insert_data['nationality'] = $nationalities[$id];
			$insert_data['email_address'] = $email_addresses[$id];
			$insert_data['telp_number'] = $telp_numberss[$id];
			$insert_data['fax_number'] = $fax_numberss[$id];
			$insert_data['category_of_contractor'] = $category_of_contractors[$id];
			if($updateIDs[$id]) {
			    $this->Master_model->simpan('Contractor', $insert_data, true, array('id' => $id));		  
			}
			else {
			    $this->Master_model->simpan('Contractor', $insert_data, false);
			}
		  }
		}
		$this->session->set_flashdata('pesan_simpan', 'Data kontraktor telah disimpan');
		redirect('/master/index/contractor');
	  } 
	  else if ($type == 'grantee') {
		$ids = $this->input->post('id');
		$name_of_grantees = $this->input->post('name_of_grantee');
		$addresses = $this->input->post('address');
		$emails = $this->input->post('email');
		$phones = $this->input->post('phone');
		$managers = $this->input->post('manager');
		$scheme_projects = $this->input->post('scheme_project');
		$batch_numbers = $this->input->post('batch_number');
		$status_grantees = $this->input->post('status_grantee');
		$areas = $this->input->post('wilayah');
		$years_period = $this->input->post('year_period');
		$contract_numbers = $this->input->post('contract_number');
		$FPIC_IDs = $this->input->post('FPIC_ID');
		$schemas = $this->input->post('schemas');
		$years_of_project_fund_allocation = $this->input->post('year_of_project_fund_allocation');
		$allocation_of_project_funds = $this->input->post('allocation_of_project_fund');
		$years_of_DIPA_allocations = $this->input->post('year_of_DIPA_alocation');
		$allocations_of_DIPA_fund = $this->input->post('allocation_of_DIPA_fund');
		$updateIDs = $this->input->post('updateID');
		foreach ($ids as $id => $value) {
		  $insert_data = array();
		  if (trim($ids[$id]) != '' && trim($name_of_grantees[$id]) != '') {
		  	$insert_data['id'] = $ids[$id];
			$insert_data['name_of_grantee'] = $name_of_grantees[$id];
			$insert_data['address'] = $addresses[$id];
			$insert_data['email'] = $emails[$id];
			$insert_data['phone'] = $phones[$id];
			$insert_data['manager'] = $managers[$id];						
			$insert_data['scheme_project'] = $scheme_projects[$id];
			$insert_data['batch_number'] = $batch_numbers[$id];
			$insert_data['status_grantee'] = $status_grantees[$id];
			$insert_data['wilayah'] = $areas[$id];
			$insert_data['contract_number'] = $contract_numbers[$id];
			$insert_data['year_period'] = $years_period[$id];				
			$insert_data['FPIC_ID'] = $FPIC_IDs[$id];														
			$insert_data['year_of_project_fund_allocation'] = $years_of_project_fund_allocation[$id];																	
			$insert_data['allocation_of_project_fund'] = $allocation_of_project_funds[$id];
			$insert_data['year_of_DIPA_alocation'] = $years_of_DIPA_allocations[$id];
			$insert_data['allocation_of_DIPA_fund'] = $allocations_of_DIPA_fund[$id];
			if(!$schemas[$id]) {
			    continue;
			}
			if($updateIDs[$id]) {
			    $this->Master_model->simpan('Grantee', $insert_data, true, array('id' => $id));
			}
			else {
			    $this->Master_model->simpan('Grantee', $insert_data, false);
			}
			// simpan data schema
			if (isset($schemas[$value]) && $schemas[$value]) {
			  foreach ($schemas[$value] as $schema) {
				$insert_data2['grantee_id'] = $value;
				$insert_data2['schema_id'] = $schema;
				$this->db->delete('GranteeSchema', array('grantee_id' => $insert_data2['grantee_id']));
				$this->db->insert('GranteeSchema', $insert_data2);
			  }
			}
		  }
		}
		$this->session->set_flashdata('pesan_simpan', 'Data grantee telah disimpan');
		redirect('master/index/grantee');
	  }
	  else if ($type == 'procurement_method') {
		$procurement_methods = $this->input->post('procurement_method');
		$kets = $this->input->post('description');
		$last_updates = $this->input->post('last_update');
		$updateIDs = $this->input->post('updateID');
		foreach ($procurement_methods as $id => $procurement_method) {
		  	$insert_data = array();
			if (trim($procurement_method) != '') {
		  		$insert_data['procurement_method'] = $procurement_methods[$id];
				$insert_data['description'] = $kets[$id];
				$insert_data['last_update'] = $last_updates[$id];
				if($updateIDs[$id]) {
				    $this->Master_model->simpan('ProcurementMethod', $insert_data, true, array('id' => $id));
				}
				else {
				    $this->Master_model->simpan('ProcurementMethod', $insert_data, false);   
				}
			}
		}
		$this->session->set_flashdata('pesan_simpan', 'Data Metode Procurement telah disimpan');
		redirect('master/index/procurement_method');
	  }	
	  else if ($type == 'schema') {
		$skema_pius = $this->input->post('schema_name');
		$ket_skemas = $this->input->post('description');
		$updateIDs = $this->input->post('updateID');
		foreach ($skema_pius as $id => $skema_piu) {
			$insert_data = array();
			if (trim($skema_piu) != '') { 
				$insert_data['schema_name'] = $skema_pius[$id];
				$insert_data['description'] = $ket_skemas[$id];
				if($updateIDs[$id]) {
				    $this->Master_model->simpan('Schema', $insert_data, true, array('id' => $id));
				}
				else {
				    $this->Master_model->simpan('Schema', $insert_data, false);
				}
 			}
		}
			
		$this->session->set_flashdata('pesan_simpan', 'Data Skema telah disimpan');
		redirect('master/index/schema');
	  }
	  else if ($type == 'source_of_fund') {
		$source_of_funds = $this->input->post('source_of_fund');
		$ket_sfund = $this->input->post('description');
		$updateIDs = $this->input->post('updateID');
		foreach ($source_of_funds as $id => $source_of_fund) {
			$insert_data = array();
			if (trim($source_of_fund) != '') {
				$insert_data['source_of_fund'] = $source_of_funds[$id];
				$insert_data['description'] = $ket_sfund[$id];
				if($updateIDs[$id]) {
				    $this->Master_model->simpan('SourceOfFund', $insert_data, true, array('id' => $id));
				}
				else {
				    $this->Master_model->simpan('SourceOfFund', $insert_data);
				}
				
			}
		}
		$this->session->set_flashdata('pesan_simpan', 'Data Source of Fund telah disimpan');
		redirect('master/index/source_of_fund');
	  }
	  else if ($type == 'financial_project_component') {
		$name_of_fpcs = $this->input->post('name_of_fpc');
		$source_of_funds = $this->input->post('source_of_fund');
		$parent_ids = $this->input->post('parent_id');
		$subjects = $this->input->post('subject');
		$codes = $this->input->post('code');
		$proc_or_nonprocs = $this->input->post('proc_or_nonproc');
		$grantee_types = $this->input->post('grantee_type');
		$updateIDs = $this->input->post('updateID');
		foreach($name_of_fpcs as $id => $name_of_fpc) {
			$insert_data = array();
			if (trim($name_of_fpc) != '') {
			$insert_data['name_of_fpc'] = $name_of_fpcs[$id];
			$insert_data['source_of_fund'] = $source_of_funds[$id];
			$insert_data['parent_id'] = $parent_ids[$id];
			$insert_data['subject'] = $subjects[$id];
			$insert_data['code'] = $codes[$id];
			$insert_data['proc_or_nonproc'] = $proc_or_nonprocs[$id];
			$insert_data['grantee_type'] = $grantee_types[$id];
            if ($updateIDs[$id]) {
			  $this->Master_model->simpan('FinancialProjComp', $insert_data, true, array('id' => $id));   
			} else {
			  $this->Master_model->simpan('FinancialProjComp', $insert_data);    
			}
		  }			
		}
		$this->session->set_flashdata('pesan_simpan', 'Data Proyek Komponen Keuangan telah disimpan');
		redirect('master/index/financial_project_component');
	  }
	  else if ($type == 'activity_package') {
		//$ids = $this->input->post('id');
		$package_names = $this->input->post('package_name');
		$parent_ids = $this->input->post('parent_id');
		$updateIDs = $this->input->post('updateID');
		foreach($package_names as $id => $value) {
		  $insert_data = array();
		  if (trim($value) != '') { 
			$insert_data['package_name'] = $package_names[$id];
			$insert_data['parent_id'] = $parent_ids[$id];
			if($updateIDs[$id]) {
			    $this->Master_model->simpan('ActivityPackage', $insert_data, true, array('id' => $id));
			}
			else {
			    $this->Master_model->simpan('ActivityPackage', $insert_data);
			}
			
		  }
		}
		$this->session->set_flashdata('pesan_simpan', 'Data Proyek Komponen Keuangan telah disimpan');
		redirect('master/index/activity_package');
	  }
	  else if ($type == 'status') {
		$statuses = $this->input->post('status');
		$descriptions = $this->input->post('description');
		$weights = $this->input->post('progress_weight');
		$procs_or_nonprocs = $this->input->post('proc_or_nonproc');
		$updateIDs = $this->input->post('updateID');
		foreach($statuses as $id => $status) {
		  $insert_data = array();
		  if (trim($status) != '') {
		    $insert_data['status'] = $statuses[$id];
		    $insert_data['description'] = $descriptions[$id];
		    $insert_data['progress_weight'] = $weights[$id];
		    $insert_data['proc_or_nonproc'] = $procs_or_nonprocs[$id];
		    if($updateIDs[$id]) {
			$this->Master_model->simpan('Status', $insert_data, true, array('id' => $id));
		    }
		    else {
			$this->Master_model->simpan('Status', $insert_data);
		    }
		    
		  }
		}
		$this->session->set_flashdata('pesan_simpan', 'Data Status telah disimpan');
		redirect('master/index/status');
	  }
	  else if ($type == 'quartal') {
		$quartals = $this->input->post('quartal');
		$descriptions = $this->input->post('description');
		$updateIDs = $this->input->post('updateID');
		foreach($quartals as $id => $quartal) {
		    $insert_data = array();
		    if (trim($quartal) !='') {
		    $insert_data['quartal'] = $quartals[$id];
		    $insert_data['description'] = $descriptions[$id];
		    if($updateIDs[$id]) {
			$this->Master_model->simpan('Quartal', $insert_data, true, array('id' => $id));
		    }
		    else {
			$this->Master_model->simpan('Quartal', $insert_data, false);
	    	    }	  
		}
	    }
		$this->session->set_flashdata('pesan_simpan', 'Data Quartal telah disimpan');
		redirect('master/index/quartal');
	  }
	  else if ($type == 'users') {
		$names = $this->input->post('realname');
		$usernames = $this->input->post('username');
		$passwords = $this->input->post('passwd');
		$groups = $this->input->post('groups');
		$grantee_ids = $this->input->post('grantee_id');
		$updateIDs = $this->input->post('updateID');
		foreach($names as $id => $name) {
		    $insert_data = array();
		    if(trim($names[$id]) !='') {
		    $insert_data['realname'] = $names[$id];
		    $insert_data['username'] = $usernames[$id];
		    $insert_data['passwd'] = hash('SHA1',$passwords[$id]);
		    $insert_data['groups'] = $groups[$id];
		    $insert_data['grantee_id'] = $grantee_ids[$id];
		    if(!$insert_data['grantee_id']) {
			continue;
		    }
		    if($updateIDs[$id]) {
			if(trim($passwords[$id]) =='' ){
			    unset($insert_data['passwd']);
			}
			$this->Master_model->simpan('Users', $insert_data, true, array('id' => $id));
		    }
		    else {
			$this->Master_model->simpan('Users', $insert_data, false);
		    }
		}
	    }
		$this->session->set_flashdata('pesan_simpan', 'Data User telah disimpan');
		redirect('master/index/users');
	  }
	  
	  else if($type == 'loan_proceeds') {
		$ids = $this->input->post('id');
		$values = $this->input->post('item');
		$source_of_funds = $this->input->post('source_of_fund');
		$schema_codes = $this->input->post('schema_codes');
		$updateIDs = $this->input->post('updateID');
		foreach($values as $id => $id) {
		    $insert_data = array();
		    if(trim($values[$id]) != '') {
			$insert_data['item'] = $values[$id];
			$insert_data['source_of_fund'] = $values[$id];
			$insert_data['schema_code'] = $values[$id];
			if($updateIDs[$id]) {
			    $this->Master_model->simpan('LoanProceeds', $insert_data, true, array('id' => $id));
			}
			else {
			    $this->Master_model->simpan('LoanProceeds', $insert_data, false);
			}
		    }
		}
		$this->session->set_flashdata('pesan_simpan', 'Data Loan telah disimpan');
		redirect('master/index/loan_proceeds');
	  }
	  
	}
	
	/**
	 * Hapus data Master Data
	 */
	public function hapus($type)
	{
       if ($type == 'contractor') {
        $data_to_delete = $this->input->post('chbox');
        if ($data_to_delete) {
          foreach ($data_to_delete as $id => $data) {
            $this->db->delete('Contractor', array('id' => $id));
          }
          $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
          exit('Data telah dihapus');
	    }
	}
	else if($type == 'grantee') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('Grantee', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'procurement_method') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('ProcurementMethod', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'schema') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('Schema', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'source_of_fund') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('SourceOfFund', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'financial_project_component') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('FinancialProjComp', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'activity_package') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('ActivityPackage', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'status') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('Status', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if($type == 'quartal') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('Quartal', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
	else if ($type == 'users') {
	    $data_to_delete = $this->input->post('chbox');
	    if($data_to_delete) {
		foreach($data_to_delete as $id => $data) {
		    $this->db->delete('Users', array('id' => $id));
		}
		$this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	    }
	}
    }
}


