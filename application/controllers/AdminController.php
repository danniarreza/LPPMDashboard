<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Room','Event','User']);
	}

	public function index()
	{
		$this->dashboardPage();
	}

	public function dashboardPage()
	{
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}

		$header['css'][] = base_url('assets/bower_components/morris.js/morris.css');
		$header['css'][] = base_url('assets/bower_components/jvectormap/jquery-jvectormap.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');

		$header['currentmenu'] = "Dashboard";

		$this->load->view('header_admin', $header);
		$this->load->view('dashboard');
		// $this->load->view('footer');
	}

	public function form_user(){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$header['currentmenu'] = 'FormUser';
		$data['pimpinan'] = $this->Event->get_data_pimpinan();
		$data['room'] = $this->Room->getAllRoom();

		$this->load->view('header_admin', $header);
		$this->load->view('form_user',$data);
	}

	public function userAddHandler(){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		if ($_POST['jenis']=="pi") {
			$level = 1;
		}else if ($_POST['jenis'] == "se") {
			$level = 2;
		}else if ($_POST['jenis'] == "fr") {
			$level = 3;
		}
		$insert = array('username' => $_POST['username'], 'password' => md5($_POST['pass']), 'nama' => $_POST['nama'], 'JENIS_KELAMIN' => $_POST['jeniskelamin'], 'TANGGAL_LAHIR' => $_POST['TL'], 'NO_TELP' => $_POST['notelp'], 'JABATAN' => $_POST['jabatan'], 'STATUS' => "Aktif", 'email' => $_POST['email'], 'KETERANGAN' => $_POST['ket'], 'level' => $level );
		$this->User->insert_data_user($insert);
		redirect('AdminController/dashboardPage');
	}

	public function tabel_user(){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$header['currentmenu'] = 'TabelUser';
		$data['user'] = $this->User->get_data_user();

		$this->load->view('header_admin', $header);
		$this->load->view('tabel_user',$data);
	}

	public function form_edit_user($id){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$header['currentmenu'] = 'FormUser';
		$data['pimpinan'] = $this->Event->get_data_pimpinan();
		$data['room'] = $this->Room->getAllRoom();
		$data['selected'] = $this->User->select_user($id);

		$this->load->view('header_admin', $header);
		$this->load->view('form_edit_user',$data);
	}

	public function editUserHandler($id){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$update = array('username' => $_POST['username'], 'nama' => $_POST['nama'], 'JENIS_KELAMIN' =>$_POST['jeniskelamin'], 'TANGGAL_LAHIR' => $_POST['tanggallahir'], 'NO_TELP' => $_POST['notelp'], 'JABATAN' => $_POST['jabatan'], 'email' => $_POST['email'], 'KETERANGAN' => $_POST['ket'] );
		$hasil = $this->User->update_user($id,$update);
		redirect('AdminController/tabel_user');
	}

	public function delete_user($id){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$hasil = $this->User->delete_user($id);
		redirect('AdminController/tabel_user');
	}
}

	

?>