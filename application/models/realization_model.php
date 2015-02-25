<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Realization_model extends CI_Model {
  public function getData($criteria = '', $page = 1, $limit = 20) {
    $this->db->cache_off();
    if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);
      } else {
        $this->db->where($criteria); 
      }
    }
    $this->db->select('FinancialReal.*, Grantee.name_of_grantee', false);
    $this->db->join('Grantee', 'FinancialReal.grantee_id=Grantee.id', 'left');
    $query = $this->db->get('FinancialReal', $limit);
    return $query->result();
  }

  public function getDetail($realization_id) {
    $this->db->cache_off();
    $this->db->where(array('id' => $realization_id));
    $query = $this->db->get('FinancialReal');
    return $query->row();
  }
  
  public function getImplementationDetail($criteria, $limit = 100) {
    if ($criteria) {
      $this->db->where($criteria);
    }
    $query = $this->db->get('FinancialRealDetail', $limit);
    return $query->result();    
  }
  
  public function getImplementationName($id, $impl_type = 'Proc') {
    $impl_table = 'ProcurementImp';
    $impl_table_field = 'proc_id';
    if ($impl_type != 'Proc') {
      $impl_table = 'NonProcurementImp';
      $impl_table_field = 'non_proc_id';
      $this->db->join('NonProcurementPlan', 'NonProcurementPlan.id='.$impl_table.'.'.$impl_table_field, 'inner');
      $this->db->join('ProposalDetail', 'NonProcurementPlan.proposal_detail_id=ProposalDetail.id', 'inner');
      $this->db->select('package_id AS name, contractor, contract_no', false);
    } else {
      $this->db->join('ProcurementPlan', 'ProcurementPlan.id='.$impl_table.'.'.$impl_table_field, 'inner');
      $this->db->join('Contractor', 'ProcurementImp.contractor_id=Contractor.id', 'inner');
      $this->db->join('ProposalDetail', 'ProcurementPlan.proposal_detail_id=ProposalDetail.id', 'inner');
      $this->db->select('package_id AS name, name_of_contractor, contract_no', false);
    }
    
    $this->db->where($impl_table_field, $id);
    $query = $this->db->get($impl_table);
    return $query->row(); 
  }
  
  public function simpan($data, $is_update = false, $update_criteria = array(), &$insert_id) {
    if (!$is_update) {
      $this->db->insert('FinancialReal', $data);
      $insert_id = $this->db->insert_id();
    } else {
      $this->db->where($update_criteria);
      $this->db->update('FinancialReal', $data);
    }
  }

  public function simpan_detail($data, $is_update = false, $update_criteria = array()) {
    if (!$is_update) {
      $this->db->insert('FinancialRealDetail', $data);  
    } else {
      $this->db->where($update_criteria);
      $this->db->update('FinancialRealDetail', $data);
    }
  }
}
