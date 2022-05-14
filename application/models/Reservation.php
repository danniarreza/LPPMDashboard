<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function insertNewReservation($applicantname, $applicantaffiliation, $applicantemail, $applicantnotelp, $referenceletterpath, $eventname, $additionalinfo, $room, $timestampstart, $timestampend)
	{
		$this->db->query("INSERT INTO reservation(APPLICANTNAME, APPLICANTAFFILIATION, APPLICANTEMAIL, APPLICANTNOTELP, REFERENCELETTERPATH, EVENTNAME, ADDITIONALINFO, ID_ROOM, TIME_START, TIME_END) VALUES('".$applicantname."','".$applicantaffiliation."','".$applicantemail."','".$applicantnotelp."', '".$referenceletterpath."',  '".$eventname."', '".$additionalinfo."', '".$room."', '".$timestampstart."', '".$timestampend."')");
	}

	public function getReservationOnDate($date)
	{
		$value = $this->db->query("SELECT ID_RESERVATION, EVENTNAME, APPLICANTNAME, reservation.ID_ROOM AS ID_ROOM, ROOMNAME, REFERENCELETTERPATH,TIME_START, TIME_END, reservation.ADDITIONALINFO AS ADDITIONALINFO FROM reservation LEFT JOIN room ON reservation.ID_ROOM = room.ID_ROOM WHERE DATE(TIME_START) <= '".$date."' AND DATE(TIME_END) >= '".$date."'");
		$result	= $value->result_array();
		return $result;
	}

	public function getReservationOnMonth($bulan, $tahun)
	{
		$value = $this->db->query("SELECT ID_RESERVATION, EVENTNAME, APPLICANTNAME, reservation.ID_ROOM AS ID_ROOM, ROOMNAME, REFERENCELETTERPATH,TIME_START, TIME_END, reservation.ADDITIONALINFO AS ADDITIONALINFO FROM reservation LEFT JOIN room ON reservation.ID_ROOM = room.ID_ROOM WHERE MONTH(TIME_START) = '$bulan' AND YEAR(TIME_START) >= '$tahun'");
		$result	= $value->result_array();
		return $result;
	}

	public function getReservationById($idreservation)
	{
		$value = $this->db->query("SELECT ID_RESERVATION, APPLICANTNAME, APPLICANTAFFILIATION, APPLICANTEMAIL, APPLICANTNOTELP, ID_ROOM, EVENTNAME, TIME_START, TIME_END, ADDITIONALINFO FROM reservation WHERE ID_RESERVATION = '".$idreservation."'");
		$result	= $value->result_array();
		return $result;
	}

	public function get_jadwal($room,$date,$time1,$time2){
		$value = $this->db->query("SELECT ID_RESERVATION, EVENTNAME, TIME_START, TIME_END FROM `reservation` WHERE ID_ROOM='$room' and DATE(TIME_START)='$date' AND ('$time1' >= TIME(TIME_START) OR '$time2' >= TIME(TIME_START))AND ('$time1' <= TIME(TIME_END) OR '$time2' <= TIME(TIME_END))");
		$result	= $value->result_array();
		return $result;
	}

	public function jumlahReservationHariIni($tanggal){
		$query = $this->db->query("select count(*) as jumlah from reservation where DATE(TIME_START) = '$tanggal'");
		return $query->result_array();
	}

	public function jumlahReservationBulanIni($bulan){
		$query = $this->db->query("select count(*) as jumlah from reservation where MONTH(TIME_START) = '$bulan'");
		return $query->result_array();
	}

	public function getReservationIdFromEvent($idevent)
	{
		$value = $this->db->query("SELECT r.ID_RESERVATION FROM event e, reservation r WHERE e.ID_ROOM = r.ID_ROOM AND e.TIME_START = r.TIME_START AND e.TIME_END = r.TIME_END AND e.ID_EVENT = '".$idevent."'");
		$result	= $value->result_array();
		return $result;
	}

	public function updateReservation($idreservation, $eventinitiator, $applicantaffiliation, $initiatoremail, $initiatornotelp, $eventname, $eventdescription, $eventlocation, $timestampstart, $timestampend)
	{
		$this->db->query("UPDATE reservation SET 
			APPLICANTNAME='".$eventinitiator."',
			APPLICANTAFFILIATION ='".$applicantaffiliation."', 
			APPLICANTEMAIL='".$initiatoremail."', 
			APPLICANTNOTELP='".$initiatornotelp."',  
			EVENTNAME='".$eventname."', 
			ADDITIONALINFO='".$eventdescription."', 
			ID_ROOM='".$eventlocation."', 
			TIME_START='".$timestampstart."', 
			TIME_END='".$timestampend."' 
			WHERE ID_RESERVATION='".$idreservation."'");
	}

}
?>