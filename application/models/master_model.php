<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
 
class Master_model extends CI_Model {
  public function getMasterData($master_table, $limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
    $this->db->cache_off();
	if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);
      } else if (is_array($criteria)) {
	    $this->db->where($criteria);
	  }	  
	}

	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}
	if ($master_table == 'FinancialProjComp') {
	  $this->db->select('FinancialProjComp.*, SourceOfFund.source_of_fund AS `sf`, Schema.schema_name', false);
	  $this->db->join('SourceOfFund', 'FinancialProjComp.source_of_fund=SourceOfFund.id', 'left');
	  $this->db->join('Schema', 'FinancialProjComp.subject=Schema.id', 'left');
	}
	$master_query = $this->db->get($master_table, $limit, $offset);
	$master_result = $master_query->result();
	// query untuk paging
	$this->db->select('COUNT(*) as total', false);
	if ($criteria) {
      if (is_string($criteria)) {
        $this->db->where($criteria, null, false);
      } else if (is_array($criteria)) {
	    $this->db->where($criteria);
	  }	  
	}
	$count_query = $this->db->get($master_table);
	$count_result = $count_query->row();
	$total_rows = $count_result->total;
    return $master_result;
  }
  
  public function getRecursiveFPC($parent_id = null, $schema = null, $source_of_fund = null, $proc_or_nonproc = '', $grantee_type = '')
  {
    $result = array();
    $this->db->select('FinancialProjComp.*, SourceOfFund.source_of_fund AS `sf`, Schema.schema_name', false);
    $this->db->join('SourceOfFund', 'FinancialProjComp.source_of_fund=SourceOfFund.id', 'left');
    $this->db->join('Schema', 'FinancialProjComp.subject=Schema.id', 'left');
    if (!$parent_id) {
      $this->db->where('parent_id IS NULL', null, false);  
    } else {
      $this->db->where('parent_id='.$parent_id, null, false);
    }
    if ($schema && $parent_id) {
      $this->db->where('subject IN ('.$schema.')', null, false);
    }
    if ($source_of_fund) {
      $this->db->where('source_of_fund='.$source_of_fund, null, false);
    }
    if ($proc_or_nonproc) {
      $this->db->where('proc_or_nonproc=\''.$proc_or_nonproc.'\'', null, false);
    }
    if ($grantee_type) {
      $this->db->where('grantee_type=\''.$grantee_type.'\'', null, false);
    }
    
    $query = $this->db->get('FinancialProjComp');
    // die($this->db->last_query());
    // echo $this->db->last_query();
    $num_rows = $query->num_rows();
    if ($num_rows > 0) {
      foreach ($query->result() as $data) {
        $result[$data->id]['data'] = $data;
        $result[$data->id]['childs'] = $this->getRecursiveFPC($data->id, $schema, $source_of_fund, $proc_or_nonproc, $grantee_type);
      }
      return $result; 
    } else {
      return;
    }
  }

  public function simpan($master_table, $data, $is_update = false, $update_criteria = array()) {
    if (!$is_update) {
      $this->db->insert($master_table, $data);  
    } else {
      $this->db->where($update_criteria);
      $this->db->update($master_table, $data);
    }
  }
  
  public function hapus($master_table, $delete_criteria) {
	$this->db->delete($master_table, $delete_criteria);
  }
}
