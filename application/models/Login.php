<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function cek_akun($username,$password){
		$query = $this->db->query("select * from user where username = '$username' and password = '$password'");
		if ($query->num_rows()==1) {
			return true;
		}else{
			return false;
		}
	}

	function get_akun($username,$password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        return $this->db->get('user')->row();
    }
}
?>