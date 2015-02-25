<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Non_proc extends CI_Controller {
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
	  $this->load->model('Non_proc_model');
	  $this->load->model('Master_model');
	}

	/**
	 * Browser data non procurement plan
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
	  $this->load->view('non_proc/plan', $this->data);
	}

	public function detail($proposal_id, $page = 1)
	{
      $this->load->model('Rpp_model');
	  $this->data['proposal_id'] = $proposal_id;
	  $this->data['proposal_detail'] = $this->Rpp_model->getDetail(array('Proposal.id' => $proposal_id));
	  $this->data['list_proposal_detail'] = $this->Rpp_model->getRppPlanDetailCompl($proposal_id, 'Non-Proc', 1, 200);
      $this->data['list_sof'] = $this->Master_model->getMasterData('SourceOfFund', 20);
	  // set kriteria untuk detil plan
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
	    $plan_criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
	  }
	  $plan_criteria['rpp_id'] = $proposal_id;
	  $this->data['records'] = $this->Non_proc_model->getPlanDetail($plan_criteria, 1, 200);
	  $this->load->view('non_proc/plan_detail', $this->data);
	}

	public function hapus_detail()
	{
	  $data_to_delete = $this->input->post('chbox');
	  if ($data_to_delete) {
		foreach ($data_to_delete as $id => $data) {
		  $this->db->delete('NonProcurementPlan', array('id' => $id));
		  // hapus record terkait di table lain
		  $this->db->delete('NonProcurementImp', array('non_proc_id' => $id));
		  $this->db->delete('ProcProgressDetail', array('proc_id' => $id, 'impl_type' => 'Non-Proc'));
		  $this->db->delete('FinancialRealDetail', array('impl_detail_id' => $id, 'impl_type' => 'Non-Proc'));
		}
        $this->session->set_userdata('data_terhapus', 'Data telah dihapus');
		exit('Data telah dihapus');
	  }
	}
	
	public function impl($page = 1)
	{
	  $keywords = $this->input->get('keywords');
	  $search_grantee = $this->input->get('search_grantee');
	  $total_rows = 0;
      $this->load->model('Rpp_model');
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		// $criteria['grantee_id'] = $this->data['user_data']['piu_id'];dorrr dorr dorr -->piu_id is changed to be grantee_id permanently
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
	  $this->load->view('non_proc/implementation', $this->data);
	}

	public function impl_detail($proposal_id)
	{
	  $this->load->model('Rpp_model');
	  // set kriteria untuk detail implementasi
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
	    $impl_criteria['NonProcurementPlan.grantee_id'] = $this->data['user_data']['grantee_id'];
	  }
	  $impl_criteria['NonProcurementPlan.rpp_id'] = $proposal_id;
	  $this->data['proposal_detail'] = $this->Rpp_model->getDetail(array('Proposal.id' => $proposal_id));
	  $this->data['list_contractor'] = $this->Master_model->getMasterData('Contractor');
	  $this->data['list_status'] = $this->Master_model->getMasterData('Status', 100, "proc_or_nonproc='Non-Proc'");
	  $this->data['records'] = $this->Non_proc_model->getImplementationData($impl_criteria);
	  $this->load->view('non_proc/implementation_detail', $this->data);
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
		$insert_data['impl_type'] = 'Non-Proc';
		$insert_data['prog_id'] = $prog;
		$insert_data['prog_date'] = date('Y-m-d', strtotime($prog_dates[$id]));
		$insert_data['description'] = $descriptions[$id];
		$insert_data['created_at'] = date('Y-m-d');
		
		$this->db->insert('ProcProgressDetail', $insert_data);
		// update juga data proc
		$update_data['estimated_prog'] = $prog;
		$contract_no = $this->input->post('contract_no');
		$contractor = $this->input->post('contractor');
		if ($contract_no && $contractor) {
		  $update_data['contractor'] = $contractor;
		  $update_data['contract_no'] = $contract_no;
		  $update_data['impl_date'] = date('Y-m-d', strtotime($this->input->post('impl_date')));
		  $update_data['impl_duration'] = $this->input->post('impl_duration');
		  $update_data['impl_value'] = str_replace('.', '', $this->input->post('impl_value'));
		  $update_data['refund'] = str_replace('.', '', $this->input->post('refund'));
		} else if ($insert_data['prog_id'] < 25) {
		  $update_data['contractor'] = '';
		  $update_data['contract_no'] = '';
		  $update_data['impl_date'] = '';
		  $update_data['impl_duration'] = '';
		  $update_data['impl_value'] = 0;
		  $update_data['refund'] = 0;			
		}
		$this->db->update('NonProcurementImp', $update_data, array('non_proc_id' => $proc_id));
	  }
	}

	public function progress_detail($proposal_detail_id)
	{
	  sleep(1);
	  $this->data['list_status'] = $this->Master_model->getMasterData('Status', 100, "proc_or_nonproc='Non-Proc'");
	  $impl_criteria['ProposalDetail.id'] = $proposal_detail_id;
	  $impl_data = $this->Non_proc_model->getImplementationData($impl_criteria);
	  $this->data['rec'] = $impl_data[0];
	  $this->load->view('non_proc/progress_detail', $this->data);
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
	 * Proses simpan data non procurement plan dari form
	 */
	public function simpan($tipe = '')
	{
	  $this->load->model('Rpp_model');
	  if ($tipe == 'impl') {
		$rpp_id = $this->input->post('rpp_id');
		$grantee_id = $this->data['user_data']['grantee_id'];
		if ('pmu' == $this->data['user_data']['groups'] && 'admin' == $this->data['user_data']['groups']) {
		  // ambil detail RPP dan ambil grantee id
		  $rpp_detail = $this->Rpp_model->getDetail($rpp_id);
		  $grantee_id = $rpp_detail->grantee_id;
		}
		$contractor_ids = $this->input->post('contractor');
		$contract_nos = $this->input->post('contract_no');
		$impl_dates = $this->input->post('impl_date');
		$impl_durations = $this->input->post('impl_duration');
		$impl_values = $this->input->post('impl_value');
		$estimated_progs = $this->input->post('estimated_prog');
		$refunds = $this->input->post('refund');
		foreach ($impl_values as $proc_id => $val) {
		  if (is_numeric($val) && $val > 0) {
			$insert_data['non_proc_id'] = $proc_id;
			$insert_data['contractor'] = $contractor_ids[$proc_id];
			$insert_data['grantee_id'] = $grantee_id;
			$insert_data['contract_no'] = $contract_nos[$proc_id];
			$insert_data['impl_date'] = date('Y-m-d', strtotime($impl_dates[$proc_id]));
			$insert_data['impl_duration'] = $impl_durations[$proc_id];
			$insert_data['impl_value'] = str_replace('.', '', $impl_values[$proc_id]);
			$insert_data['estimated_prog'] = $estimated_progs[$proc_id];
			$insert_data['refund'] = str_replace('.', '', $refunds[$proc_id]);

			$this->Non_proc_model->simpan_impl($insert_data);
		  }
		}
		$this->session->set_flashdata('pesan_simpan', 'Data detail pelaksanaan procurement berhasil disimpan');
		redirect('/non_proc/impl_detail/'.$rpp_id);
	  } else if ($tipe == 'detail') {
		$rpp_id = $this->input->post('rpp_id');
		$grantee_id = $this->data['user_data']['grantee_id'];
		if ('pmu' == $this->data['user_data']['groups'] && 'admin' == $this->data['user_data']['groups']) {
		  // ambil detail RPP dan ambil grantee id
		  $rpp_detail = $this->Rpp_model->getDetail($rpp_id);
		  $grantee_id = $rpp_detail->grantee_id;
		}
		$proposal_detail_ids = $this->input->post('proposal_detail_id');
		$descriptions = $this->input->post('name_of_activity');
		$non_pp_dates = $this->input->post('non_pp_date');
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
			$insert_data['name_of_activity'] = $descriptions[$r];
			$insert_data['non_pp_date'] = date('Y-m-d', strtotime($non_pp_dates[$r]));
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
			  $error_melebihi_pagu[] = 'Biaya pada '.number_format($insert_data['estimated_cost'], 0, '', '.').' <strong>'.$insert_data['description'].'</strong> melebihi NOL pagu yang ditentukan.
			   Nilai disesuaikan dengan NOL pagu maksimal '.number_format($lebih_dari_pagu, 0, '', '.');
			  $insert_data['estimated_cost'] = $lebih_dari_pagu;
			}
			if (isset($updateIDs[$r])) {
			  $this->Non_proc_model->simpan($insert_data, true, array('id' => $updateIDs[$r]));
			} else {
			  $insert_id = 0;
			  $this->Non_proc_model->simpan($insert_data, false, false, $insert_id);
			  $this->db->insert('NonProcurementImp', array('non_proc_id' => $insert_id, 'grantee_id' => $grantee_id));
			}
			$this->session->set_flashdata('pesan_simpan', 'Data detail perencanaan non-procuremrnt berhasil disimpan');
		  } else {
			$this->session->set_flashdata('error_simpan', 'Deskripsi dan nilai prakiraan harap diisi dengan benar');
			redirect('/non_proc/detail/'.$rpp_id); return;
		  }
		}
		if ($error_melebihi_pagu) {   
		    $this->session->set_flashdata('error_melebihi_pagu', json_encode($error_melebihi_pagu));    
		}
		redirect('/non_proc/detail/'.$rpp_id);
	  }
	}

	private function cek_apakah_melebihi_pagu($proposal_id, $proposal_detail_id, $value) {
	  $list_proposal_detail = $this->Rpp_model->getRppPlanDetailCompl($proposal_id, 'Non-Proc', 1, 200);
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
