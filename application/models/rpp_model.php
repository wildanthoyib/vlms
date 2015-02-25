<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Rpp_model extends CI_Model {
  
  public function getData( $criteria = '', $page = 1, $limit = 20, &$total_rows = 0) {
    //$this->db->where(array('contract'=> $contract));
    $this->db->cache_off();
    if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);  
      } else {
        $this->db->where($criteria);
      }
    }
    $offset = 0;
    if ($page > 1) {
      $offset = ($page*$limit)-$limit;
    }
    
    $this->db->select('Proposal.*, Grantee.name_of_grantee');
    $this->db->join('Grantee', 'Proposal.grantee_id=Grantee.id', 'left');
    $query = $this->db->order_by('year', 'desc');
    $query = $this->db->order_by('grantee_id', 'asc');
    $query = $this->db->get('Proposal', $limit, $offset);
    // die($this->db->last_query());
    $main_result = $query->result();
    
	// query untuk paging
	$this->db->select('COUNT(*) as total', false);
        $this->db->join('Grantee', 'Proposal.grantee_id=Grantee.id');
        //$this->db->where(array('contract'=> $contract));
	if ($criteria) {
          if (is_string($criteria)) {
        $this->db->where($criteria, null, false);
        } else if (is_array($criteria)) {
	    $this->db->where($criteria);
	  }	  
	}
	$count_query = $this->db->get('Proposal');
	$count_result = $count_query->row();
	$total_rows = $count_result->total;
    return $main_result; 
  }

  public function getDetail($criteria) {
    $this->db->cache_off();
    if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);  
      } else {
        $this->db->where($criteria);
      }
    }
    $this->db->select('Proposal.*, Grantee.name_of_grantee AS `grantee`', false);
    $this->db->join('Grantee', 'Proposal.grantee_id=Grantee.id');
    $query = $this->db->get('Proposal');
    return $query->row();
  }
  
  public function getRppPlanDetail($proposal_id, $page = 1, $limit = 20, &$total_rows = 0, $criteria = '') {
    $this->db->where(array('proposal_id' => $proposal_id));
    if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);  
      } else {
        $this->db->where($criteria);
      }
    }
    $offset = 0;
    if ($page > 1) {
      $offset = ($page*$limit)-$limit;  
    }
    $query = $this->db->get('ProposalDetail', $limit, $offset);
    $main_result =  $query->result();
  
    // query untuk paging
    $this->db->select('COUNT(*) as total', false);
    $this->db->where(array('proposal_id' => $proposal_id));
    if ($criteria) {
      if(is_string($criteria)){
        $this->db->where($criteria, null, false);
      }
      else {
        $this->db->where($criteria);
      }
    }
    $count_query = $this->db->get('ProposalDetail');
    $count_result = $count_query->row();
    $total_rows = $count_result->total;
    
    return $main_result; 
  }

  public function getRppPlanDetailCompl($proposal_id, $proc_non_proc = 'Proc', $page = 1, $limit = 20) {
    $this->db->select('ProposalDetail.*, FinancialProjComp.name_of_fpc');
    $this->db->join('FinancialProjComp', 'ProposalDetail.component_id=FinancialProjComp.id');
    $this->db->where(array('proposal_id' => $proposal_id));
    $this->db->where(array('proc_or_nonproc' => $proc_non_proc));
    $this->db->order_by('ProposalDetail.month', 'asc');
    $query = $this->db->get('ProposalDetail', $limit);
    return $query->result();    
  }
  
  public function getRppTotalDetail($proposal_id, $page = 1, $limit = 20, &$total_rows = 0, $criteria='') {
    $this->db->select('RppTotalDetail.*');
    $this->db->where(array('proposal_id' => $proposal_id));
    $this->db->join('FinancialProjComp', 'RppTotalDetail.component_id=FinancialProjComp.id');
    //$this->db->join('Grantee', 'Proposal.grantee_id=Grantee.id');
    if ($criteria) {
      if(is_string($criteria)){
        $this->db->where($criteria, null, false);
      }
      else {
        $this->db->where($criteria);
      }
    }
    $query = $this->db->get('RppTotalDetail', $limit);
    $main_result = $query->result();
  
  // query untuk paging
    $this->db->select('COUNT(*) as total', false);
    $this->db->join('FinancialProjComp', 'RppTotalDetail.component_id=FinancialProjComp.id');
    $this->db->where(array('proposal_id' => $proposal_id));
    if ($criteria) {
      if(is_string($criteria)){
        $this->db->where($criteria, null, false);
      }
      else {
        $this->db->where($criteria);
      }
    }
    $count_query = $this->db->get('RppTotalDetail');
    $count_result = $count_query->row();
    $total_rows = $count_result->total;
    
    return $main_result; 
  }

  public function getRppTotalSum($proposal_id) {
    $this->db->select_sum('value', 'total');
    $this->db->where(array('proposal_id' => $proposal_id));
    $query = $this->db->get('RppTotalDetail');
    $data = $query->row();
    return $data->total;
  }
  
  public function getRppTotalComponent($rpp_id, $component_id = 0) {
    $this->db->where(array('proposal_id' => $rpp_id));
    if ($component_id) {
      $this->db->where(array('component_id' => $component_id));  
    }
    
    $query = $this->db->get('RppTotalDetail');
    // die($this->db->last_query());
    return $query->row();    
  }
  
  public function getRecRppTotalComponent($proposal_id, $component_id) {
    $sum = 0;
    $fpc = $this->Master_model->getRecursiveFPC($component_id);
    if ($fpc) {
      foreach ($fpc as $id => $data) {
        $total = $this->getRppTotalComponent($proposal_id, $id);
        $sum += isset($total->value)?$total->value:0;
      }
      return $sum;
    }
    return 0;
  }
  
  public function simpan($data, $is_update = false, $update_criteria = array()) {
    if (!$is_update) {
      $this->db->insert('Proposal', $data);  
    } else {
      $this->db->where($update_criteria);
      $this->db->update('Proposal', $data);
    }
  }
  
  public function simpan_detail($data, $is_update = false, $update_criteria = array()) {
    if (!$is_update) {
      $this->db->insert('ProposalDetail', $data);  
    } else {
      $this->db->where($update_criteria);
      $this->db->update('ProposalDetail', $data);
    }
  }
}
