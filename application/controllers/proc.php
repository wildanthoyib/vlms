<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Proc extends CI_Controller {
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
	  $this->load->model('Proc_model');
	  $this->load->model('Master_model');
	  $this->load->model('Rpp_model');
	}

	/**
	 * Browser data procurement plan
	 */
	public function plan($page = 1)
	{
	  $keywords = $this->input->get('keywords');
	  $search_grantee = $this->input->get('search_grantee');
	  $total_rows = 0;
	  $this->load->model('Rpp_model');
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		// $criteria['grantee_id'] = $this->data['user_data']['piu_id']; dorrr dorr dorr -->piu_id is changed to be grantee_id permanently 
		$criteria = sprintf('grantee_id=\'%s\'', $this->data['user_data']['grantee_id']);
	  } else {
		if ($search_grantee) {
		  $criteria = sprintf('grantee_id=\'%s\'', $search_grantee);
		} else {
		  $criteria = null;	
		}
	  }
	  if ($keywords) {
		if ($criteria) {
		  $criteria .= ' AND ';
		}
		$criteria .= sprintf('contract LIKE \'%%%s%%\'', $keywords);
	  }
	  $this->data['records'] = $this->Rpp_model->getData($criteria, $page, 20, $total_rows);
	  $this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
		$this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  $this->load->view('proc/plan', $this->data);
	}

	public function detail($proposal_id, $page = 1)
	{
	  $this->load->model('Rpp_model');
	  $this->data['proposal_id'] = $proposal_id;
	  $this->data['proposal_detail'] = $this->Rpp_model->getDetail(array('Proposal.id' => $proposal_id));
	  $this->data['list_proc_method'] = $this->Master_model->getMasterData('ProcurementMethod', 20);
	  $this->data['list_sof'] = $this->Master_model->getMasterData('SourceOfFund', 20);
	  $this->data['list_proposal_detail'] = $this->Rpp_model->getRppPlanDetailCompl($proposal_id, 'Proc', 1, 200);
	  // set kriteria untuk detil plan
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
	    $plan_criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
	  }
	  $plan_criteria['rpp_id'] = $proposal_id;
	  $this->data['records'] = $this->Proc_model->getPlanDetail($plan_criteria, 1, 200);
	  $this->load->view('proc/plan_detail', $this->data);
	}

	public function impl($page = 1)
	{
	  $keywords = $this->input->get('keywords');
	  $search_grantee = $this->input->get('search_grantee');
	  $total_rows = 0;
	  $this->load->model('Rpp_model');
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		// $criteria['grantee_id'] = $this->data['user_data']['piu_id'];
		$criteria = sprintf('grantee_id=\'%s\'', $this->data['user_data']['grantee_id']);
	  } else {
		if ($search_grantee) {
		  $criteria = sprintf('grantee_id=\'%s\'', $search_grantee);
		} else {
		  $criteria = null;	
		}
	  }
	  if ($keywords) {
		if ($criteria) {
		  $criteria .= ' AND ';
		}
		$criteria .= sprintf('contract LIKE \'%%%s%%\'', $keywords);
	  }
	  $this->data['records'] = $this->Rpp_model->getData($criteria, $page, 20, $total_rows);
	  $this->data['total_rows'] = $total_rows;
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups']) {
		$this->data['list_pid'] = $this->Master_model->getMasterData('Grantee', 100);
	  }
	  $this->load->view('proc/implementation', $this->data);
	}

	public function impl_detail($proposal_id)
	{
	  // set kriteria untuk detail implementasi
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
	    $impl_criteria['ProcurementPlan.grantee_id'] = $this->data['user_data']['grantee_id'];
	  }
	  $impl_criteria['ProcurementPlan.rpp_id'] = $proposal_id;
	  $this->data['proposal_detail'] = $this->Rpp_model->getDetail(array('Proposal.id' => $proposal_id));
	  $this->data['list_contractor'] = $this->Master_model->getMasterData('Contractor');
	  $this->data['list_status'] = $this->Master_model->getMasterData('Status', 100, "proc_or_nonproc='Proc' OR status  ='Kontrak'");
	  $this->data['records'] = $this->Proc_model->getImplementationData($impl_criteria);
	  $this->load->view('proc/implementation_detail', $this->data);
	}
	
	public function progress_detail($proposal_detail_id)
	{
	  sleep(1);
	  $this->data['list_contractor'] = $this->Master_model->getMasterData('Contractor');
	  $this->data['list_status'] = $this->Master_model->getMasterData('Status', 100, "proc_or_nonproc='Proc' OR status  ='Kontrak'");
	  $impl_criteria['ProposalDetail.id'] = $proposal_detail_id;
	  $impl_data = $this->Proc_model->getImplementationData($impl_criteria);
	  $this->data['rec'] = $impl_data[0];
	  $this->load->view('proc/progress_detail', $this->data);
	}

	public function hapus_detail()
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($data_to_delete) {
		foreach ($data_to_delete as $id => $data) {
		  $this->db->delete('ProcurementPlan', array('id' => $id));
		  // hapus record terkait di table lain
		  $this->db->delete('ProcurementImp', array('proc_id' => $id));
		  $this->db->delete('ProcProgressDetail', array('proc_id' => $id, 'impl_type' => 'Proc'));
		  $this->db->delete('FinancialRealDetail', array('impl_detail_id' => $id, 'impl_type' => 'Proc'));
		}
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	  }
	}
    
	/**
	 * Proses simpan progress detail
	 */
	public function simpan_progress($proc_id)
	{
	  $prog_ids = $this->input->post('prog_id');
	  $prog_dates = $this->input->post('prog_date');
	  $descriptions = $this->input->post('description');
	  foreach ($prog_ids as $id => $prog) {
		$insert_data['proc_id'] = $proc_id;
		$insert_data['impl_type'] = 'Proc';
		$insert_data['prog_id'] = $prog;
		$insert_data['prog_date'] = date('Y-m-d', strtotime($prog_dates[$id]));
		$insert_data['description'] = $descriptions[$id];
		$insert_data['created_at'] = date('Y-m-d');
		
		if (!$insert_data['prog_date']) {
		  break;
		}
		$this->db->insert('ProcProgressDetail', $insert_data);
		// update juga data proc
		$update_data['estimated_prog'] = $prog;
		$contract_no = $this->input->post('contract_no');
		$contractor_id = $this->input->post('contractor_id');
		if ($contract_no && $contractor_id) {
		  $update_data['contractor_id'] = $this->input->post('contractor_id');
		  $update_data['contract_no'] = $this->input->post('contract_no');
		  $update_data['contract_date'] = date('Y-m-d', strtotime($this->input->post('contract_date')));
		  $update_data['contract_duration'] = $this->input->post('contract_duration');
		  $update_data['contract_value'] = str_replace('.', '', $this->input->post('contract_value'));
		  $update_data['refund'] = str_replace('.', '', $this->input->post('refund'));
		} else if ($insert_data['prog_id'] < 20) {
		  $update_data['contractor_id'] = '';
		  $update_data['contract_no'] = '';
		  $update_data['contract_date'] = '';
		  $update_data['contract_duration'] = '';
		  $update_data['contract_value'] = 0;			
		  $update_data['refund'] = 0;			
		}

		$this->db->update('ProcurementImp', $update_data, array('proc_id' => $proc_id));
	  }
	}
	
	public function hapus_progress()
	{
	  $progid = $this->input->post('progid');
	  list($impl_type, $proc_id, $prog_id) = explode(':', $progid);
	  $where['impl_type'] = $impl_type;
	  $where['proc_id'] = $proc_id;
	  $where['prog_id'] = $prog_id;
	  $this->db->delete('ProcProgressDetail', $where);
	  exit();
	}

	/**
	 * Proses simpan data procurement plan dari form
	 */
	public function simpan($tipe = '')
	{
	  if ($tipe == 'impl') {
		$rpp_id = $this->input->post('rpp_id');
		$grantee_id = $this->data['user_data']['grantee_id'];
		if ('pmu' == $this->data['user_data']['groups'] && 'admin' == $this->data['user_data']['groups']) {
		  // ambil detail RPP dan ambil grantee id
		  $rpp_detail = $this->Rpp_model->getDetail($rpp_id);
		  $grantee_id = $rpp_detail->grantee_id;
		}
		$contractor_ids = $this->input->post('contractor_id');
		$contract_nos = $this->input->post('contract_no');
		$contract_dates = $this->input->post('contract_date');
		$contract_durations = $this->input->post('contract_duration');
		$contract_values = $this->input->post('contract_value');
		$estimated_progs = $this->input->post('estimated_prog');
		foreach ($contract_values as $proc_id => $val) {
		  if (is_numeric($val) && $val > 0) {
			$insert_data['proc_id'] = $proc_id;
			$insert_data['contractor_id'] = $contractor_ids[$proc_id];
			$insert_data['grantee_id'] = $grantee_id;
			$insert_data['contract_no'] = $contract_nos[$proc_id];
			$insert_data['contract_date'] = date('Y-m-d', strtotime($contract_dates[$proc_id]));
			$insert_data['contract_duration'] = $contract_durations[$proc_id];
			$insert_data['contract_value'] = str_replace('.', '', $contract_values[$proc_id]);
			$insert_data['estimated_prog'] = $estimated_progs[$proc_id];

			$this->Proc_model->simpan_impl($insert_data);
		  } 
		}
		$this->session->set_flashdata('pesan_simpan', 'Data detail pelaksanaan procurement berhasil disimpan');
		redirect('/proc/impl_detail/'.$rpp_id);
	  } else if ($tipe == 'detail') {
		$this->load->model('Rpp_model');
		$rpp_id = $this->input->post('rpp_id');
		$grantee_id = $this->data['user_data']['grantee_id'];
		if ('pmu' == $this->data['user_data']['groups'] && 'admin' == $this->data['user_data']['groups']) {
		  // ambil detail RPP dan ambil grantee id
		  $rpp_detail = $this->Rpp_model->getDetail($rpp_id);
		  $grantee_id = $rpp_detail->grantee_id;
		}
		$proposal_detail_ids = $this->input->post('proposal_detail_id');
		$descriptions = $this->input->post('description');
		$proc_dates = $this->input->post('proc_date');
		$proc_methods = $this->input->post('proc_method');
		$prior_or_posts = $this->input->post('prior_or_post');
		$estimated_costs = $this->input->post('estimated_cost');
		$plan_q1s = $this->input->post('plan_q1');
		$plan_q2s = $this->input->post('plan_q2');
		$plan_q3s = $this->input->post('plan_q3');
		$plan_q4s = $this->input->post('plan_q4');
		$plan_q1_values = $this->input->post('plan_q1_value');
		$plan_q2_values = $this->input->post('plan_q2_value');
		$plan_q3_values = $this->input->post('plan_q3_value');
		$plan_q4_values = $this->input->post('plan_q4_value');
		$updateIDs = $this->input->post('updateID');
		$error_melebihi_pagu = array();
		foreach ($estimated_costs as $r => $estimated_cost) {
		  $estimated_cost = str_replace('.', '', $estimated_cost);
		  if ($estimated_cost > 0 && is_numeric($estimated_cost)) {
			$insert_data['rpp_id'] = $rpp_id;
			$insert_data['proposal_detail_id'] = $proposal_detail_ids[$r];
			$insert_data['grantee_id'] = $grantee_id;
			$insert_data['description'] = $descriptions[$r];
			$insert_data['proc_date'] = date('Y-m-d', strtotime($proc_dates[$r]));
			$insert_data['proc_method'] = $proc_methods[$r];
			$insert_data['prior_or_post'] = $prior_or_posts[$r];
			$insert_data['estimated_cost'] = str_replace('.', '', $estimated_costs[$r]);
			$insert_data['plan_q1'] = (integer)$plan_q1s[$r];
			$insert_data['plan_q2'] = (integer)$plan_q2s[$r];
			$insert_data['plan_q3'] = (integer)$plan_q3s[$r];
			$insert_data['plan_q4'] = (integer)$plan_q4s[$r];
			$insert_data['plan_q1_value'] = str_replace('.', '', $plan_q1_values[$r]);
			$insert_data['plan_q2_value'] = str_replace('.', '', $plan_q2_values[$r]);
			$insert_data['plan_q3_value'] = str_replace('.', '', $plan_q3_values[$r]);
			$insert_data['plan_q4_value'] = str_replace('.', '', $plan_q4_values[$r]);
			$lebih_dari_pagu = $this->cek_apakah_melebihi_pagu($rpp_id, $insert_data['proposal_detail_id'], $insert_data['estimated_cost']);
			if ($lebih_dari_pagu > 0) {
			  $error_melebihi_pagu[] = 'Biaya pada '.number_format($insert_data['estimated_cost'], 0, '', '.').' <strong>'.$insert_data['description'].'</strong> melebihi pagu yang ditentukan.
			   Nilai disesuaikan dengan pagu maksimal '.number_format($lebih_dari_pagu, 0, '', '.');
			  $insert_data['estimated_cost'] = $lebih_dari_pagu;
			}
			if (isset($updateIDs[$r])) {
			  $this->Proc_model->simpan($insert_data, true, array('id' => $updateIDs[$r]));
			} else {
			  $insert_id = 0;
			  $this->Proc_model->simpan($insert_data, false, false, $insert_id);
			  $this->db->insert('ProcurementImp', array('proc_id' => $insert_id, 'grantee_id' => $grantee_id));
			}
			$this->session->set_flashdata('pesan_simpan', 'Data detail perencanaan berhasil disimpan');
		    }
		    else {
			$this->session->set_flashdata('error_simpan', 'Nilai prakiraan harus diisi dengan benar');
			redirect('/proc/detail/'.$rpp_id); return;
		  }
		}
		if($error_melebihi_pagu) {
		    $this->session->set_flashdata('error_melebihi_pagu', json_encode($error_melebihi_pagu));    
		}
		redirect('/proc/detail/'.$rpp_id);
	  }
	}
	
	private function cek_apakah_melebihi_pagu($proposal_id, $proposal_detail_id, $value) {
	  $list_proposal_detail = $this->Rpp_model->getRppPlanDetailCompl($proposal_id, 'Proc', 1, 200);
	  foreach ($list_proposal_detail as $proposal_detail) {
		if ($proposal_detail_id == $proposal_detail->id) {
		  if ($value > $proposal_detail->value) {
			return $proposal_detail->value;
		  } else {
			return false;
		  }
		}
		continue;
	  }
      return true;
	}
}
