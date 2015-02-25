<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Proc_model extends CI_Model {
  function getData($criteria = '', $page = 1, $limit = 20) {
    $this->db->cache_off();
    if ($criteria) {
      $this->db->where($criteria, null, false);
    }
    $query = $this->db->get('ProcurementPlan', $limit);
    return $query->result();
  }
  
  public function getPlanDetail($criteria)
  {
    if ($criteria) {
      $this->db->where($criteria);
    }
    $query = $this->db->get('ProcurementPlan');
    return $query->result();    
  }
  
  public function getImplementationData($criteria = '')
  {
    if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);
      } else {
        $this->db->where($criteria);
      }
    }
    /*
    $this->db->join('ProcurementPlan', 'ProcurementImp.proc_id=ProcurementPlan.id', 'left');
    $query = $this->db->get('ProcurementImp');
    */
    $this->db->select('ProcurementPlan.id AS plan_id, Contractor.name_of_contractor, ProposalDetail.package_id, 
                       ProcurementPlan.description, ProcurementPlan.proposal_detail_id,
                       ProcurementPlan.estimated_cost,ProcurementImp.*');
    $this->db->join('ProposalDetail', 'ProcurementPlan.proposal_detail_id=ProposalDetail.id');
    $this->db->join('ProcurementImp', 'ProcurementImp.proc_id=ProcurementPlan.id', 'left');
    $this->db->join('Contractor', 'ProcurementImp.contractor_id=Contractor.id', 'left');
    $query = $this->db->get('ProcurementPlan');
    // echo die($this->db->last_query());
    return $query->result();        
  }

  public function getProgressData($criteria = '')
  {
    $this->db->select('ProcProgressDetail.*, Status.id, Status.status, Status.status_order');
    $this->db->where(array('impl_type' => 'Proc'));
    if ($criteria) {
      $this->db->where($criteria);
    }
    $this->db->join('Status', 'ProcProgressDetail.prog_id=Status.id', 'inner');
    $this->db->order_by('Status.status_order', 'asc');
    $query = $this->db->get('ProcProgressDetail');
    // echo die($this->db->last_query());
    return $query->result();        
  }

  public function getPlanSum($grantee_id, $rpp_id = '', $fpc_id = '', $source_fund = 0, $date_range_end = '', $date_range_start = '') {
    $sum = 0;
    $this->db->select('SUM(estimated_cost) AS total', false);
    $this->db->where('ProcurementPlan.grantee_id', $grantee_id);
    if ($rpp_id) {
      $this->db->where('rpp_id', $rpp_id);
      $this->db->where('ProposalDetail.proposal_id', $rpp_id);
    }
    if ($fpc_id) {
      $this->db->where('component_id', $fpc_id);
    }
    if ($source_fund > 0) {
      $this->db->where('source_of_fund', $source_fund);
    }
    if ($date_range_end && $date_range_start) {
      $date_range_start = date('Y-m-d', strtotime($date_range_start));
      $date_range_end = date('Y-m-d', strtotime($date_range_end));
      $this->db->where('proc_date BETWEEN \''.$date_range_start.'\' AND \''.$date_range_end.'\'', null, false);
    }
    $this->db->join('ProposalDetail', 'ProcurementPlan.proposal_detail_id=ProposalDetail.id', 'left');
    $query = $this->db->get('ProcurementPlan');
    // echo $this->db->last_query();
    $data = $query->row();
    if ($data->total) {
      $sum = $data->total; 
    }
    return $sum;
  }
  
  public function getImpSum($grantee_id, $rpp_id = '', $fpc_id = '', $source_fund = 0, $date_range_end = '', $date_range_start = '') {
    $sum = 0;
    $this->db->select('SUM(contract_value) AS total', false);
    $this->db->where('ProcurementPlan.grantee_id', $grantee_id);
    if ($rpp_id) {
      $this->db->where('rpp_id', $rpp_id);
      $this->db->where('ProposalDetail.proposal_id', $rpp_id);
    }
    if ($fpc_id) {
      $this->db->where('component_id', $fpc_id);  
    }
    if ($source_fund > 0) {
      $this->db->where('source_of_fund', $source_fund);
    }
    if ($date_range_end && $date_range_start) {
      $date_range_start = date('Y-m-d', strtotime($date_range_start));
      $date_range_end = date('Y-m-d', strtotime($date_range_end));
      $this->db->where('proc_date BETWEEN \''.$date_range_start.'\' AND \''.$date_range_end.'\'', null, false);
    }
    $this->db->join('ProcurementPlan', 'ProcurementImp.proc_id=ProcurementPlan.id', 'inner');
    $this->db->join('ProposalDetail', 'ProcurementPlan.proposal_detail_id=ProposalDetail.id', 'left');
    $query = $this->db->get('ProcurementImp');
    // echo $this->db->last_query();
    $data = $query->row();
    if ($data->total) {
      $sum = $data->total; 
    }
    return $sum;
  }

  public function getDisbursedSum($grantee_id, $rpp_id = '', $fpc_id = '', $source_fund = 0, $date_range_end = '', $date_range_start = '') {
    $sum = 0;
    $table_wprefix = $this->db->dbprefix('FinancialRealDetail');
    $this->db->select('SUM('.$table_wprefix.'.value) AS total', false);
    $this->db->where('ProcurementPlan.grantee_id', $grantee_id);
    if ($rpp_id) {
      $this->db->where('rpp_id', $rpp_id);
      $this->db->where('ProposalDetail.proposal_id', $rpp_id);
    }
    if ($fpc_id) {
      $this->db->where('component_id', $fpc_id);  
    }
    if ($source_fund > 0) {
      $this->db->where('source_of_fund', $source_fund);
    }
    if ($date_range_end && $date_range_start) {
      $date_range_start = date('Y-m-d', strtotime($date_range_start));
      $date_range_end = date('Y-m-d', strtotime($date_range_end));
      $this->db->where('proc_date BETWEEN \''.$date_range_start.'\' AND \''.$date_range_end.'\'', null, false);
    }
    $this->db->where('FinancialRealDetail.impl_type', 'Proc');
    
    $this->db->join('ProcurementImp', 'FinancialRealDetail.impl_detail_id=ProcurementImp.proc_id', 'left');
    $this->db->join('ProcurementPlan', 'ProcurementImp.proc_id=ProcurementPlan.id', 'left');
    $this->db->join('ProposalDetail', 'ProcurementPlan.proposal_detail_id=ProposalDetail.id', 'left');
    
    $query = $this->db->get('FinancialRealDetail');
    // echo '<div class="alert alert-danger">'.$this->db->last_query().'</div>';
    $data = $query->row();
    if ($data->total) {
      $sum = $data->total; 
    }
    return $sum;
  }

  public function getRecPlanSum($grantee_id, $rpp_id = '', $fpc_id = '', $source_fund = 0, $date_range_end = '', $date_range_start = '') {
    $sum = 0;
    $fpc = $this->Master_model->getRecursiveFPC($fpc_id);
    if ($fpc) {
      foreach ($fpc as $id => $data) {
        $sum += $this->getPlanSum($grantee_id, $rpp_id, $id, $source_fund, $date_range_end, $date_range_start);
      }
      return $sum;      
    }
    return 0;
  }
  
  public function getRecImpSum($grantee_id, $rpp_id = '', $fpc_id = '', $source_fund = 0, $date_range_end = '', $date_range_start = '') {
    $sum = 0;
    $fpc = $this->Master_model->getRecursiveFPC($fpc_id);
    if ($fpc) {
      foreach ($fpc as $id => $data) {
        $sum += $this->getImpSum($grantee_id, $rpp_id, $id, $source_fund, $date_range_end, $date_range_start);
      }
      return $sum;
    }
    return 0;
  }

  public function getRecDisbursedSum($grantee_id, $rpp_id = '', $fpc_id = '', $source_fund = 0, $date_range_end = '', $date_range_start = '') {
    $sum = 0;
    $fpc = $this->Master_model->getRecursiveFPC($fpc_id);
    if ($fpc) {
      foreach ($fpc as $id => $data) {
        $sum += $this->getDisbursedSum($grantee_id, $rpp_id, $id, $source_fund, $date_range_end, $date_range_start);
      }
      return $sum;
    }
    return 0;
  }
  
  public function simpan($data, $is_update = false, $update_criteria = array(), &$insert_id = 0) {
    if (!$is_update) {
      $this->db->insert('ProcurementPlan', $data);
      $insert_id = $this->db->insert_id();
    } else {
      $this->db->where($update_criteria);
      $this->db->update('ProcurementPlan', $data);
    }
  }

  public function simpan_impl($data, $is_update = false, $update_criteria = array()) {
    $table_proc_imp = $this->db->protect_identifiers('ProcurementImp', true);
    $sql = 'REPLACE INTO '.$table_proc_imp.'(`proc_id`, `contractor_id`, `grantee_id`, `fpc_id`,
      `fin_proc_id`, `contract_no`, `contract_date`, `contract_duration`, `contract_value`, `estimated_prog`)
      VALUES (?, ?, ?, null, null, ?, ?, ?, ?, ?)';
    $query = $this->db->query($sql, $data);
    return $query;
    /*
    if (!$is_update) {
      $this->db->insert('ProcurementImp', $data);  
    } else {
      $this->db->where($update_criteria);
      $this->db->update('ProcurementImp', $data);
    }
    */
  }
}
