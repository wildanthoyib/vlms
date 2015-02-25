<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Realization extends CI_Controller {
    //var $config;
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
	  $this->load->model('Realization_model');
	  $this->load->model('Master_model');
	}
    
	public function ajax()
	{
	  $keywords = $this->input->get('keywords');
	  $impl_type = $this->input->get('impl_type');
	  if ($impl_type == 'Non-Proc') {
		$this->load->model('Non_proc_model');
		$criteria = 'NonProcurementPlan.grantee_id = \''.$this->data['user_data']['grantee_id'].'\'';
		$criteria .= ' AND package_id LIKE \'%'.$keywords.'%\' AND (contractor <> \'\' AND contract_no <> \'\')';
        // $result = $this->Non_proc_model->getData($criteria);
        $result = $this->Non_proc_model->getImplementationData($criteria);
		$data = array();
		foreach ($result as $row) {
		  $data[] = array('id' => $row->plan_id, 'text' => $row->package_id.' - '.$row->contractor.' - '.$row->contract_no);
		}
		echo json_encode($data);
		exit();
	  } else {
		$this->load->model('Proc_model');
		$criteria = 'ProcurementPlan.grantee_id = \''.$this->data['user_data']['grantee_id'].'\'';
		$criteria .= ' AND package_id LIKE \'%'.$keywords.'%\' AND (contractor_id > 0 AND contract_no <> \'\')';
        // $result = $this->Proc_model->getData($criteria);
        $result = $this->Proc_model->getImplementationData($criteria);
		$data = array();
		foreach ($result as $row) {
		  $data[] = array('id' => $row->plan_id, 'text' => $row->package_id.' - '.$row->name_of_contractor.' - '.$row->contract_no);
		}
		echo json_encode($data);
		exit();
	  }
	}
	
	/**
	 * Browser data Financial Realization
	 */
	public function index()
	{
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		$criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
	  } else {
		$criteria = null;
	  }
	  $this->data['list_proposal'] = $this->Master_model->getMasterData('Proposal', 1000, $criteria);
	  $this->data['records'] = $this->Realization_model->getData($criteria);
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
		$this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  $this->load->view('realization/browse', $this->data);
	}

	/**
	 * Add data Financial Realization
	 */
	public function add()
	{
	  $this->load->model('Proc_model');
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		$criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
	  } else {
		$criteria = null;
	  }
	  // $criteria['approval'] = 2;
	  $this->data['list_proposal'] = $this->Master_model->getMasterData('Proposal', 1000, $criteria);
	  $this->data['list_impl'] = $this->Proc_model->getImplementationData();
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
		$this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  $this->load->view('realization/add', $this->data);
	}
	
	public function detail($realization_id)
	{
	  $this->load->model('Proc_model');
	  $criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
	  $realization_criteria['realization_id'] = $realization_id;
	  $this->data['records'] = $this->Realization_model->getImplementationDetail($realization_criteria);
	  $this->data['realization'] = $this->Realization_model->getDetail($realization_id);
	  $this->data['realization_id'] = $realization_id;
	  $this->load->view('realization/detail', $this->data);		
	}
	
	public function hapus($type = '')
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($type == 'detail') {
	    if ($data_to_delete) {
	    foreach ($data_to_delete as $id => $data) {
	      $this->db->delete('FinancialRealDetail', array('id' => $id));
	    }
        $this->session->set_userdata('data_terhapus', 'Data detail telah dihapus');
	    exit('Data telah dihapus');
	    }		
	  } else {
	    if ($data_to_delete) {
	    foreach ($data_to_delete as $id => $data) {
	      $this->db->delete('FinancialReal', array('id' => $id));
	      $this->db->delete('FinancialRealDetail', array('realization_id' => $id));
	    }
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
	    exit('Data telah dihapus');
	    }
	  }
	}
	
	/**
	 * Simpan data Financial Realization
	 */
	public function simpan()
	{
      $upload_config['upload_path'] = './files/financial/';
      //$upload_config['full_path'] = './files/financial/pdf.pdf';
      $upload_config['allowed_types'] = 'pdf|doc|docx';
      $upload_config['file_ext'] = '.pdf' ;
      $upload_config['max_size'] = '20000KB';
      $upload_config['max_width'] = '1024';
      $upload_config['max_height'] = '768';
      $this->load->library('upload', $upload_config);
	  
	  $proposal_ids = $this->input->post('proposal_id');
	  $grantee_ids = $this->input->post('grantee_id');
	  $sp2d_numbers = $this->input->post('sp2d_number');
	  $sp2d_dates = $this->input->post('sp2d_date');
	  $impl_details = $this->input->post('impl_detail');
	  $kurs_dollars = str_replace(array('.'), '', $this->input->post('kurs_dollar'));
	  $ket_sp2ds = $this->input->post('ket_sp2d');
	  $updateIDs = $this->input->post('updateID');
	  
	  $realizationID = $this->input->post('realizationID');
	  if (!$realizationID) {
	    foreach ($sp2d_numbers as $r => $sp2d) {
	    $insert_data = array();
	    if (trim($sp2d) != '') {
	      $insert_data['proposal_id'] = $proposal_ids[$r];
	      $insert_data['sp2d_number'] = $sp2d_numbers[$r];
	      $insert_data['sp2d_date'] = date('Y-m-d', strtotime($sp2d_dates[$r]));
	      if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		    $insert_data['grantee_id'] = $this->data['user_data']['grantee_id'];
	      } else {
		    $insert_data['grantee_id'] = $grantee_ids[$r];
	      }
	      
	      $insert_data['kurs_dollar'] = str_replace('.', '', $kurs_dollars[$r]);
	      $insert_data['ket_sp2d'] = $ket_sp2ds[$r];
	      if (isset($_FILES['upload_sp2d_batch'])) {
		  // echo '<pre>'; print_r($_FILES); echo '</pre>';die();	
		  // echo '<pre>'; print_r($_FILES['upload_sp2d']); echo '</pre>'; die();	
		    foreach ($_FILES['upload_sp2d_batch'] as $field => $file) {
		      foreach ($file as $id => $name) {
				if ($updateIDs[$r] == $id) {
				  $upload = move_uploaded_file($_FILES['upload_sp2d_batch']['tmp_name'][$updateIDs[$r]], $upload_config['upload_path'].'/'.$name);
				  if ($upload) {
				    $insert_data['file'] = $name;
				  }	
				}
		      }
		    }
	      } else {
		    $upload = $this->upload->do_upload('upload_sp2d');
		    if (!$upload) {
		      $this->session->set_flashdata('upload_error', $this->upload->display_errors());
		    }
		    else {
		      $upload_data = $this->upload->data();
		      $insert_data['file'] = $upload_data['file_name'];
		    }
	      }
	      
	      
	      if (!$upload) {
	    	$this->session->set_flashdata('upload_error', $this->upload->display_errors());
	      } else {
	    	$upload_data = $this->upload->data();
	    	$insert_data['file'] = $upload_data['file_name'];
	      }
	      if (isset($updateIDs[$r])) {
	        $criteria['id'] = $updateIDs[$r];
	        $realization_id = $updateIDs[$r];
	        $this->Realization_model->simpan($insert_data, true, $criteria);
	      } else {
	        $realization_id = 0;
	        $this->Realization_model->simpan($insert_data, false, null, $realization_id);
	      }
	    }
	    }
	  }
	  
	  $impl_detail_updateIDs = $this->input->post('impl_detail_updateID');
	  // proses simpan detail SP2D
	  if ($impl_details) {
		// echo '<pre>'; print_r($impl_details); echo '</pre>'; die();
	    foreach ($impl_details['impl_detail_id'] as $n => $impl_detail) {
		  //die($impl_detail);
		  if (empty($impl_detail)) {
			continue;
		  }
	      $impl_detail_insert_data['realization_id'] = $realizationID?$realizationID:$realization_id;
	      $impl_detail_insert_data['impl_detail_id'] = $impl_detail;
	      $impl_detail_insert_data['impl_type'] = $impl_details['impl_type'][$n];
	      // $impl_detail_insert_data['recipient'] = $impl_details['recipient'][$n];
	      $impl_detail_insert_data['notes'] = $impl_details['notes'][$n];
	      $impl_detail_insert_data['value'] = str_replace('.', '', $impl_details['value'][$n]);
		  
		  if ($impl_detail_updateIDs[$n] === $n) {
			unset($impl_detail_insert_data['impl_detail_id'], $impl_detail_insert_data['impl_type'], $impl_detail_insert_data['realization_id']);
			$this->Realization_model->simpan_detail($impl_detail_insert_data, true, array('id' => $impl_detail_updateIDs[$n]));
		  } else {
			$this->Realization_model->simpan_detail($impl_detail_insert_data);
		  }
	      
	    }
	  }
	  if ($realizationID) {
	    $this->session->set_flashdata('pesan_simpan', 'Data sudah disimpan!');
        redirect('/realization/detail/'.$realizationID);		
	  }
	  
	  $this->session->set_flashdata('pesan_simpan', 'Data sudah disimpan!');
      redirect('/realization/index');
	}
}
