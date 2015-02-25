<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Dashboard extends CI_Controller {
    private $data = array();

	public function __construct()
	{
	  parent::__construct();
	  $this->data['main_content'] = '';
	  $this->data['user_data'] = $this->session->userdata('is_logged_in');
	  $this->data['user_data']['schema'] = $this->session->userdata('schema');
	  if (!isset($this->data['user_data']['username'])) {
		redirect('/login');
		return;
	  }
	}

	public function index()
	{
		
	  $is_print = $this->input->get('print');
	  
	  if ($is_print == 'yes') {
		$this->data['print_view'] = true;
	  }
	  
	  $current_year = date('Y');
	  $year = $this->input->get('year');
	  if ($year) {
		$current_year = $year;
	  }
	  
	  $this->data['current_year'] = $current_year;
	  
	  $this->load->model('Rpp_model');
	  
	  $this->load->model('Master_model');
	  
	  $pmu_grantee = $this->input->get('pmu_grantee');
	  
	  $this->data['default_rpp'] = 0;
	  
	  //$criteria['grantee_id'] = $pmu_grantee?$pmu_grantee:$this->data['user_data']['grantee_id'];
	  
	  /*
	  $this->data['list_rpp'] = $this->Rpp_model->getData($criteria);
	  
	  // ambil data RPP terakhir
	  $search_rpp = $this->input->get('rpp');
	  if ($this->data['list_rpp']) {
	    foreach ($this->data['list_rpp'] as $rpp) {
		  if ($search_rpp && $rpp->id == $search_rpp) {
		    $this->data['default_rpp'] = $search_rpp;
		    $this->data['default_rpp_name'] = $rpp->contract;
			break;
		  } else if ($rpp->year == $current_year) {
		    $this->data['default_rpp'] = $rpp->id;
		    $this->data['default_rpp_name'] = $rpp->contract;
			break;
		  } else {
		    $this->data['default_rpp'] = $rpp->id;
		    $this->data['default_rpp_name'] = $rpp->contract;
		  }
		}
	  } else {
	    $this->data['default_rpp'] = 0;
	    $this->data['default_rpp_name'] = 'BELUM ADA DATA';
	  }
*/
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
	  }
	  
	  $this->data['list_sf'] = null;//$this->Master_model->getMasterData('SourceOfFund', 100);
	  if ('pmu' == $this->data['user_data']['groups'] || 'admin' == $this->data['user_data']['groups'] || 'reviewer' == $this->data['user_data']['groups']) {
		$this->data['list_grantee'] = null;//$this->Master_model->getMasterData('Grantee', 100);
		if ($pmu_grantee) {
		  $this->data['pmu_grantee'] = $pmu_grantee;
		  $this->load->view('main', $this->data);
		} else {
		  $this->load->view('main_pmu', $this->data);	
		}
	  } else {
	    $this->load->view('main', $this->data);
	  }
	}
	
    public function help()
    {
	  $this->load->view('help/help', $this->data);
    }
    
	public function penugasan()
    {
	  $this->load->view('help/penugasan', $this->data);
    }
    
    public function panduan()
    {
	  $this->load->view('help/panduan', $this->data);
    }
    
	public function dokumentasi()
    {
	  $this->load->view('help/dokumentasi', $this->data);
    }
    
	public function kosakata()
    {
	  $this->load->view('help/kosakata', $this->data);
    }
    
    
    
 /**  
	public function input_rpp()
    {
	  $this->load->view('help/input_rpp', $this->data);
    }
    
	public function proc_help()
    {
	  $this->load->view('help/proc_help', $this->data);
    }
    
	public function nonproc_help()
    {
	  $this->load->view('help/nonproc_help', $this->data);
    }
    
	public function disbursement_help()
    {
	  $this->load->view('help/disbursement_help', $this->data);
    }
**/
 
}
