<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Reports extends CI_Controller {
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
	  $this->load->model('Reports_model');
	  $this->load->model('Master_model');
	}
    
	/**
	 * Browser data Master 
	 */
	public function index($type, $page = 1)
	{
	  $type = strtolower($type);
	  $this->load->library('pagination');
      //pagination settings
	  $config['per_page'] = 30;
	  $config['base_url'] = site_url('/reports/index/'.$type);
	  $config['use_page_numbers'] = TRUE;
	  $config['num_links'] = 5;
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
	  $tahun = $this->input->get('tahun_anggaran');
	  if (!$tahun) {
		$tahun = date('Y');
	  }
	  $this->data['curr_year'] = $tahun;
	  
	  $filter = null;
	  
	  $is_print = $this->input->get('print');
	  if ($is_print == 'yes') {
		$this->data['print_view'] = true;
	  }

	  // list source of funds
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
	    $sof_list = $this->Master_model->getMasterData('SourceOfFund', 10, 'source_of_fund <> \'CIDA\'');
	  } else {
		$sof_list = $this->Master_model->getMasterData('SourceOfFund', 10);
	  }
	  
	  $pmu_grantee = $this->input->get('grantee');
	  // override user data
	  if ($pmu_grantee) {
		$this->db->where(array('id' => $pmu_grantee));
		$grantee_query = $this->db->get('Grantee');
		$grantee_data = $grantee_query->row();
		$this->data['user_data']['grantee_id'] = $grantee_data->id;
		$this->data['user_data']['realname'] = $grantee_data->name_of_grantee;
	    // get grantee schema
	    $this->db->select('GranteeSchema.schema_id, Schema.schema_name');
	    $this->db->join('Schema', 'GranteeSchema.schema_id=Schema.id');
	    $this->db->where(array('grantee_id' => $grantee_data->id));
	    $query = $this->db->get('GranteeSchema');
	    $schemas = array();
	    foreach ($query->result() as $data) {
		  $schemas[$data->schema_id] = array('id' => $data->schema_id, 'name' => $data->schema_name);
	    }
	    $this->data['user_data']['schema'] = $schemas;
	    $this->data['grantee_id'] = $grantee_data->id;
	  } else {
	    // get schema for current grantee
	    $this->db->select('GranteeSchema.schema_id, Schema.schema_name');
	    $this->db->join('Schema', 'GranteeSchema.schema_id=Schema.id');
	    $this->db->where(array('grantee_id' => $this->data['user_data']['grantee_id']));
	    $query = $this->db->get('GranteeSchema');
	    $schemas = array();
	    foreach ($query->result() as $data) {
		  $schemas[$data->schema_id] = array('id' => $data->schema_id, 'name' => $data->schema_name);
	    }
	    $this->data['user_data']['schema'] = $schemas;
		$this->data['grantee_id'] = $this->data['user_data']['grantee_id'];
	  }
	  
	  if ('pmu' != $this->data['user_data']['groups'] && 'admin' != $this->data['user_data']['groups']) {
		// $criteria['grantee_id'] = $this->data['user_data']['grantee_id'];
		$criteria = sprintf('`pedp_Proposal`.`grantee_id`=\'%s\'', $this->data['user_data']['grantee_id']);
		if ($tahun) {
		  $criteria .= ' AND `pedp_Proposal`.`year`=\''.$tahun.'\'';
		}
	  } else {
		$criteria = null;
		if ($tahun) {
		  $criteria = '`pedp_Proposal`.`year`=\''.$tahun.'\'';
		}
	  }
	  
	  if ($type == '1a') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_FinancialProjComp.name_of_fpc LIKE $keywords";
	    }
	    $this->load->model('Rpp_model');
	    $this->load->model('Proc_model');
	    $this->load->model('Non_proc_model');
		$rpp_detail = $this->Rpp_model->getDetail(sprintf('year=\'%d\' AND grantee_id=\'%s\'', $this->data['curr_year'], $this->data['grantee_id']));
		$this->data['curr_quarter'] = $this->input->get('quarter');
		if (!$this->data['curr_quarter']) {
		  $this->data['curr_quarter'] = get_quarter_of_date(date('Y-m-d'));
		}
		
		if ($this->data['curr_quarter'] == 1) {
		  $this->data['quarter_month_start'] = 1;
		  $this->data['quarter_month_end'] = 3;
		} else if ($this->data['curr_quarter'] == 2) {
		  $this->data['quarter_month_start'] = 4;
		  $this->data['quarter_month_end'] = 6;
		} else if ($this->data['curr_quarter'] == 3) {
		  $this->data['quarter_month_start'] = 7;
		  $this->data['quarter_month_end'] = 9;
		} else if ($this->data['curr_quarter'] == 4) {
		  $this->data['quarter_month_start'] = 10;
		  $this->data['quarter_month_end'] = 12;
		}
		
		$this->data['date_start'] = $this->data['curr_year'].'-'.( $this->data['quarter_month_start']<10?'0'.$this->data['quarter_month_start']:$this->data['quarter_month_start'] ).'-01';
		$this->data['date_end'] = $this->data['curr_year'].'-'.( $this->data['quarter_month_end']<10?'0'.$this->data['quarter_month_end']:$this->data['quarter_month_end'] ).'-31';

		$this->data['criteria'] = $criteria;
		$this->data['sof_list'] = $sof_list;
		$this->data['rpp_detail'] = $rpp_detail;
	  }
	  else if ($type == '1c') {
	    $this->load->model('Rpp_model');
	    $this->load->model('Proc_model');
	    $this->load->model('Non_proc_model');		
		$rpp_detail = $this->Rpp_model->getDetail(sprintf('year=\'%d\' AND grantee_id=\'%s\'', $this->data['curr_year'], $this->data['grantee_id']));

		$this->data['sof_list'] = $sof_list;
		$this->data['rpp_detail'] = $rpp_detail;
	  }
	  else if ($type == '1e') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_FinancialProjComp.name_of_fpc LIKE $keywords";
	    }
	    $this->load->model('Rpp_model');
	    $this->load->model('Proc_model');
	    $this->load->model('Non_proc_model');
		// get source of funds data
		$sof_list = $this->Master_model->getMasterData('SourceOfFund', 10);
		$rpp_detail = $this->Rpp_model->getDetail(sprintf('year=\'%d\' AND grantee_id=\'%s\'', $this->data['curr_year'], $this->data['grantee_id']));
		$this->data['curr_quarter'] = $this->input->get('quarter');
		if (!$this->data['curr_quarter']) {
		  $this->data['curr_quarter'] = get_quarter_of_date(date('Y-m-d'));
		}
		
		if ($this->data['curr_quarter'] == 1) {
		  $this->data['quarter_month_start'] = 1;
		  $this->data['quarter_month_end'] = 3;
		  $this->data['quarter_month_end_text'] = 'March';
		} else if ($this->data['curr_quarter'] == 2) {
		  $this->data['quarter_month_start'] = 4;
		  $this->data['quarter_month_end'] = 6;
		  $this->data['quarter_month_end_text'] = 'June';
		} else if ($this->data['curr_quarter'] == 3) {
		  $this->data['quarter_month_start'] = 7;
		  $this->data['quarter_month_end'] = 9;
		  $this->data['quarter_month_end_text'] = 'September';
		} else if ($this->data['curr_quarter'] == 4) {
		  $this->data['quarter_month_start'] = 10;
		  $this->data['quarter_month_end'] = 12;
		  $this->data['quarter_month_end_text'] = 'December';
		}
		
		$this->data['date_start'] = $this->data['curr_year'].'-'.( $this->data['quarter_month_start']<10?'0'.$this->data['quarter_month_start']:$this->data['quarter_month_start'] ).'-01';
		$this->data['date_end'] = $this->data['curr_year'].'-'.( $this->data['quarter_month_end']<10?'0'.$this->data['quarter_month_end']:$this->data['quarter_month_end'] ).'-31';

		$this->data['criteria'] = $criteria;
		$this->data['sof_list'] = $sof_list;
		$this->data['rpp_detail'] = $rpp_detail;
	  }
	  else if ($type == '2b') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_FinancialProjComp.name_of_fpc LIKE $keywords";
	    }
	    $this->load->model('Rpp_model');
	    $this->load->model('Master_model');
	    $this->load->model('Proc_model');
	    $this->load->model('Non_proc_model');
		// get source of funds data
		$sof_list = $this->Master_model->getMasterData('SourceOfFund', 10);
		$rpp_detail = $this->Rpp_model->getDetail(sprintf('year=\'%d\' AND grantee_id=\'%s\'', $this->data['curr_year'], $this->data['grantee_id']));
		$this->data['curr_quarter'] = $this->input->get('quarter');
		if (!$this->data['curr_quarter']) {
		  $this->data['curr_quarter'] = get_quarter_of_date(date('Y-m-d'));
		}
		
		if ($this->data['curr_quarter'] == 1) {
		  $this->data['quarter_month_start'] = 1;
		  $this->data['quarter_month_end'] = 3;
		  $this->data['quarter_month_end_text'] = 'March';
		} else if ($this->data['curr_quarter'] == 2) {
		  $this->data['quarter_month_start'] = 4;
		  $this->data['quarter_month_end'] = 6;
		  $this->data['quarter_month_end_text'] = 'June';
		} else if ($this->data['curr_quarter'] == 3) {
		  $this->data['quarter_month_start'] = 7;
		  $this->data['quarter_month_end'] = 9;
		  $this->data['quarter_month_end_text'] = 'September';
		} else if ($this->data['curr_quarter'] == 4) {
		  $this->data['quarter_month_start'] = 10;
		  $this->data['quarter_month_end'] = 12;
		  $this->data['quarter_month_end_text'] = 'December';
		}
		
		$this->data['date_start'] = $this->data['curr_year'].'-'.( $this->data['quarter_month_start']<10?'0'.$this->data['quarter_month_start']:$this->data['quarter_month_start'] ).'-01';
		$this->data['date_end'] = $this->data['curr_year'].'-'.( $this->data['quarter_month_end']<10?'0'.$this->data['quarter_month_end']:$this->data['quarter_month_end'] ).'-31';

		$this->data['criteria'] = $criteria;
		$this->data['sof_list'] = $sof_list;
		$this->data['rpp_detail'] = $rpp_detail;
	  }
	  else if ($type == 'g1') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_FinancialProjComp.name_of_fpc LIKE $keywords";
	    }
		$this->data['records'] = $this->Reports_model->report_g1($config['per_page'], $criteria, $total_rows, $page);
		$this->data['total_rows'] = $total_rows;
		$config['total_rows'] = $total_rows;
	  } 
	  else if ($type == 'g2') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_ProposalDetail.package_id LIKE $keywords";
	    }
	  	$this->data['records'] = $this->Reports_model->report_g2($config['per_page'], $criteria, $total_rows, $page);
	  	$this->data['total_rows'] = $total_rows;
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == 'g3') {	  
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_ProposalDetail.package_id LIKE $keywords";	
	    }
		$this->data['records'] = $this->Reports_model->report_g3($config['per_page'], $criteria, $total_rows, $page);
		$this->data['total_rows'] = $total_rows;
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == '3a') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_ProposalDetail.package_id LIKE $keywords";	
	    }
		// query data progress proc
		$this->db->where(array('proc_or_nonproc' => 'Proc'));
		$progress_status = $this->db->get('Status');
		$this->data['progress_status'] = $progress_status->result();
		$this->data['progress_num'] = $progress_status->num_rows();
		
		$this->data['records'] = $this->Reports_model->report_3a($config['per_page'], $criteria, $total_rows, $page);
		$this->data['total_rows'] = $total_rows;
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == '3b') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_ProposalDetail.package_id LIKE $keywords";	
	    }
		// query data progress Non-proc
		$this->db->where(array('proc_or_nonproc' => 'Proc'));
		$progress_status = $this->db->get('Status');
		$this->data['progress_status'] = $progress_status->result();
		$this->data['progress_num'] = $progress_status->num_rows();
		
		$this->data['records'] = $this->Reports_model->report_3b($config['per_page'], $criteria, $total_rows, $page);
		$this->data['total_rows'] = $total_rows;
		$config['total_rows'] = $total_rows;
	  }
	  else if ($type == '3c') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_ProposalDetail.package_id LIKE $keywords";	
	    }
		$this->data['criteria'] = $criteria;
		$this->data['total_rows'] = 0;
		$config['total_rows'] = 0;
	  }
	  else if ($type == '3d') {
	    if($keywords) {
		  $keywords = $this->db->escape('%'.$keywords.'%');
		  $criteria .= " AND pedp_ProposalDetail.package_id LIKE $keywords";	
	    }
		$this->data['criteria'] = $criteria;
		$this->data['total_rows'] = $total_rows;
		$config['total_rows'] = $total_rows;
	  }

      $this->data['total_rows'] = $total_rows;
      $this->pagination->initialize($config);
      $this->data['pagination'] = $this->pagination->create_links();
      $this->load->view('reports/browse/'.$type, $this->data);
	}

	/**
	 * achievement report
	 */
	public function achievement()
	{
       $this->load->view('reports/browse/achievement', $this->data);
	}
}
