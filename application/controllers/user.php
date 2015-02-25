<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */

class User extends CI_Controller {
	public $content = array();
	private $max_list = 20;
    protected $grup_login = array(
      'admin', 'PIU', 'PMU'
    );

    public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if (!$this->session->userdata('logged_in')) {
          redirect('/login/index', 'refresh');
        }

		// content default
		$this->content['session_data'] = $this->session->all_userdata();
		$this->content['groups'] = $this->grup_login;
	}

	public function index($page = 1) {
	  $total_rows = 0;
	  $offset = ($this->max_list*$page)-$this->max_list;
	  
	  $criteria = '';
	  
	  $this->db->limit($this->max_list, $offset);
	  $query = $this->db->get('Users');
	  $total_rows = $query->num_rows();
	  $datauser = array();
	  foreach ($query->result_array() as $row) {
		$datauser[] = $row;
	  }
	  
	  $this->content['datauser'] = $datauser;
	  
	  // paging
	  $this->load->library('pagination');
	  $config['base_url'] = site_url('user/index');
	  $config['total_rows'] = $total_rows;
	  $config['per_page'] = $this->max_list;
	  $this->pagination->initialize($config);
	  
	  $this->content['paging'] = $this->pagination->create_links();
	  $this->content['total_rows'] = $total_rows;
	  
	  $this->load->view('user/daftar', $this->content);
	}
	
	public function update($user_id = 0) {
	  // ambil data user
	  $this->db->where('id', $user_id);
	  $this->db->limit(1);
	  $query = $this->db->get('Users');
	  
	  $detail = $query->row_array();
	  
	  $this->content['detail_user'] = $detail;
	  $this->load->view('/user/update', $this->content);
	}
	
	public function simpan($tipe = 'detail') {
	  $passwd1 = $this->input->post('passwd1');
	  $passwd2 = $this->input->post('passwd2');
	  if ($passwd1 !== $passwd2) {
		redirect('/user/update/password-failed', 'refresh');
		return false;
	  }
		
	  $tgl_update = date('Y-m-d H:i:s');
	  $this->db->set('username', $this->input->post('userName'));
	  $this->db->set('realname', $this->input->post('realName'));
	  $this->db->set('groups', @serialize($this->input->post('groups')));
	  if ($passwd2) {
		$this->db->set('passwd', 'SHA1(\''.$passwd2.'\')', false);
	  }
	  $this->db->set('last_update', $tgl_update);
      
	  if ($updateID = $this->input->post('updateID')) {
        $this->db->where('id', $updateID);
        $this->db->update('Users');		
	  } else {
		$this->db->insert('Users');
	  }

	  redirect('/user/index');
	}
}
