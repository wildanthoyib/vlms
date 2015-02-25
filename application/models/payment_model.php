<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Arie Nugraha 2014 | Wildan Toyib 2014       | Dimas Septyanto 2014
 * dicarve@gmail.com | sr.t.wildan@ieee.org    | dimaseptyanto@windowslive.com
 */
class Payment_model extends CI_Model {
  function getData($criteria = '', $page = 1, $limit = 20) {
    $this->db->cache_off();
    if ($criteria) {
      $this->db->where($criteria);
    }
    $query = $this->db->get('pedp_RecapitulationPayment', $limit);
    return $query->result();
  }
}
