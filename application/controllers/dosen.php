<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Dosen extends CI_Controller {
    private $data = array();


	public function __construct()
	{
	  parent::__construct();
	  $this->data['main_content'] = '';
	  $this->data['user_data'] = $this->session->userdata('is_logged_in');
	  /*
	  if (!$this->data['user_data']) {
		redirect('/login');
		return;
	  }
	  */
	  $this->load->model('mahasiswa_model');
	  $this->load->model('dosen_model');
	  $this->load->model('Master_model');
	}
    
	/**
	 * Browser data RPP
	 */
	public function index($page = 1)
	{
	  
	  $keywords = $this->input->get('keywords');
	  $filter = '';
	  $total_rows = 0;
	  $this->load->library('pagination');
	  //pagination settings
	  $config['per_page'] = 100;
	  $config['base_url'] = site_url('/rpp/index/');
	  $config['use_page_numbers'] = TRUE;
	  $config['num_links'] = 100;
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
	  
	  $search_grantee = $this->input->get('search_grantee');
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		// $criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
		$criteria = sprintf('grantee_id=\'%s\'', $this->data['user_data']['grantee_id']);
	  } else {
		if ($search_grantee) {
		  $criteria = sprintf('grantee_id=\'%s\'', $search_grantee);
		} else {
		  $criteria = null;	
		}
	  }
	  /*if ($keywords) {
	    $keywords = $this->db->escape('%'.$keywords.'%');
	    $filter = "contract LIKE $keywords OR year LIKE $keywords";
	  }*/
	  if ($keywords) {
		if ($criteria) {
		  $criteria .= ' AND ';
		}
		$criteria .= sprintf('contract LIKE \'%%%s%%\'', $keywords);
	  }
	  
	  $this->data['records'] = $this->Rpp_model->getData($criteria, $page, $config['per_page'], $total_rows, $filter);
	  
	  $this->data['pagination'] = $this->pagination->create_links();
	  $this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
	  $this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  $this->load->view('rpp/browse', $this->data);
	}
	
	/**
	 * Aktivitas Dosen
	*/
	public function aktivitas(){
		//$this->data['records'] = $this->Rpp_model->getData($criteria, $page, $config['per_page'], $total_rows, $filter);
	  
	  //$this->data['pagination'] = $this->pagination->create_links();
	  //$this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
	  $this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  
	  $this->data['records'] = $this->dosen_model->getDosenAktivitas();
	  //print_r($this->data['records']);
		$this->load->view('dosen/aktivitas',$this->data);
	}

	/**
	 * Penelitan Dosen
	*/
	public function penelitian(){
		//$this->data['records'] = $this->Rpp_model->getData($criteria, $page, $config['per_page'], $total_rows, $filter);
	  
	  //$this->data['pagination'] = $this->pagination->create_links();
	  //$this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
	  $this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  
	  $this->data['records'] = $this->mahasiswa_model->getMahasiswaProfil();
	  //print_r($this->data['records']);
		$this->load->view('dosen/penelitian',$this->data);
	}
	
	/**
	 * Nilai Mahasiswa
	*/
	public function nilai(){
		//$this->data['records'] = $this->Rpp_model->getData($criteria, $page, $config['per_page'], $total_rows, $filter);
	  
	  //$this->data['pagination'] = $this->pagination->create_links();
	  //$this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
	  $this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  
	  $this->data['records'] = $this->mahasiswa_model->getMahasiswaProfil();
	  //print_r($this->data['records']);
		$this->load->view('mahasiswa/nilai',$this->data);
	}
	
	/**
	 * Status Mahasiswa
	*/
	public function status(){
		//$this->data['records'] = $this->Rpp_model->getData($criteria, $page, $config['per_page'], $total_rows, $filter);
	  
	  //$this->data['pagination'] = $this->pagination->create_links();
	  //$this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
	  $this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  
	  $this->data['records'] = $this->mahasiswa_model->getMahasiswaProfil();
	  //print_r($this->data['records']);
		$this->load->view('mahasiswa/status',$this->data);
	}
	
	/**
	 * Add data RPP
	 */
	public function add()
	{
	  $this->data['list_component'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, 'parent_id is null');
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
		$this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  $this->load->view('rpp/add', $this->data);
	}

	/**
	 * Add data RPP
	 */
	public function upload()
	{
	  $this->load->view('rpp/upload', $this->data);
	}

	/**
	 * Approval data RPP
	 */
	public function approval()
	{
	  $this->data['records'] = $this->Rpp_model->getData();
	  $this->load->view('rpp/approval', $this->data);
	}
	
	public function hapus()
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($data_to_delete) {
		foreach ($data_to_delete as $id => $data) {
		  $this->db->delete('Proposal', array('id' => $id));
		  $this->db->delete('ProposalDetail', array('proposal_id' => $id));
		}
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	  }
	}

	public function hapus_detail()
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($data_to_delete) {
		foreach ($data_to_delete as $id => $data) {
		  $this->db->delete('ProposalDetail', array('id' => $id));
		}
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	  }
	}
	
	/**
	 * Add data detail DIPA untuk RPP
	 */
	public function detail($id, $page = 1)
	{
	  $keywords = $this->input->get('keywords');
	  $filter = '';
	  $total_rows = 0;
	  $this->load->library('pagination');
	  //pagination settings
	  $config['per_page'] = 100;
	  $config['base_url'] = site_url('/rpp/detail/'.$id);
	  $config['use_page_numbers'] = TRUE;
	  $config['num_links'] = 100;
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
		
	  $this->data['list_fund'] = $this->Master_model->getMasterData('SourceOfFund', 1000);
	  // $this->data['list_activity'] = $this->Master_model->getMasterData('ActivityPackage', 1000);
	  $schema = $this->session->userdata('schema');
	  $filter_proc = "proc_or_nonproc = 'Proc'";
	  $filter_non_proc = "proc_or_nonproc = 'Non-Proc'";
	  $schema_string = '';
	  if ($schema) {
	    foreach ($schema as $schema_data) {
	      $schema_string .= ','.$schema_data['id'];
	    }
	    // remove first comma
	    $schema_string = substr_replace($schema_string, '', 0, 1);
	    $filter_proc .= ' AND subject IN ('.$schema_string.')';
	    $filter_non_proc .= ' AND subject IN ('.$schema_string.')';
	  }
	  if($keywords) {
	    $keywords = $this->db->escape('%'.$keywords.'%');
	    $filter = "package_id LIKE $keywords OR note LIKE $keywords";
	  }
	  // $this->data['list_component_proc'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, $filter_proc);
	  $this->data['list_component_proc'] = $this->Master_model->getRecursiveFPC(null, $schema_string, null, 'Proc');
	  // $this->data['list_component_non_proc'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, $filter_non_proc);
	  $this->data['list_component_non_proc'] = $this->Master_model->getRecursiveFPC(null, $schema_string, null, 'Non-Proc');
	  $this->data['rpp'] = $this->Rpp_model->getDetail(array('Proposal.id' => $id));
	  $this->data['records'] = $this->Rpp_model->getRppPlanDetail($id, $page, $config['per_page'], $total_rows, $filter);
	  $this->data['total_rows'] = $total_rows;
	  $config['total_rows'] = $total_rows;
	  $this->pagination->initialize($config);
	  $this->data['pagination'] = $this->pagination->create_links();
	  $this->load->view('rpp/detail', $this->data);
	}

	/**
	 * Add data detail total per cost component
	 */	
	public function detail_rpp($id, $page = 1)
	{
	  $keywords = $this->input->get('keywords');
	  $filter = '';
	  $total_rows = 0;
	  $this->load->library('pagination');
	  //pagination settings
	  $config['per_page'] = 100;
	  $config['base_url'] = site_url('/rpp/index/');
	  $config['use_page_numbers'] = TRUE;
	  $config['num_links'] = 100;
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
	    
	  if($keywords) {
		$keywords = $this->db->escape('%'.$keywords.'%');
		$filter = "name_of_fpc LIKE $keywords OR value LIKE $keywords";
	  }

	  $schema = $this->session->userdata('schema');
	  $schema_string = '';
	  if ($schema) {
	    foreach ($schema as $schema_data) {
	      $schema_string .= ','.$schema_data['id'];
	    }
	    // remove first comma
	    $schema_string = substr_replace($schema_string, '', 0, 1);
	  }
	  
	  // $this->data['list_fund'] = $this->Master_model->getMasterData('SourceOfFund', 1000);
	  // $this->data['list_component_proc'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, $filter_proc);
	  $this->data['list_component_proc'] = $this->Master_model->getRecursiveFPC(null, $schema_string, null, 'Proc');
	  // $this->data['list_component_non_proc'] = $this->Master_model->getMasterData('FinancialProjComp', 1000, $filter_non_proc);
	  $this->data['list_component_non_proc'] = $this->Master_model->getRecursiveFPC(null, $schema_string, null, 'Non-Proc');
	  $this->data['rpp'] = $this->Rpp_model->getDetail(array('Proposal.id' => $id));
	  $this->data['records'] = $this->Rpp_model->getRppTotalDetail($id, $page, $config['per_page'], $total_rows, $filter);
	  $this->data['total_rows'] = $total_rows;
	  $this->pagination->initialize($config);
	  $this->data['pagination'] = $this->pagination->create_links();
	  $this->load->view('rpp/detail_rpp', $this->data);
	}
	
	/**
	 * Simpan data RPP
	 */
	public function simpan($type = '')
	{
	  if ($type == 'detail') {
	    $components = $this->input->post('component_id');
	    $packages = $this->input->post('package_id');
	    $values = $this->input->post('value');
	    $months = $this->input->post('month');
	    $notes = $this->input->post('note');
	    $source_of_funds = $this->input->post('source_of_fund');
	    $proposal_id = $this->input->post('proposal_id');
	    
	    $updateIDs = $this->input->post('updateID');
	    foreach ($packages as $r => $package) {
		  // die($proposal_id.' - '.$package);
	      $insert_data =  array();
	      if ($values[$r]) {
	    	// $insert_data['month'] = $months[$r];
	    	$insert_data['proposal_id'] = $proposal_id;
	    	$insert_data['package_id'] = $package;
	    	$insert_data['component_id'] = $components[$r];
		    $insert_data['note'] = $notes[$r];
		    $insert_data['source_of_fund'] = $source_of_funds[$r];
	    	$insert_data['value'] = str_replace('.', '', $values[$r]);
	    	if (isset($updateIDs[$r])) {
	    	  $this->Rpp_model->simpan_detail($insert_data, true, array('proposal_id' => $proposal_id, 'id' => $updateIDs[$r]));
	    	} else {
	    	  $this->Rpp_model->simpan_detail($insert_data, false, array('proposal_id' => $proposal_id));	
	    	}
	      }
	    }
	    
	    $this->session->set_flashdata('pesan_simpan', 'Data sudah disimpan!');
	    redirect('/rpp/detail/'.$proposal_id);
	    return;
	  } else {
	    $ids = $this->input->post('id');
	    $contracts = $this->input->post('contract');
	    $years = $this->input->post('year');
	    $adbs = $this->input->post('adb');
	    $gois = $this->input->post('goi');
	    $drks = $this->input->post('drk');
	    $cidas = $this->input->post('cida');
	    $grantee_ids = $this->input->post('grantee_id');
	    // $total_values = $this->input->post('total_value');
	    foreach ($contracts as $id => $rpp) {
	      $insert_data = array();
	    if (trim($contracts[$id]) != '') {
	      $insert_data['contract'] = $contracts[$id];
	      $insert_data['year'] = $years[$id];
	      $insert_data['grantee_id'] = $this->data['user_data']['grantee_id'];
		  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
			$insert_data['grantee_id'] = $grantee_ids[$id];
			echo $insert_data['grantee_id'];
			}
	      $insert_data['adb'] = (integer)str_replace('.', '', $adbs[$id]);
	      $insert_data['goi'] = (integer)str_replace('.', '', $gois[$id]);
	      $insert_data['drk'] = (integer)str_replace('.', '', $drks[$id]);
	      //$insert_data['cida'] = (integer)str_replace('.', '', $cidas[$id]);
	      $insert_data['total_value'] = $insert_data['adb']+$insert_data['goi']+$insert_data['drk'];
	      // echo $insert_data['adb'].'+'.$insert_data['goi'].'+'.$insert_data['drk'].'+'.$insert_data['adb']; echo '='.$insert_data['total_value'];
	      $insert_data['approval'] = 2;
	      if (isset($ids[$id])) {
	      $criteria['id'] = $ids[$id];
              $this->Rpp_model->simpan($insert_data, true, $criteria);
	      }
	      else {
		// Check apakah sudah ada data RPP untuk tahun dan grantee yang sama
	        $this->db->where(array('grantee_id' => $insert_data['grantee_id'], 'year' => $insert_data['year']));
	        $check = $this->db->get('Proposal');
	        if ($check->num_rows() > 0) {
	   	      $this->session->set_flashdata('check', 'RPP pada tahun '.$insert_data['year'].' yang sama sudah ada');
	   	      continue;
	        }
           	// die($insert_data['title']);
		  $this->Rpp_model->simpan($insert_data);	
          }
	   	  $this->session->set_flashdata('pesan_simpan', 'Data sudah disimpan!');
        }   else {
	   	  $this->session->set_flashdata('error_simpan', 'Kontrak atau RPP tidak boleh kosong dan nilai total anggaran tidak boleh diisi nilai kurang dari 1');
	   	  redirect('/rpp/index'); return;
	    }
        }
        redirect('/rpp/index');
	  }
	}
	
	public function simpan_detail_rpp()
	{
	  $components = $this->input->post('component_id');
	  $values = $this->input->post('value');
	  $proposal_id = $this->input->post('proposal_id');
	  $updateIDs = $this->input->post('updateID');
	  
	  foreach ($components as $r => $component) {
	    $insert_data =  array();
	    if ($values[$r]) {
	  	$insert_data['proposal_id'] = $proposal_id;
	  	$insert_data['component_id'] = $component;
	  	$insert_data['value'] = str_replace('.', '', $values[$r]);
	  	$insert_data['created_at'] = date('Y-m-d H:i:s');
	  	if (isset($updateIDs[$r])) {
	  	  $this->db->update('RppTotalDetail', $insert_data, array('proposal_id' => $proposal_id, 'id' => $updateIDs[$r]));
	  	} else {
	  	  $this->db->insert('RppTotalDetail', $insert_data);	
	  	}
	    }
	  }
	  $this->session->set_flashdata('pesan_simpan', 'Data sudah disimpan!');
	  redirect('/rpp/detail_rpp/'.$proposal_id);
	  return;
	}
	
	public function hapus_detail_rpp()
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($data_to_delete) {
		foreach ($data_to_delete as $id => $data) {
		  $this->db->delete('RppTotalDetail', array('id' => $id));
		}
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	  }
	  
	}
	
	public function hapus_detail_dipa()
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($data_to_delete) {
		foreach ($data_to_delete as $id => $data) {
		  $this->db->delete('ProposalDetail', array('id' => $id));
		}
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	  }
	}
    }

