<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_student extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    protected $_table = 'student';

    public function _init($val = array()){
        if (!empty($val['stu_id'])) {
            if (is_array($val['stu_id'])) {
                $this->db->where_in('stu_id', $val['stu_id']);
            }else{
                $this->db->where('stu_id', $val['stu_id']);
            }
        }
        if (!empty($val['code'])) {
            $this->db->where_in('code', $val['code']);
        }
        if (!empty($val['name'])) {
            $this->db->like('name', $val['name']);
        }
        if (!empty($val['card_id'])) {
            $this->db->where('card_id', $val['card_id']);
        }
        if (!empty($val['email'])) {
            $this->db->where('email', $val['email']);
        }
        if (!empty($val['status'])) {
            $this->db->where('status', $val['status']);
        }
        if (!empty($val['where'])) {
            $this->db->where($val['where']);
        }
        if (!empty($val['select'])) {
            $this->db->select($val['select']);
        }
        if ($this->session->user['type'] == 2) {
            $this->db->where('col_id = '.$this->session->user['type_id']);
        }
        if ($this->session->user['type'] == 3) {
            $this->db->where('spe_id = '.$this->session->user['type_id']);
        }
    }

	public function get($val = array())
	{
        $this->_init($val);
        return $this->db->get($this->_table)->row_array();
    }

    public function top($val = array())
	{
        $this->_init($val);
        return $this->db->get($this->_table)->result_array();
    }
    
    public function count($val = array())
	{
        $this->_init($val);
        $this->db->select('count(*) as count');
        return $this->db->get($this->_table)->row_array()['count'];
    }
    
    public function lists($val = array())
	{
        $this->_init($val);
        
        $this->db->limit($this->pagination->per_page, $this->uri->segment(4));
        return $this->db->get($this->_table)->result_array();
    }
    
    public function add($val = array())
	{
        $val['time'] = date('Y-m-d H:i:s');
        $val['status'] = 1;
        return $this->db->insert($this->_table, $val);
    }
    
    public function delete($val = array())
	{
        $this->_init($val);
        return $this->db->delete($this->_table);
    }
    
    public function update($val = array())
	{
        $this->db->where('stu_id', $val['stu_id']);
        return $this->db->update($this->_table, $val);
    }
}
