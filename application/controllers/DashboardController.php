<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Agenda','User','Event','Reservation','GuestBook']);
		$this->load->helper('file');
	}

	public function index()
	{
		$this->dashboardPage();
	}

	public function form_fotoprofil(){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}

		$header['css'][] = base_url('assets/bower_components/morris.js/morris.css');
		$header['css'][] = base_url('assets/bower_components/jvectormap/jquery-jvectormap.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');

		$header['currentmenu'] = "";

		$this->load->view('header', $header);
		$this->load->view('form_upload_foto');
	}

	public function gantiFotoHandler($id){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$config['upload_path']          = 'fotoprofil/';
		$config['allowed_types']        = 'png|jpg|jpeg';
		$config['max_size']             = 10000;
		$this->load->library('upload', $config);
		$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["fotoprofile"]["name"]));
		move_uploaded_file($_FILES["fotoprofile"]["tmp_name"], "fotoprofil/" . $newfilename);

		$referenceletterpath = "fotoprofil/".$newfilename;
		$update = array('FOTO_PROFIL' => $newfilename );
		$hasil = $this->User->update_user($id, $update);
		redirect('DashboardController');
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

		if ($_SESSION['level']==1) {
			$data['agendabelumapprove'] = $this->Agenda->jumlah_agenda_belum_approve($_SESSION['id']);
			$data['jumlahscheduletoday'] = $this->Agenda->jumlah_agenda_today($_SESSION['id'],date('Y-m-d'));
			$data['tolak'] = $this->Agenda->jumlah_agenda_ditolak($_SESSION['id']);
			$data['confirm'] = $this->Agenda->jumlah_agenda_diconfirm($_SESSION['id']);
			$data['eventtoday'] = $this->Agenda->event_today($_SESSION['id'],date('Y-m-d'));	
		}elseif($_SESSION['level']==2){
			$data['agendabelumapprove'] = $this->Event->jumlahEventHariIni(date('Y-m-d'));
			$data['jumlahscheduletoday'] = $this->Reservation->jumlahReservationHariIni(date('Y-m-d'));
			$data['tolak'] = $this->Event->jumlahEventBulanIni(date('m'),date('Y'));
			$data['confirm'] = $this->Reservation->jumlahReservationBulanIni(date('m'));
		}elseif ($_SESSION['level']==3) {
			$data['confirm'] = $this->GuestBook->jumlahTamuHariIni(date('Y-m-d'));
			$data['tolak'] = $this->GuestBook->jumlahTamuBulanIni(date('m'));
		}

		$this->load->view('header', $header);
		$this->load->view('dashboard', $data);
		// $this->load->view('footer');
	}

	public function dashboardEmailHandler()
	{
		$recipientaddress = $this->input->post('emailto');
		$recipientname = '';
		$subject = $this->input->post('subject');
		$body = $this->input->post('body');

		$this->dashboardEmailSender($recipientname, $recipientaddress, $subject, $body);
	}

	public function dashboardEmailSender($recipientname, $recipientaddress, $subject, $body)
	{
		// Load the config file
		require_once(APPPATH.'libraries/PHPMailer/config.php');

		// Include functions
		require_once(APPPATH.'libraries/PHPMailer/sendfunction.php');

		// If you want to send to multiple recipient

		// $to = array(
		// 	array(
		// 		'name' 	=> $recipientname,
		// 		'email'	=> $recipientaddress
		// 	),
		// 	array(
		// 		'name' 	=> '',
		// 		'email'	=> 'danniarreza@gmail.com'
		// 	),
		// );

		// $subject = 'This was sent via PHPMailer SERVER';
		// $body = '<h3>This is a title.</h3><p>This is some text.</p>';
		// $from = array('name' => 'Danniar Reza Firdausy', 'email' => 'danniarreza@gmail.com');

		$to = array(
			array(
				'name' 	=> $recipientname,
				'email'	=> $recipientaddress
			),
		);

		$from = array('name' => 'Front Desk LPPM UB', 'email' => 'danniarreza@gmail.com');

		// Create a new instance and send the email
		$mailer = new Mailer(true);
		$mailer->mail($to, $subject, $body, $from);

		redirect('DashboardController/');
	}

}

?>