<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AppointmentController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(['Agenda','Room','Event']);

		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		} else if ($_SESSION['level']==3){
			redirect('DashboardController');
		} else if($_SESSION['level']==0){
			redirect('AdminController');
		}
	}

	public function index()
	{
		$this->appointmentPage();
	}

	public function appointmentPage()
	{
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}		
		$header['currentmenu'] = "Appointment";
		if ($_SESSION['level']==2) {
			$data['schedule'] = $this->Agenda->get_all_schedule()->result();
			$data['listevent'] = $this->Agenda->list_event();
			$data['room'] = $this->Room->getAllRoom();
			$data['pimpinan'] = $this->Event->get_data_pimpinan();
		}else if ($_SESSION['level']==1) {
			$data['listevent'] = $this->Agenda->list_event();
			$data['room'] = $this->Room->getAllRoom();
			$data['schedule'] = $this->Agenda->select_all_schedule($_SESSION['id'])->result();
		}else if ($_SESSION['level']==3) {
			$data['schedule'] = $this->Agenda->get_all_schedule()->result();
			$data['listevent'] = $this->Agenda->list_event();
			$data['room'] = $this->Room->getAllRoom();
			$data['pimpinan'] = $this->Event->get_data_pimpinan();
		}
		$this->load->view('header', $header);
		$this->load->view('appointment', $data);
		// $this->load->view('footer');
	}

	public function confirm_agenda($id){
		$data['event'] = $this->Agenda->selectEvent($id);
		$pimpinan = $data['event'][0]['ID_USER'];
		$time1 = date('H:i', strtotime($data['event'][0]['tanggal_mulai']));
		$time2 = date('H:i', strtotime($data['event'][0]['tanggal_end']));
		$tanggal = date('Y-m-d', strtotime($data['event'][0]['tanggal_mulai']));
		$data['cek'] = $this->Agenda->cekAgenda($pimpinan,$tanggal,$time1,$time2);
		if (isset($data['cek'][0])) {
			// echo "<pre>";
			// var_dump($data['cek']);
			// echo "</pre>";
			// exit();
			$header['currentmenu'] = "Appointment";
			$data['listevent'] = $this->Agenda->list_event();
			$data['room'] = $this->Room->getAllRoom();
			$data['schedule'] = $this->Agenda->select_all_schedule($_SESSION['id'])->result();
			$this->load->view('header',$header);
			$this->load->view('appointment', $data);
		}else{
			$update = array('STATUS' => "Confirmed" );
			$hasil = $this->Agenda->confirm_agenda($update, $id);
			redirect('AppointmentController');
		}
	}

	public function tolak_agenda($id){
		$update = array('STATUS' => "Ditolak" );
		$hasil = $this->Agenda->confirm_agenda($update, $id);
		redirect('AppointmentController');
	}

	public function add_event(){
		if (isset($_SESSION['loggedin'])==false) {
			redirect('LoginController');
		}
		$token = strtok($_POST['agendatime'], " ");
		$datestart = $token; // dd/mm/yyyy
		$datestart = implode("-", array_reverse(explode("/", $datestart))); // yyyy-mm-dd
		$timestart = strtok(" ").' '.strtok(" ");
		strtok(" "); // 8:00 PM
		$timestart = DateTime::createFromFormat('g:i a', $timestart)->format('H:i'); // 20:00
		$timestampstart = $datestart." ".$timestart.":00"; //yyyy-mm-dd HH:ii:ss

		$dateend = strtok(" "); // dd/mm/yyyy
		$dateend = implode("-", array_reverse(explode("/", $dateend))); // yyyy-mm-dd
		$timeend = strtok(" ").' '.strtok(" "); // 8:00 PM
		$timeend = DateTime::createFromFormat('g:i a', $timeend)->format('H:i'); // 20:00
		$timestampend = $dateend." ".$timeend.":00"; //yyyy-mm-dd HH:ii:ss

		if ($_POST['agendalocation']=="Lainnya") {
			$agendalocation = $_POST['eventlocationlain'];
		}else{
			$agendalocation = $_POST['agendalocation'];
		}
		if ($_POST['repeat']==null) {
			$repeat = 1;
		}else{
			$repeat = $_POST['repeat'];
		}
		if ($_SESSION['level']==2) {
			for ($i=0; $i < $repeat ; $i++) {
				$insert = array('ID_USER' => $_POST['pimpinan'], 'TITLE' => $_POST['agendatitle'], 'DESCRIPTION' => $_POST['agendadesc'], 'LOCATION' => $agendalocation, 'JENIS_AGENDA' => $_POST['agenda'], 'TIME_START' => $timestampstart, 'TIME_END' => $timestampend, 'status' => "Request");		
				$timestampend = date('Y-m-d H:i:s', strtotime('+7 day'.$timestampend));
				$timestampstart = date('Y-m-d H:i:s', strtotime('+7 day'.$timestampstart));
				$hasil = $this->Agenda->insertNewAgenda($insert);
			}
		}else{
			for ($i=0; $i < $repeat ; $i++) { 
				$insert = array('ID_USER' => $_SESSION['id'], 'TITLE' => $_POST['agendatitle'], 'DESCRIPTION' => $_POST['agendadesc'], 'LOCATION' => $agendalocation, 'JENIS_AGENDA' => $_POST['agenda'], 'TIME_START' => $timestampstart, 'TIME_END' => $timestampend, 'status' => "Confirmed");
				$timestampend = date('Y-m-d H:i:s', strtotime('+7 day'.$timestampend));
				$timestampstart = date('Y-m-d H:i:s', strtotime('+7 day'.$timestampstart));
				$hasil = $this->Agenda->insertNewAgenda($insert);
			}
		}
		$this->appointmentPage();
	}

	public function detailEvent($id){
		$data['event'] = $this->Agenda->selectEvent($id);
		$this->load->view('detail_event', $data);
	}

	public function add_data_event(){
		$insert = array('NAME' => $_POST['title'], 'COLOR' => $_POST['color'] );
		$hasil = $this->Agenda->input_data_event($insert);
		redirect('AppointmentController/appointmentPage');
	}

	public function delete_data_event($id){
		$delete = $this->Agenda->delete_event($id);
		redirect('AppointmentController/appointmentPage');
	}

	public function form_edit_agenda($id){

		$header['css'][] = base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');

		$header['currentmenu'] = 'EditAgenda';
		$data['room'] = $this->Room->getAllRoom();
		$data['pimpinan'] = $this->Event->get_data_pimpinan();
		$data['event'] = $this->Agenda->selectEvent($id);
		$data['listevent'] = $this->Agenda->list_event();

		$this->load->view('header', $header);
		$this->load->view('form_edit_agenda', $data);
	}

	public function editAgendaHandler($id){

		$token = strtok($this->input->post('eventtimestart'), " ");
		$datestart = $token; // dd/mm/yyyy
		$datestart = implode("-", array_reverse(explode("/", $datestart))); // yyyy-mm-dd
		$timestart = strtok(" ").' '.strtok(" ");
		strtok(" "); // 8:00 PM
		$timestart = DateTime::createFromFormat('g:i a', $timestart)->format('H:i'); // 20:00
		$timestampstart = $datestart." ".$timestart.":00"; //yyyy-mm-dd HH:ii:ss

		$token = strtok($this->input->post('eventtimeend'), " ");
		$dateend = $token; // dd/mm/yyyy
		$dateend = implode("-", array_reverse(explode("/", $dateend))); // yyyy-mm-dd
		$timeend = strtok(" ").' '.strtok(" "); // 8:00 PM
		$timeend = DateTime::createFromFormat('g:i a', $timeend)->format('H:i'); // 20:00
		$timestampend = $dateend." ".$timeend.":00"; //yyyy-mm-dd HH:ii:ss

		if ($_POST['agendalocation']=="Lainnya") {
			$lokasi = $_POST['eventlocationlain'];
		}else{
			$lokasi = $_POST['agendalocation'];
		}

		$update = array('ID_USER' => $_POST['pimpinan'] ,'TITLE' => $_POST['title'], 'DESCRIPTION' => $_POST['agendadesc'], 'LOCATION' => $lokasi, 'JENIS_AGENDA' => $_POST['jenisagenda'], 'TIME_START' => $timestampstart, 'TIME_END' => $timestampend );
		$hasil = $this->Agenda->confirm_agenda($update,$id);
		redirect('AppointmentController');
	}

	public function reminder(){
		$reminder = $this->Agenda->reminder();
		foreach ($reminder as $key) {
			$mulai = $key['TIME_START'];
			$now = date('Y-m-d H:i:s');
			if (floor(((strtotime($mulai)-strtotime($now)) / 60) % 60)==30) {
				$this->sendReminder($key['email'], $key['nama'], $key['TITLE'],$key['DESCRIPTION'],$key['LOCATION'],$key['TIME_START'],$key['TIME_END']);
			}
		}
	}

	public function sendReminder($email,$nama,$agenda,$deskripsi,$lokasi,$timestart,$timeend){
		$recipientaddress = $email;
		$recipientname = $nama;
		$subject = 'Agenda : '.$agenda;
		$body = 'Anda Mempunyai Agenda Pada 30 menit kedepan<br><br>Agenda : '.$agenda.'<br>Deskripsi : '.$deskripsi.'<br>Tempat : '.$lokasi.'<br>Pukul : '.date('H:i', strtotime($timestart)).' sampai '.date('H:i', strtotime($timeend)).'<br><br>Konfirmasi kehadiran di link berikut ini : <a href="">Klik!</a>';
		// Load the config file
		require_once(APPPATH.'libraries/PHPMailer/config.php');

		// Include functions
		require_once(APPPATH.'libraries/PHPMailer/sendfunction.php');

		$to = array(
			array(
				'name' 	=> $recipientname,
				'email'	=> $recipientaddress
			),
		);

		$from = array('name' => 'Front Desk LPPM UB', 'email' => 'frontdesklppmub.test@gmail.com');

		// Create a new instance and send the email
		$mailer = new Mailer(true);
		$mailer->mail($to, $subject, $body, $from);
	}
}

?>