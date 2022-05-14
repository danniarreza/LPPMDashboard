<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function insert_data_user($data){
		$this->db->insert('user', $data);
	}

	public function get_data_user(){
		return $query = $this->db->query("select id,username, nama, JENIS_KELAMIN, TANGGAL_LAHIR, NO_TELP, JABATAN, KETERANGAN, STATUS, email from user");
	}

	public function select_user($id){
		return $query = $this->db->query("select id,username, nama, JENIS_KELAMIN, TANGGAL_LAHIR, NO_TELP, JABATAN, KETERANGAN, STATUS, email from user where id = '$id'");
	}

	public function update_user($id,$data){
		$this->db->update('user',$data, array('id' => $id ));
	}

	public function delete_user($id){
		$this->db->delete('user', array('id' => $id ));
	}
}
?>