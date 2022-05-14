<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReservationController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('Reservation');
		$this->load->model('Room');
		$this->load->model('Agenda');
		$this->load->model('Event');
		$this->load->helper('file');

		if ($_SESSION['loggedin']==FALSE) {
			redirect('LoginController');
		}else if ($_SESSION['level']==1 || $_SESSION['level']==3) {
			redirect('DashboardController');
		}else if($_SESSION['level']==0){
			redirect('AdminController');
		}
	}

	public function index()
	{
		$this->reservationListPage('currentdate');
	}

	public function reservationListPage($date)
	{
		$header['currentmenu'] = 'Reservation';
		$header['submenu'] = 'reservationlist';

		$timearray = array();
		$time = '07:00';
		for ($i=0; $i < 23; $i++) { 
			$time = strtotime($time);
			$time = date("H:i", strtotime('+30 minutes', $time));
			$timearray[$i] = $time;
		}
		
		$content['room'] = $this->Room->getAllRoom();
		$content['time'] = $timearray;
		if ($date == 'currentdate') {
			$date = date('Y-m-d');
			$content['reservation'] = $this->Reservation->getReservationOnDate($date);
			$content['date'] = date('d F Y', strtotime($date));
		} else if ($date == 'searchdate') {
			$date = DateTime::createFromFormat('j M Y', $this->input->post('date'))->format('Y-m-d');
			$content['reservation'] = $this->Reservation->getReservationOnDate($date);
			$content['date'] = date('d F Y', strtotime($date));
		} else if($date == 'searchmonth'){
			$bulan = DateTime::createFromFormat('M Y', $this->input->post('month'))->format('m');
			$tahun = DateTime::createFromFormat('M Y', $this->input->post('month'))->format('Y');
			$content['reservation'] = $this->Reservation->getReservationOnMonth($bulan,$tahun);
			$content['date'] = date('F Y', strtotime($this->input->post('month')));
		} else{
			$content['reservation'] = $this->Reservation->getReservationOnDate($date);
			$content['date'] = date('d F Y', strtotime($date));
		}

		//print_r($content['reservation']) ;

		$this->load->view('header', $header);
		$this->load->view('reservationlist', $content);
		// $this->load->view('footer');
	}

	public function reservationAddPage()
	{
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$content['room'] = $this->Room->getAllRoom();

		$header['currentmenu'] = 'Reservation';
		$header['submenu'] = 'reservationadd';

		$this->load->view('header', $header);
		$this->load->view('reservationadd', $content);
		// $this->load->view('footer');

		//$this->load->view('calendar');
	}

	public function reservationAddHandler()
	{
		$applicantname = $this->input->post('applicantname');
		$applicantaffiliation = $this->input->post('applicantaffiliation');
		$applicantemail = $this->input->post('applicantemail');
		$applicantnotelp = $this->input->post('applicantnotelp');

		$eventname = $this->input->post('eventname');
		$additionalinfo = $this->input->post('additionalinfo');
		$room = $this->input->post('room');
		$timeinput = $this->input->post('timeinput');

		$token = strtok($timeinput, " ");
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

		$content['previousreservation'] = $this->Reservation->get_jadwal($room,$datestart,$timestart,$timeend);

		// echo "<pre>";
		// foreach ($content['previousreservation'] as $row) {
		// 	print_r($row);
		// }
		// echo "</pre>";

		if (isset($content['previousreservation'][0])) {
			$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
			$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
			$header['css'][] = base_url('assets/plugins/iCheck/all.css');
			$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
			$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
			$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');
			$header['currentmenu'] = 'Reservation';
			$header['submenu'] = 'reservationadd';
			$content['proposedreservation'] = array('nama' => $_POST['applicantname'], 'afiliasi' => $_POST['applicantaffiliation'], 'email' => $_POST['applicantemail'], 'notelp' => $_POST['applicantnotelp'], 'eventname' => $_POST['eventname'], 'additionalinfo' => $_POST['additionalinfo'], 'ruang' => $_POST['room'], 'timeinput' => $_POST['timeinput'] );

			// echo "<pre>";
			// 	foreach ($content['previousreservation'] as $row) {
			// 		print_r($row);
			// 	}
			// echo "</pre>";

			$content['room'] = $this->Room->getAllRoom();
			$this->load->view('header', $header);
			$this->load->view('reservationadd', $content);
		}else{
			$config['upload_path']          = 'BerkasPinjamRuang/';
			$config['allowed_types']        = 'doc|docx|pdf';
			$config['max_size']             = 10000;
			$this->load->library('upload', $config);
			$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["referenceletterpath"]["name"]));
			move_uploaded_file($_FILES["referenceletterpath"]["tmp_name"], "BerkasPinjamRuang/" . $newfilename);
			$referenceletterpath = "BerkasPinjamRuang/".$newfilename;
			// $this->Reservation->cek_jadwal($)

			$this->Reservation->insertNewReservation($applicantname, $applicantaffiliation, $applicantemail, $applicantnotelp, $referenceletterpath, $eventname, $additionalinfo, $room, $timestampstart, $timestampend);
			redirect('ReservationController/reservationAddPage');
		}
	}

	public function reservationEditPage($idreservation)
	{
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$header['currentmenu'] = 'Reservation';
		$header['submenu'] = 'reservationadd';

		$content['room'] = $this->Room->getAllRoom();
		$content['reservation'] = $this->Reservation->getReservationById($idreservation);
		$content['idevent'] = $this->Event->getEventIdFromReservation($idreservation);

		if (!isset($content['idevent'][0]['ID_EVENT'])) {
			$content['idevent'] = '0';
		}
		$this->load->view('header', $header);
		$this->load->view('reservationedit', $content);
	}

	public function reservationEditHandler($idreservation, $idevent)
	{
		$token = strtok($this->input->post('reservationtimestart'), " ");
		$datestart = $token; // dd/mm/yyyy
		$datestart = implode("-", array_reverse(explode("/", $datestart))); // yyyy-mm-dd
		$timestart = strtok(" ").' '.strtok(" ");
		strtok(" "); // 8:00 PM
		$timestart = DateTime::createFromFormat('g:i a', $timestart)->format('H:i'); // 20:00
		$timestampstart = $datestart." ".$timestart.":00"; //yyyy-mm-dd HH:ii:ss

		$token = strtok($this->input->post('reservationtimeend'), " ");
		$dateend = $token; // dd/mm/yyyy
		$dateend = implode("-", array_reverse(explode("/", $dateend))); // yyyy-mm-dd
		$timeend = strtok(" ").' '.strtok(" "); // 8:00 PM
		$timeend = DateTime::createFromFormat('g:i a', $timeend)->format('H:i'); // 20:00
		$timestampend = $dateend." ".$timeend.":00"; //yyyy-mm-dd HH:ii:ss

		$this->Reservation->updateReservation($idreservation, $this->input->post('applicantname'), $this->input->post('applicantaffiliation'), $this->input->post('applicantemail'), $this->input->post('applicantnotelp'), $this->input->post('eventname'), $this->input->post('additionalinfo'), $this->input->post('room'), $timestampstart, $timestampend);

		if ($idevent!='0') {
			$this->Event->updateEvent($idevent, $this->input->post('eventname'), $this->input->post('applicantname'), $this->input->post('applicantnotelp'), $this->input->post('applicantemail'), $this->input->post('room'), $this->input->post('additionalinfo'), $timestampstart, $timestampend);
		}		

		redirect('ReservationController/reservationListPage/'.$datestart);
	}

	public function strtotimeTest()
	{
		//echo(strtotime("1996-02-26") . "<br>");

		// $paymentDate = date('Y-m-d');
		$paymentDate=date('2006-02-26');
		$paymentDate=date('Y-m-d', strtotime($paymentDate));
		//echo $paymentDate; // echos today! 

		// $contractDateBegin = date('Y-m-d', strtotime("01/01/2001"));
		// $contractDateEnd = date('Y-m-d', strtotime("01/01/2012"));

		$contractDateBegin = date('Y-m-d', strtotime("2001/01/01"));
		$contractDateEnd = date('Y-m-d', strtotime("2012/01/01"));

		if (($paymentDate > $contractDateBegin) && ($paymentDate < $contractDateEnd)){
			echo "is between";
		}else{
			echo "NO GO!";  
		}
	}

	public function strtotimeTest2()
	{

		$currentTime=date('12:30');
		$currentTime=date('H:i', strtotime($currentTime));

		// echo $currentTime;

		$resTimeBegin = date('H:i', strtotime("09:00"));
		$resTimeEnd = date('H:i', strtotime("12:00"));

		if (($currentTime > $resTimeBegin) && ($currentTime < $resTimeEnd)){
			echo "is between";
		}else{
			echo "NO GO!";  
		}
	}

	public function DataRuangan(){

		$header['css'][] = base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');

		$header['currentmenu'] = 'DataRuangan';
		$content['room'] =  $this->Room->getAllRoom();
		$this->load->view('header', $header);
		$this->load->view('dataruangan', $content);
	}

	public function SaveEditRuangan($id){
		$data = array('ROOMNAME' => $_POST['roomname'], 'CAPACITY' => $_POST['roomcapacity'], 'ADDITIONALINFO' => $_POST['additionalinfo'] );
		$hasil = $this->Room->edit_ruangan($data, $id);
		$this->DataRuangan();
	}

	public function DeleteRuangan($id){
		$this->Room->delete_ruangan($id);
		$this->DataRuangan();
	}

	public function AddRoomHandler(){
		$data = array('ROOMNAME' => $_POST['roomname'], 'CAPACITY' => $_POST['roomcapacity'], 'ADDITIONALINFO' => $_POST['additionalinfo'] );
		$hasil = $this->Room->insert_room($data);
		$this->DataRuangan();
	}
	public function previewUndangan($path,$namafile){
		$path = $path.'/'.$namafile;

		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename='.$path);
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		readfile($path);
		
	}

}

?>