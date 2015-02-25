<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
 
class Login extends CI_Controller
{
  public $content = array();
  protected $redirect_after_login = '/dashboard/index';
  
  public function __construct() {
    parent::__construct();
  }
  
  /**
   * Tampilkan halaman login
   */
  public function index($status = '') {
    $this->content['status'] = $status;
    if ($this->session->userdata('logged_in')) {
      redirect($this->redirect_after_login);
    } else {
      $this->load->view('/login/index', $this->content);  
    }
  }

  /**
   * Logout
   */  
  public function logout() {
    $this->session->sess_destroy();
    redirect('/login/index/logout', 'refresh');
  }

  /**
   * Logout
   */  
  public function profile() {
	$this->data['user_data'] = $this->session->userdata('is_logged_in');
	$this->data['user_data']['schema'] = $this->session->userdata('schema');
    $this->load->view('/login/profile', $this->data);
  }

  /**
   * Proses validasi login ke database
   */
  public function check_login() {
	  //bypass dulu ya @cesar
    $username = 'Budi';//$this->input->post('username');
    $passw = '123456';//$this->input->post('password');
  
    //query the database
    //$result = $this->login($username, $passw);
    // var_dump($result); die();
	
	//data dummy
	$result = new stdClass;
	$result->id = "001";
	$result->username = "Budi";
	$result->realname = "Budi Ajah";
	$result->groups = "001";
	$result->grantee_id = "123";
	$result->schema_id = "123456";
	$result->schema_name = "nama_skema";
	
    if ($result) {
      $sess_array = array(
        'id' => $result->id, 'username' => $result->username,
        // 'realname' => $result->realname, 'groups' => @unserialize($result->groups),
		'realname' => $result->realname, 'groups' => $result->groups,
		'grantee_id' => $result->grantee_id
      );
      $this->session->set_userdata('logged_in', $sess_array);
      $this->session->set_userdata('is_logged_in', $sess_array);
	  
	  // get grantee schema
	  //$this->db->select('GranteeSchema.schema_id, Schema.schema_name');
	  //$this->db->join('Schema', 'GranteeSchema.schema_id=Schema.id');
	  //$this->db->where(array('grantee_id' => $result->grantee_id));
	  //$query = $this->db->get('GranteeSchema');
	  
	  $schemas = array(
		'id'	=> '123123123',
		'name'	=> 'nama_skema'
	  );
	  
	  //foreach ($query->result() as $data) {
		//$schemas[$data->schema_id] = array('id' => $data->schema_id, 'name' => $data->schema_name);
	  //}
	  $this->session->set_userdata('schema', $schemas);

      redirect($this->redirect_after_login, 'refresh');
      return true;
    } else {
      redirect('/login/index/failed', 'refresh', '$error_message');
      return false;
    }
  }
  
  /**
   * query login ke database
   */
  private function login($username, $password)
  {
    $this->db->select('*');
    $this->db->from('Users');
    $this->db->where(sprintf('username=\'%s\' AND passwd=SHA1(\'%s\')', $username, $password), null, false);
    $this->db->limit(1);
    $query = $this->db->get();
  
    if($query->num_rows() == 1) {
      return $query->row();
    } else {
      return false;
    }
  }
}