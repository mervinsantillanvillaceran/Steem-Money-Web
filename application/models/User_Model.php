<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all()
	{
		$query = $this->db->get('user');
		return $query->result();
	}

	public function add($data){
		$this->db->insert('user', $data);
	}

	public function delete($id){
		$this->db->where('id', $id);
		$this->db->delete('user');
	}

	public function edit($id, $data){
		$this->db->where('id', $id);
		$this->db->update('user', $data);
	}
}

/* End of file  */
/* Location: ./application/models/ */