<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GuestBookController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('GuestBook');

		if ($_SESSION['loggedin']==FALSE) {
			redirect('LoginController');
		}else if($_SESSION['level']==0){
			redirect('AdminController');
		}else if($_SESSION['level']==1||$_SESSION['level']==2){
			redirect('DashboardController');
		}
	}

	public function index()
	{

		$this->guestBookAddPage();
	}

	public function guestBookListPage()
	{

		$header['css'][] = base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');

		$header['currentmenu'] = 'GuestBook';

		$this->load->view('header', $header);
		$this->load->view('guestbooklist');
		// $this->load->view('footer');
	}

	public function guestBookAddPage()
	{

		$header['css'][] = base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');

		$header['currentmenu'] = 'GuestBook';

		$content['guestbook'] =  $this->GuestBook->getAllGuestBook();

		$this->load->view('header', $header);
		$this->load->view('guestbookadd', $content);
		// $this->load->view('footer');
	}

	public function guestBookAddHandler()
	{

		$guestname = $this->input->post('guestname');
		$affiliation = $this->input->post('affiliation');
		$email = $this->input->post('email');
		$notelp = $this->input->post('notelp');
		$intention = $this->input->post('intention');

		// echo $guestname;
		// echo $affiliation;
		// echo $email;
		// echo $notelp;
		// echo $intention;

		$this->GuestBook->insertNewGuestBook($guestname, $affiliation, $email, $notelp, $intention);
		redirect('GuestBookController/');
	}

}

?>