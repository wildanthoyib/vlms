<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
 
class Reports_model extends CI_Model {
  /**
   * Form Report 1 G1
   * 
   * Recapitulation of Payment G1
   *
   * @param		integer		$limit jumlah record yang ditampilkan setiap halaman
   * @param		string		$criteria kriteria record yang akan ditampilkan
   * @param		integer		$total_rows reference ke total rows yang dihasilkan
   * @param		integer		$page nomor halaman saat ini
   *
   * @return	object
   *
   */  
  public function report_g1($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}

    // count
	if ($criteria) {
	  $criteria2 = str_ireplace('`pedp_Procu', '`pedp_NonProcu', $criteria);
	}
	
	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria.' '; 
	}
	$sql_count .= ' UNION ';
	$sql_count .= 'SELECT `pedp_ProposalDetail`.`id` FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria2.' '; 
	}
	$sql_count .= ') AS g1';
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;
    
	$sql = 'SELECT `pedp_ProcurementImp`.`proc_id` AS `pid`, `pedp_ProposalDetail`.`package_id`, `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, null AS `sp2d_date`,
	  null AS `sp2d_number`, `pedp_ProcurementPlan`.`grantee_id` AS `grantee`,
	  null AS `file`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,`pedp_Contractor`.`name_of_contractor`,
	  `pedp_ProcurementPlan`.`prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, `pedp_ProcurementPlan`.`grantee_id` AS `notes`,
	   null AS `value`, \'Proc\' AS `proc_or_non_proc`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql .= ' WHERE '.$criteria.' '; 
	}
	$sql .= ' UNION ';
	$sql .= 'SELECT `pedp_NonProcurementImp`.`non_proc_id` AS `pid`, `pedp_ProposalDetail`.`package_id`, `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, null AS `sp2d_date`,
	  null AS `sp2d_number`, `pedp_NonProcurementPlan`.`grantee_id` AS `grantee`,
	  null AS `file`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,`pedp_NonProcurementImp`.`contractor`,
	   null AS `prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, `pedp_NonProcurementPlan`.`grantee_id` AS `notes`,
	   null AS `value`, \'Non-Proc\' AS `proc_or_non_proc`
	   FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql .= ' WHERE '.$criteria2.' '; 
	}
	$sql .= " LIMIT $limit OFFSET $offset";
	// die($sql);
	$result = $this->db->query($sql);
	// die($this->db->last_query());
	return $result->result();
  }

  /**
   * Form Report 1 G2
   * 
   * Monitoring Activity Form G2
   *
   * @param		integer		$limit jumlah record yang ditampilkan setiap halaman
   * @param		string		$criteria kriteria record yang akan ditampilkan
   * @param		integer		$total_rows reference ke total rows yang dihasilkan
   * @param		integer		$page nomor halaman saat ini
   *
   * @return	object
   *
   */  
  public function report_g2($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}
	if ($criteria) {
	  $criteria2 = str_ireplace('`pedp_Procu', '`pedp_NonProcu', $criteria);
	}
	
	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria.' '; 
	}
	$sql_count .= ' UNION ';
	$sql_count .= 'SELECT `pedp_ProposalDetail`.`id`
	   FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria2.' '; 
	}
	$sql_count .= ") AS g2";
	
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;

	$sql = 'SELECT `pedp_ProcurementPlan`.`id` AS `pid`, `pedp_ProcurementImp`.`contract_no`, `pedp_ProcurementImp`.`contract_value`,
	  `pedp_ProposalDetail`.`package_id`, `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, null AS `sp2d_date`,
	  null AS `sp2d_number`, `pedp_ProcurementPlan`.`grantee_id` AS `grantee`,
	  null AS `file`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,`pedp_Contractor`.`name_of_contractor` AS `contractor`,
	  `pedp_ProcurementPlan`.`prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, `pedp_ProcurementPlan`.`grantee_id` AS `notes`,
	  `pedp_ProcurementPlan`.`estimated_cost` AS `plan_value`, \'Proc\' AS `proc_or_non_proc`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql .= ' WHERE '.$criteria.' '; 
	}
	$sql .= ' UNION ';
	$sql .= 'SELECT `pedp_NonProcurementPlan`.`id` AS `pid`, `pedp_NonProcurementImp`.`contract_no`, `pedp_NonProcurementImp`.`impl_value` AS `contract_value`,
	  `pedp_ProposalDetail`.`package_id`, `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, null AS `sp2d_date`,
	  null AS `sp2d_number`, `pedp_NonProcurementPlan`.`grantee_id` AS `grantee`,
	  null AS `file`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,`pedp_NonProcurementImp`.`contractor`,
	   null AS `prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, `pedp_NonProcurementPlan`.`grantee_id` AS `notes`,
	   `pedp_NonProcurementPlan`.`estimated_cost` AS `plan_value`, \'Non-Proc\' AS `proc_or_non_proc`
	   FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql .= ' WHERE ('.$criteria2.') '; 
	}
	$sql .= " LIMIT $limit OFFSET $offset";
	
	$result = $this->db->query($sql);
	// die($sql);
	return $result->result();
  }

  /**
   * Form Report 1 G3
   * 
   *  Monitoring Activity Form G3
   *
   * @param		integer		$limit jumlah record yang ditampilkan setiap halaman
   * @param		string		$criteria kriteria record yang akan ditampilkan
   * @param		integer		$total_rows reference ke total rows yang dihasilkan
   * @param		integer		$page nomor halaman saat ini
   *
   * @return	object
   *
   */
  public function report_g3($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}

	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` AS `pid` FROM `pedp_ProcurementPlan`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE ('.$criteria.') '; 
	}
	$sql_count .= ' UNION ';
	$sql_count .= 'SELECT `pedp_ProposalDetail`.`id` AS `pid` FROM `pedp_NonProcurementPlan`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE ('.$criteria.') '; 
	}
	$sql_count .= ') as g3';
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;
	
	$sql = 'SELECT `pedp_ProposalDetail`.`id` AS `pid`, `pedp_ProposalDetail`.`package_id`, `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`,
	  `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,
	  `pedp_ProcurementPlan`.`prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, 
	  `pedp_ProcurementPlan`.`plan_q1`, `pedp_ProcurementPlan`.`plan_q1_value`,
	  `pedp_ProcurementPlan`.`plan_q2`, `pedp_ProcurementPlan`.`plan_q2_value`,
	  `pedp_ProcurementPlan`.`plan_q3`, `pedp_ProcurementPlan`.`plan_q3_value`,
	  `pedp_ProcurementPlan`.`plan_q4`, `pedp_ProcurementPlan`.`plan_q4_value`,
	  `pedp_ProcurementPlan`.`estimated_cost`
	   FROM `pedp_ProcurementPlan`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql .= ' WHERE '.$criteria; 
	}
	$sql .= " LIMIT $limit OFFSET $offset";
	$sql .= ' UNION ';
	$sql .= 'SELECT `pedp_ProposalDetail`.`id` AS `pid`, `pedp_ProposalDetail`.`package_id`,
	  `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,
	   null, `fpc2`.`name_of_fpc` AS `parent_fpc`, 
	  `pedp_NonProcurementPlan`.`plan_q1`, `pedp_NonProcurementPlan`.`plan_q1_value`,
	  `pedp_NonProcurementPlan`.`plan_q2`, `pedp_NonProcurementPlan`.`plan_q2_value`,
	  `pedp_NonProcurementPlan`.`plan_q3`, `pedp_NonProcurementPlan`.`plan_q3_value`,
	  `pedp_NonProcurementPlan`.`plan_q4`, `pedp_NonProcurementPlan`.`plan_q4_value`,
	  `pedp_NonProcurementPlan`.`estimated_cost`
	   FROM `pedp_NonProcurementPlan`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql .= ' WHERE '.$criteria; 
	}
	$sql .= " LIMIT $limit OFFSET $offset";
	
	// die($sql);
	$result = $this->db->query($sql);
	return $result->result();
  }
  public function report_1A($limit = 20, $criteria = '', $total_rows = 0, $page = 1) {
    $this->db->cache_off();
    $offset = 0;
    if($page > 1) {
      $offset = ($limit*$page)-$limit;
    }
    // count
	if ($criteria) {
	  $criteria2 = str_ireplace('`pedp_Procu', '`pedp_NonProcu', $criteria);
	}
	
	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria.' '; 
	}
	$sql_count .= ' UNION ';
	$sql_count .= 'SELECT `pedp_ProposalDetail`.`id` FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
  }
  
  public function report_1C($limit = 20, $criteria = '', $total_rows = 0, $page = 1 ) {
    $this->db->cache_off();
    $offset = 0;
    if ($page > 1) {
      $offset = ($limit*$page)-$limit;
    }
    // count
	if ($criteria) {
	  $criteria2 = str_ireplace('`pedp_Procu', '`pedp_NonProcu', $criteria);
	}
	
	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria.' '; 
	}
	$sql_count .= ' UNION ';
	$sql_count .= 'SELECT `pedp_ProposalDetail`.`id` FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
  }
  public function report_1E($limit = 20, $criteria = '', $total_rows = 0, $page = 1 ) {
    $this->db->cache_off();
    $offset = 0;
    if($page > 1) {
      $offset = ($limit*$page)-$limit;
    }
    //count
    if($criteria) {
      $criteria = str_ireplace('`pedp_Procu', '`pedp_NonProcu', $criteria);
    }
    $sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
	if ($criteria) {
	  $sql_count .= ' WHERE '.$criteria.' '; 
	}
	$sql_count .= ' UNION ';
	$sql_count .= 'SELECT `pedp_ProposalDetail`.`id` FROM `pedp_NonProcurementPlan`
	   LEFT JOIN `pedp_NonProcurementImp` ON `pedp_NonProcurementPlan`.`id`=`pedp_NonProcurementImp`.`non_proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_NonProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`';
  }
  
  /**
   * Form Report 3A
   * 
   * Procurement Process Monitoring (Goods and Works)
   *
   * @param		integer		$limit jumlah record yang ditampilkan setiap halaman
   * @param		string		$criteria kriteria record yang akan ditampilkan
   * @param		integer		$total_rows reference ke total rows yang dihasilkan
   * @param		integer		$page nomor halaman saat ini
   *
   * @return	object
   *
   */
  public function report_3a($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}

	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` AS `pid` FROM `pedp_ProcurementPlan`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Equipment%\'';
	if ($criteria) {
	  $sql_count .= ' AND ('.$criteria.') '; 
	}
	$sql_count .= ') as 3a';
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;
	
	$sql = 'SELECT `pedp_ProposalDetail`.`id` AS `pid`, `pedp_ProposalDetail`.`package_id`, `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`,
	  `pedp_ProposalDetail`.`component_id`, `pedp_ProcurementImp`.`contract_no`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`,
	  `pedp_ProcurementPlan`.`prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, 
	  `pedp_ProcurementPlan`.`estimated_cost`, `pedp_ProcurementMethod`.`procurement_method`, `pedp_ProcurementImp`.`proc_id`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   LEFT JOIN `pedp_ProcurementMethod` ON `pedp_ProcurementPlan`.`proc_method`=`pedp_ProcurementMethod`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Equipment%\'';
	if ($criteria) {
	  $sql .= ' AND ('.$criteria.') '; 
	}
	$sql .= " LIMIT $limit OFFSET $offset";
	
	// die($sql);
	$result = $this->db->query($sql);
	return $result->result();
  }

  /**
   * Form Report 3B
   * 
   * Procurement Process Monitoring for Selection of Consultan
   *
   * @param		integer		$limit jumlah record yang ditampilkan setiap halaman
   * @param		string		$criteria kriteria record yang akan ditampilkan
   * @param		integer		$total_rows reference ke total rows yang dihasilkan
   * @param		integer		$page nomor halaman saat ini
   *
   * @return	object
   *
   */
  public function report_3b($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}

	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` AS `pid` FROM `pedp_ProcurementPlan`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Consulting%\'';
	if ($criteria) {
	  $sql_count .= ' AND ('.$criteria.') '; 
	}
	$sql_count .= ') as 3b';
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;
	
	$sql = 'SELECT `pedp_ProposalDetail`.`id` AS `pid`, `pedp_ProposalDetail`.`package_id`,
	  `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`, `pedp_ProcurementImp`.`contract_no`,
	   null, `fpc2`.`name_of_fpc` AS `parent_fpc`, null AS `procurement_method`, null AS `prior_or_post`,
	  `pedp_ProcurementPlan`.`estimated_cost`, `pedp_ProcurementImp`.`proc_id`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Consulting%\'';
	if ($criteria) {
	  $sql .= ' AND ('.$criteria.') '; 
	}
	$sql .= " LIMIT $limit OFFSET $offset";
	
	// die($sql);
	$result = $this->db->query($sql);
	return $result->result();
  }

  public function report_3c($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}
	
	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Equipment%\'';
	if ($criteria) {
	  $sql_count .= ' AND ('.$criteria.') '; 
	}
	$sql_count .= ') AS 3c';
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;
    
	$sql = 'SELECT `pedp_ProcurementImp`.`proc_id` AS `pid`, `pedp_ProposalDetail`.`package_id`,
	  `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, `pedp_ProcurementImp`.`contract_no`,
	  `pedp_ProcurementPlan`.`grantee_id` AS `grantee`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`, `pedp_Contractor`.`name_of_contractor`, `pedp_Contractor`.`nationality`,
	  `pedp_ProcurementPlan`.`prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, `pedp_ProcurementPlan`.`grantee_id` AS `notes`,
	  `pedp_ProcurementMethod`.`procurement_method`, `pedp_ProcurementImp`.`contract_value`, \'Proc\' AS `proc_or_non_proc`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   LEFT JOIN `pedp_ProcurementMethod` ON `pedp_ProcurementPlan`.`proc_method`=`pedp_ProcurementMethod`.`id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Equipment%\'';
	if ($criteria) {
	  $sql .= ' AND ('.$criteria.') '; 
	}
	// die($sql);
	$result = $this->db->query($sql);
	// die($this->db->last_query());
	return $result->result();
  }

  public function report_3d($limit = 20, $criteria = '', &$total_rows = 0, $page = 1) {
	$this->db->cache_off();
	$offset = 0;
	if ($page > 1) {
	  $offset = ($limit*$page)-$limit;
	}
	
	$sql_count = 'SELECT COUNT(*) AS `total` FROM (SELECT `pedp_ProposalDetail`.`id` FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Consulting%\'';
	if ($criteria) {
	  $sql_count .= ' AND ('.$criteria.') '; 
	}
	$sql_count .= ') AS 3d';
	$count_q = $this->db->query($sql_count);
	$count_d = $count_q->row();
	$total_rows = $count_d->total;
    
	$sql = 'SELECT `pedp_ProcurementImp`.`proc_id` AS `pid`, `pedp_ProposalDetail`.`package_id`,
	  `pedp_ProposalDetail`.`source_of_fund`, `pedp_Proposal`.`year`, `pedp_ProcurementImp`.`contract_no`,
	  `pedp_ProcurementPlan`.`grantee_id` AS `grantee`, `pedp_ProposalDetail`.`component_id`,
	  `pedp_FinancialProjComp`.`name_of_fpc`,`pedp_SourceOfFund`.`source_of_fund`, `pedp_Contractor`.`name_of_contractor`, `pedp_Contractor`.`nationality`,
	  `pedp_ProcurementPlan`.`prior_or_post`, `fpc2`.`name_of_fpc` AS `parent_fpc`, `pedp_ProcurementPlan`.`grantee_id` AS `notes`,
	  `pedp_ProcurementMethod`.`procurement_method`, `pedp_ProcurementImp`.`contract_value`, \'Proc\' AS `proc_or_non_proc`
	   FROM `pedp_ProcurementPlan`
	   LEFT JOIN `pedp_ProcurementImp` ON `pedp_ProcurementPlan`.`id`=`pedp_ProcurementImp`.`proc_id`
	   LEFT JOIN `pedp_ProcurementMethod` ON `pedp_ProcurementPlan`.`proc_method`=`pedp_ProcurementMethod`.`id`
	   INNER JOIN `pedp_ProposalDetail` ON `pedp_ProcurementPlan`.`proposal_detail_id`=`pedp_ProposalDetail`.`id`
	   INNER JOIN `pedp_Proposal` ON `pedp_ProposalDetail`.`proposal_id`=`pedp_Proposal`.`id`
	   LEFT JOIN `pedp_Contractor` ON `pedp_ProcurementImp`.`contractor_id`=`pedp_Contractor`.`id`
	   INNER JOIN `pedp_FinancialProjComp` ON `pedp_ProposalDetail`.`component_id`=`pedp_FinancialProjComp`.`id`
	   INNER JOIN `pedp_SourceOfFund` ON `pedp_ProposalDetail`.`source_of_fund`=`pedp_SourceOfFund`.`id`
	   INNER JOIN `pedp_FinancialProjComp` AS `fpc2` ON `pedp_FinancialProjComp`.`parent_id`=`fpc2`.`id`
	   WHERE `fpc2`.`name_of_fpc` LIKE \'Consulting%\'';
	if ($criteria) {
	  $sql .= ' AND ('.$criteria.') '; 
	}
	// die($sql);
	$result = $this->db->query($sql);
	// die($this->db->last_query());
	return $result->result();
  }
  
  /**
   * Mengeluarkan data tanggal SP2D dan jumlahnya
   * 
   * Mengeluarkan data tanggal SP2D dan jumlahnya
   *
   * @param		integer		$proposal_detail_id ID detail proposal
   * @param		string		$type "Proc" atau "Non-Proc"
   *
   * @return	object
   *
   */  
  public function get_sp2d_date($proposal_detail_id, $type = 'Proc') {
    $this->db->cache_off();
    $dates = array();
	if ($type == 'Proc') {
      $sql = sprintf('SELECT `pedp_FinancialReal`.`sp2d_date`, SUM(`pedp_FinancialRealDetail`.`value`) as `total_sp2d` FROM `pedp_FinancialRealDetail`
	     INNER JOIN `pedp_FinancialReal` ON `pedp_FinancialRealDetail`.`realization_id`=`pedp_FinancialReal`.`id` 
	     INNER JOIN `pedp_ProcurementImp` ON `pedp_FinancialRealDetail`.`impl_detail_id`=`pedp_ProcurementImp`.`proc_id`
	     INNER JOIN `pedp_ProcurementPlan` ON `pedp_ProcurementImp`.`proc_id`=`pedp_ProcurementPlan`.`id` 
	     WHERE `pedp_ProcurementImp`.`proc_id` = %d AND `pedp_FinancialRealDetail`.`impl_type`=\'Proc\' GROUP BY `pedp_FinancialReal`.`sp2d_date`', $proposal_detail_id);
	     // echo '<p>'.$sql.'</p>';
	} else {
      $sql = sprintf('SELECT `pedp_FinancialReal`.`sp2d_date`, SUM(`pedp_FinancialRealDetail`.`value`) as `total_sp2d` FROM `pedp_FinancialRealDetail`
	     INNER JOIN `pedp_FinancialReal` ON `pedp_FinancialRealDetail`.`realization_id`=`pedp_FinancialReal`.`id` 
	     INNER JOIN `pedp_NonProcurementImp` ON `pedp_FinancialRealDetail`.`impl_detail_id`=`pedp_NonProcurementImp`.`non_proc_id`
	     INNER JOIN `pedp_NonProcurementPlan` ON `pedp_NonProcurementImp`.`non_proc_id`=`pedp_NonProcurementPlan`.`id` 
	     WHERE `pedp_NonProcurementImp`.`non_proc_id` = %d AND `pedp_FinancialRealDetail`.`impl_type`=\'Non-Proc\' GROUP BY `pedp_FinancialReal`.`sp2d_date`', $proposal_detail_id);
	     // echo '<p>'.$sql.'</p>';
	}

    $result = $this->db->query($sql);
    foreach ($result->result() as $d) {
      $dates[] = $d;
    }
    return $dates;
  }
  
  public function get_sp2d_detail($plan_id, $type = 'Proc') {
	if ($type == 'Proc') {
      $sql = sprintf('SELECT `pedp_ProcurementImp`.*, `pedp_FinancialReal`.*, `pedp_FinancialRealDetail`.* FROM `pedp_FinancialRealDetail`
	     INNER JOIN `pedp_FinancialReal` ON `pedp_FinancialRealDetail`.`realization_id`=`pedp_FinancialReal`.`id`
	     INNER JOIN `pedp_ProcurementImp` ON `pedp_FinancialRealDetail`.`impl_detail_id`=`pedp_ProcurementImp`.`proc_id`
	     WHERE `pedp_FinancialRealDetail`.`impl_detail_id` = %d AND `impl_type`=\'Proc\'', $plan_id);
	} else {
      $sql = sprintf('SELECT `pedp_NonProcurementImp`.*, `pedp_FinancialReal`.*, `pedp_FinancialRealDetail`.* FROM `pedp_FinancialRealDetail`
	     INNER JOIN `pedp_FinancialReal` ON `pedp_FinancialRealDetail`.`realization_id`=`pedp_FinancialReal`.`id` 
	     INNER JOIN `pedp_NonProcurementImp` ON `pedp_FinancialRealDetail`.`impl_detail_id`=`pedp_NonProcurementImp`.`non_proc_id`
	     WHERE `pedp_FinancialRealDetail`.`impl_detail_id` = %d AND `impl_type`=\'Non-Proc\'', $plan_id);
	}

    $result = $this->db->query($sql);
    return $result->result();	
  }
  
  public function getProgressData($proc_id, $impl_type = 'Proc') {
	$sql = sprintf('SELECT `pedp_ProcProgressDetail`.*, `pedp_Status`.`status` FROM `pedp_ProcProgressDetail`
	  LEFT JOIN `pedp_Status` ON `pedp_ProcProgressDetail`.`prog_id`=`pedp_Status`.`id`
	  WHERE `pedp_ProcProgressDetail`.`proc_id`=%d AND `pedp_ProcProgressDetail`.`impl_type`=\'%s\'
	  GROUP BY `pedp_ProcProgressDetail`.`prog_id` ORDER BY `pedp_ProcProgressDetail`.`prog_date`', $proc_id, $impl_type);
    $result = $this->db->query($sql);
    return $result->result();	
  }
}