<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Login');
	}

	public function index($error = NULL)
	{
		$data = array(
            'title' => 'Login Page',
            'action' => site_url('LoginController/do_login'),
            'error' => $error
        );
		$this->load->view('page_login',$data);
	}

	public function do_login(){
		$cek = $this->Login->cek_akun($_POST['username'], md5($_POST['password']));
		if ($cek) {
			$hasil= $this->Login->get_akun($_POST['username'], md5($_POST['password']));
			$data = array(
                'loggedin' => TRUE,
                'id' => $hasil->id,
                'level' => $hasil->level,
                'username' => $hasil->username,
                'nama' => $hasil->nama,
                'foto' => $hasil->FOTO_PROFIL,
                'jabatan' => $hasil->JABATAN
            );
            $this->session->set_userdata($data);
            if ($_SESSION['level']==0) {
            	redirect(site_url('AdminController'));
            }else{
            	redirect(site_url('DashboardController'));
            }
		} else {
            $error = 'username / password salah';
            $this->index($error);
        }
	}

	public function logout(){
		$this->session->sess_destroy();
        $data = array(
            'title' => 'Login Page',
            'action' => site_url('controlLogin/do_login'),
            'error' => ""
        );
        $this->load->view('page_login', $data);
	}
}

?>