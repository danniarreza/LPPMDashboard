<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EventScheduleController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->model(['Event','Room','Reservation','Agenda','EventArchive']);
		$this->load->helper(['file','download']);

		if ($_SESSION['loggedin']==FALSE) {
			redirect('LoginController');
		}else if($_SESSION['level']==1){
			redirect('DashboardController');
		}else if($_SESSION['level']==0){
			redirect('AdminController');
		}
	}

	public function index()
	{
		$this->eventScheduleListPage('currentdate');
	}

	public function eventScheduleAddPage()
	{
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$header['currentmenu'] = 'EventSchedule';
		$header['submenu'] = 'eventscheduleadd';
		$data['pimpinan'] = $this->Event->get_data_pimpinan();
		$data['room'] = $this->Room->getAllRoom();

		$this->load->view('header', $header);
		$this->load->view('eventscheduleadd',$data);
		// $this->load->view('footer');

		//$this->load->view('calendar');
	}

	public function eventScheduleAddHandler()
	{
		$eventname = $this->input->post('eventname');
		$eventinitiator = $this->input->post('eventinitiator');
		$initiatornotelp = $this->input->post('initiatornotelp');
		$initiatoremail = $this->input->post('initiatoremail');
		$eventlocation = $this->input->post('eventlocation');
		$eventdescription = $this->input->post('eventdescription');
		$eventtime = $this->input->post('eventtime');
		$attend = $this->input->post('attend');
		// $undangan = implode(", ",$_POST['pimpinan']);
		$config['upload_path']          = 'BerkasSuratAcara/';
		$config['allowed_types']        = 'doc|docx|pdf';
		$config['max_size']             = 10000;
		$this->load->library('upload', $config);
		$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["referenceletterpath"]["name"]));
		move_uploaded_file($_FILES["referenceletterpath"]["tmp_name"], "BerkasSuratAcara/" . $newfilename);

		$referenceletterpath = "BerkasSuratAcara/".$newfilename;

		$token = strtok($eventtime, " ");
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

		if ($eventlocation[0]=="Lainnya") {
			$this->Event->insertNewEvent(5,$eventname, $eventinitiator, $initiatornotelp, $initiatoremail, $_POST['eventlocationlain'], $eventdescription, $attend,$referenceletterpath, $timestampstart, $timestampend);
			$idevent = $this->Event->get_id_event()->result();
			$valueid = $idevent[0]->ID_EVENT;
			for ($i=0; $i < sizeof($_POST['pimpinan']) ; $i++) { 
				$insert = array('ID_ACARA' => $valueid, 'TITLE' => $eventname, 'ID_USER' => $_POST['pimpinan'][$i] ,'DESCRIPTION' => $eventdescription, 'LOCATION' => $_POST['eventlocationlain'], 'JENIS_AGENDA' => "1" ,'TIME_START' => $timestampstart, 'TIME_END' => $timestampend, 'STATUS' => "Request" );
				$hasil = $this->Agenda->insertNewAgenda($insert);
						// $this->eventInvitationSend($_POST['pimpinan'][$i], $hasil, $eventname, $eventlocation, $eventdescription, $timestampstart,$timestampend);
			}
			redirect('EventScheduleController');
		}else{

			for ($i=0; $i < sizeof($eventlocation) ; $i++) { 
				$data['previousevent'] = $this->Event->get_event($eventlocation[$i],$datestart,$timestart,$timeend);
			}

			if (isset($data['previousevent'][0])) {
				$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
				$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
				$header['css'][] = base_url('assets/plugins/iCheck/all.css');
				$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
				$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
				$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

				$data['proposedevent'] = array('eventname' => $_POST['eventname'], 'eventinitiator' => $_POST['eventinitiator'], 'initiatornotelp' => $_POST['initiatornotelp'], 'initiatoremail' => $_POST['initiatoremail'], 'eventlocation' => $_POST['eventlocation'], 'eventlocationlain' => $_POST['eventlocationlain'], 'eventdescription' => $_POST['eventdescription'], 'attend' => $_POST['attend'] );

				$header['currentmenu'] = 'EventSchedule';
				$header['submenu'] = 'eventscheduleadd';
				$data['pimpinan'] = $this->Event->get_data_pimpinan();
				$data['room'] = $this->Room->getAllRoom();

				$this->load->view('header', $header);
				$this->load->view('eventscheduleadd',$data);
			}else{
				for ($i=0; $i < sizeof($eventlocation) ; $i++) { 
					$this->Event->insertNewEvent($eventlocation[$i],$eventname, $eventinitiator, $initiatornotelp, $initiatoremail, $_POST['eventlocationlain'], $eventdescription, $attend ,$referenceletterpath, $timestampstart, $timestampend);
					$insert = array('APPLICANTNAME' => $eventinitiator, 'APPLICANTAFFILIATION' => "Front Desk LPPM UB", 'APPLICANTEMAIL' => $initiatoremail, 'APPLICANTNOTELP' => $initiatornotelp, 'EVENTNAME' => $eventname, 'ADDITIONALINFO' => $eventdescription, 'REFERENCELETTERPATH' => $referenceletterpath ,'ID_ROOM' => $eventlocation[$i], 'TIME_START' => $timestampstart,'TIME_END'=>$timestampend );
					$hasil = $this->Room->insertNewRoom($insert);
				}
				$idevent = $this->Event->get_id_event()->result();
				$valueid = $idevent[0]->ID_EVENT;
				for ($j=0; $j < sizeof($_POST['pimpinan']) ; $j++) { 
					for ($i=0; $i < sizeof($eventlocation); $i++) { 

						$lokasi = $this->Room->getRoom($eventlocation[$i]);
						$lokasi = $lokasi[0]['ROOMNAME'];
						$insert = array('ID_ACARA' => $valueid, 'TITLE' => $eventname, 'ID_USER' => $_POST['pimpinan'][$i] ,'DESCRIPTION' => $eventdescription, 'LOCATION' => $lokasi, 'JENIS_AGENDA' => "1" ,'TIME_START' => $timestampstart, 'TIME_END' => $timestampend, 'STATUS' => "Request" );
						$hasil = $this->Agenda->insertNewAgenda($insert);
						$this->eventInvitationSend($_POST['pimpinan'][$i], $hasil, $eventname, $lokasi, $eventdescription, $timestampstart,$timestampend);
					}
				}
				// redirect('EventScheduleController/');
			}
		}
	}

	public function eventInvitationSend($id_user, $id_agenda, $eventname, $lokasi, $eventdescription,$timestampstart,$timestampend)
	{		
		$pimpinan = $this->Event->get_data_pimpinan_where($id_user);

		$recipientaddress = $pimpinan[0]['email'];
		$recipientname = $pimpinan[0]['nama'];
		$subject = 'Ini Undangan : '.$eventname;
		$body = 'Anda diundang untuk acara '.$eventname.' yang berlokasi di '.$lokasi.'<br><br>Deskripsi acaranya adalah sebagai berikut : '.$eventdescription.'<br><br>Waktu acara dimulai dari : '.$timestampstart.'<br>Sampai dengan : '.$timestampend.'<br><br>Konfirmasi kehadiran di link berikut ini : <a href="'.site_url('AppointmentController/confirm_agenda/'.$id_agenda).'">Klik!</a>';
		// $body = 'Halo';

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

		$from = array(
			'name' => 'Front Desk LPPM UB', 
			'email' => 'frontdesklppmub.test@gmail.com'
		);

		// Create a new instance and send the email
		$mailer = new Mailer(true);
		$mailer->mail($to, $subject, $body, $from);
	}

	public function printLaporan($date){
		$d = DateTime::createFromFormat('Y-m-d', $date);
		if ($d && $d->format('Y-m-d')==$date) {
			$data['tanggal'] = $date;
			$data['acara'] = $this->Event->getEventOnDate($date);
			$data['total'] = $this->Event->jumlahEventHariIni($date);
		}else{
			$bulan = date('m', strtotime($date));
			$tahun = date('Y', strtotime($date));
			$data['tanggal'] = $date;
			$data['acara'] = $this->Event->getEventOnMonth($bulan,$tahun);
			$data['total'] = $this->Event->jumlahEventBulanIni($bulan,$tahun);	
		}
		$this->load->view('print', $data);
	}

	public function eventScheduleListPage($date)
	{
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');
		$header['currentmenu'] = 'EventSchedule';
		$header['submenu'] = 'eventschedulelist';

		$timearray = array();
		$time = '07:00';
		for ($i=0; $i < 23; $i++) { 
			$time = strtotime($time);
			$time = date("H:i", strtotime('+30 minutes', $time));
			$timearray[$i] = $time;
		}
		
//		$content['event'] = $this->Event->getEventOnDate($date);
		$content['time'] = $timearray;
		if ($date == 'currentdate') {
			$date = date('Y-m-d');
			$content['event'] = $this->Event->getEventOnDate($date);
			$content['date'] = date('d F Y', strtotime($date));
			$content['printdate'] = date('Y-m-d', strtotime($date));
		} else if ($date == 'searchdate') {
			$date = DateTime::createFromFormat('j M Y', $this->input->post('date'))->format('Y-m-d');
			$content['event'] = $this->Event->getEventOnDate($date);
			$content['date'] = date('d F Y', strtotime($date));
			$content['printdate'] = date('Y-m-d', strtotime($date));
		} else if ($date == 'searchmonth'){
			$bulan = DateTime::createFromFormat('M Y', $this->input->post('month'))->format('m');
			$tahun = DateTime::createFromFormat('M Y', $this->input->post('month'))->format('Y');
			$content['event'] = $this->Event->getEventOnMonth($bulan,$tahun);
			$content['date'] = date('F Y', strtotime($this->input->post('month')));
			$content['printdate'] = date('Y-m', strtotime($this->input->post('month')));
		}else{
			$d = DateTime::createFromFormat('Y-m-d', $date);
			if ($d && $d->format('Y-m-d')==$date) {
				$content['event'] = $this->Event->getEventOnDate($date);
				$content['date'] = date('d F Y', strtotime($date));
				$content['printdate'] = date('Y-m-d', strtotime($date));
			}else {
				$content['event'] = $this->Event->getEventOnMonth(date('m', strtotime($date)),date('Y', strtotime($date)));
				$content['date'] = date('F Y', strtotime($date));	
				$content['printdate'] = date('Y-m', strtotime($date));
			}
		}

		$d = DateTime::createFromFormat('Y-m-d', $date);
		if ($date == "searchmonth") {
			for ($i=0; $i < sizeof($content['event']) ; $i++) { 
				$content['event'][$i]['UNDANGAN'] = $this->Agenda->get_schedule_on_month(date('m', strtotime($_POST['month'])),date('Y', strtotime($_POST['month'])), $content['event'][$i]['ID_EVENT']);
			}	
		}else{
			if ($d && $d->format('Y-m-d')==$date) {
				for ($i=0; $i < sizeof($content['event']) ; $i++) { 
					$content['event'][$i]['UNDANGAN'] = $this->Agenda->get_schedule_on_date($date, $content['event'][$i]['ID_EVENT']);
				}	
			}else{
				for ($i=0; $i < sizeof($content['event']) ; $i++) { 
					$content['event'][$i]['UNDANGAN'] = $this->Agenda->get_schedule_on_month(date('m', strtotime($date)),date('Y', strtotime($date)), $content['event'][$i]['ID_EVENT']);
				}	
			}
		}

		$this->load->view('header', $header);
		$this->load->view('eventschedulelist', $content);

	}

	public function eventScheduleEditPage($idevent)
	{
		$header['css'][] = base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');
		$header['css'][] = base_url('assets/plugins/iCheck/all.css');
		$header['css'][] = base_url('assets/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css');
		$header['css'][] = base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');
		$header['css'][] = base_url('assets/bower_components/select2/dist/css/select2.min.css');

		$header['currentmenu'] = 'EventSchedule';
		$header['submenu'] = 'eventscheduleadd';
		$data['pimpinan'] = $this->Event->get_data_pimpinan();
		$data['room'] = $this->Room->getAllRoom();
		$data['reservedroom'] = $this->Reservation->getReservationIdFromEvent($idevent);
		$data['event'] = $this->Event->getEventById($idevent);
		$data['undangan'] = $this->Agenda->get_schedule_by_id_event($idevent);

		$this->load->view('header', $header);
		$this->load->view('eventscheduleedit',$data);
	}

	public function eventEditHandler($idevent)
	{
		if ($_POST['eventlocation']=="Lainnya") {
			$lokasi = 5;
		}else{
			$lokasi = $_POST['eventlocationlain'];
		}
		$pimpinan = $this->input->post('pimpinan');

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

		$this->Event->updateEvent($idevent, $this->input->post('eventname'), $this->input->post('eventinitiator'), $this->input->post('initiatornotelp'), $this->input->post('initiatoremail'), $lokasi, $this->input->post('eventdescription'), $timestampstart, $timestampend, $_POST['eventlocationlain']);

		redirect('EventScheduleController/eventScheduleListPage/'.$datestart);
	}

	public function eventScheduleEditHandler($idevent, $idreservation)
	{
		if ($_POST['eventlocation']=="Lainnya") {
			$lokasi = 5;
		}else{
			$lokasi = $_POST['eventlocation'];
		}
		$pimpinan = $this->input->post('pimpinan');

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

		$this->Event->updateEvent($idevent, $this->input->post('eventname'), $this->input->post('eventinitiator'), $this->input->post('initiatornotelp'), $this->input->post('initiatoremail'), $lokasi, $this->input->post('eventdescription'), $timestampstart, $timestampend,$_POST['eventlocationlain']);

		$this->Reservation->updateReservation($idreservation, $this->input->post('eventinitiator'), 'Front Desk LPPM UB', $this->input->post('initiatoremail'), $this->input->post('initiatornotelp'), $this->input->post('eventname'), $this->input->post('eventdescription'), $lokasi, $timestampstart, $timestampend);

		redirect('EventScheduleController/eventScheduleListPage/'.$datestart);
	}

	public function previewUndangan($path,$namafile){
		$path = $path.'/'.$namafile;

		header('Content-Type: application/pdf');
		header('Content-Disposition: inline; filename='.$path);
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');

		readfile($path);
		
	}

	public function uploadArchive($id){
		$data['currentmenu'] = "upload";
		$data['id'] = $id;
		$data['archive'] = $this->EventArchive->getArchive($id);
		$this->load->view('header', $data);
		$this->load->view('form_archive', $data);
	}

	public function uploadArchiveHandler($id){
		$config['upload_path']          = 'Archive/';
		$config['max_size']             = 10000;
		$this->load->library('upload', $config);
		for ($i=0; $i < sizeof($_FILES['file']['name']) ; $i++) { 
			$array = explode(".", $_FILES['file']['name'][$i]);
			$ext = end($array);
			$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"][$i]));
			move_uploaded_file($_FILES["file"]["tmp_name"][$i], "Archive/" . $newfilename);
			$insert = array('ID_EVENT' => $id, 'JENIS_FILE' => $ext, 'PATH' => $newfilename );
			$hasil = $this->EventArchive->insertArchive($insert);
		}
		redirect('EventScheduleController/eventScheduleListPage/currentdate');
	}

	public function downloadArchive($file){
		force_download("Archive/".$file, null);
	}
}

?>