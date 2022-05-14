<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GuestBook extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function insertNewGuestBook($guestname, $affiliation, $email, $notelp, $intention)
	{
		$this->db->query("INSERT INTO guestbook(GUESTNAME, AFFILIATION, EMAIL, NOTELP, INTENTION, TIME_ARRIVE) VALUES('".$guestname."','".$affiliation."','".$email."','".$notelp."', '".$notelp."',  CURRENT_TIMESTAMP)");
	}

	public function getAllGuestBook()
	{
		$value = $this->db->query("SELECT GUESTNAME, AFFILIATION, EMAIL, NOTELP, INTENTION, TIME_ARRIVE FROM guestbook ORDER BY TIME_ARRIVE DESC");
		$result	= $value->result_array();
		return $result;
	}

	public function jumlahTamuHariIni($tanggal){
		$query = $this->db->query("select count(*) as jumlah from guestbook where DATE(TIME_ARRIVE) = '$tanggal'");
		return $query->result_array();
	}

	public function jumlahTamuBulanIni($bulan){
		$query = $this->db->query("select count(*) as jumlah from guestbook where MONTH(TIME_ARRIVE) = '$bulan'");
		return $query->result_array();
	}

}
?>