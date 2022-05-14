<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function insertNewEvent($locationlain, $eventname, $eventinitiator, $initiatornotelp, $initiatoremail, $eventlocation, $eventdescription, $attendance ,$referenceletterpath, $timestampstart, $timestampend)
	{
		$this->db->query("INSERT INTO event(ID_ROOM, EVENTNAME, EVENTINITIATOR, INITIATORNOTELP, INITIATOREMAIL, EVENTLOCATION, EVENTDESCRIPTION, ATTENDANCE ,REFERENCELETTERPATH, TIME_START, TIME_END) VALUES('".$locationlain."','".$eventname."','".$eventinitiator."','".$initiatornotelp."','".$initiatoremail."', '".$eventlocation."',  '".$eventdescription."', '".$attendance."','".$referenceletterpath."', '".$timestampstart."', '".$timestampend."')");
		$this->get_id_event();
	}

	public function updateEvent($idevent, $eventname, $eventinitiator, $initiatornotelp, $initiatoremail, $eventlocation, $eventdescription, $eventtimestart, $eventtimeend, $lainnya)
	{
		$this->db->query("UPDATE event SET ID_ROOM='".$eventlocation."', EVENTNAME='".$eventname."', EVENTINITIATOR='".$eventinitiator."', INITIATORNOTELP='".$initiatornotelp."', EVENTLOCATION='".$lainnya."', INITIATOREMAIL='".$initiatoremail."', EVENTDESCRIPTION='".$eventdescription."', TIME_START='".$eventtimestart."', TIME_END='".$eventtimeend."' WHERE ID_EVENT='".$idevent."'");
	}

	public function get_id_event(){
		return $query = $this->db->query("select ID_EVENT from event order by ID_EVENT desc limit 1");
	}

	// public function get_all_data_pimpinan(){
	// 	return $query = $this->db->query("select * from user where level = 1");
	// }

	public function get_data_pimpinan()
	{
		$value = $this->db->query("select id, nama from user where level = 1");
		$result	= $value->result_array();
		return $result;
	}

	public function get_data_pimpinan_where($id){
		$value = $this->db->query("SELECT id, username, nama, email from user where level = 1 and id = '".$id."'");
		$result	= $value->result_array();
		return $result;
	}

	public function jumlahEventHariIni($tanggal){
		$query = $this->db->query("select count(*) as jumlah from event where DATE(TIME_START)='$tanggal'");
		return $query->result_array();
	}

	public function jumlahEventBulanIni($bulan, $tahun){
		$query = $this->db->query("select count(*) as jumlah from event where MONTH(TIME_START)='$bulan' and YEAR(TIME_START)= '$tahun'");
		return $query->result_array();
	}

	public function getEventOnDate($date)
	{
		$value = $this->db->query("SELECT ID_EVENT, ROOMNAME, EVENTNAME, EVENTINITIATOR, EVENTLOCATION, EVENTDESCRIPTION, ATTENDANCE, REFERENCELETTERPATH,TIME_START, TIME_END FROM event LEFT JOIN room ON event.ID_ROOM=room.ID_ROOM WHERE DATE(TIME_START) <= '".$date."' AND DATE(TIME_END) >= '".$date."'");
		$result	= $value->result_array();
		return $result;
	}

	public function getEventOnMonth($bulan, $tahun)
	{
		$value = $this->db->query("SELECT ID_EVENT, ROOMNAME, EVENTNAME, EVENTINITIATOR, EVENTLOCATION, EVENTDESCRIPTION, ATTENDANCE, REFERENCELETTERPATH,TIME_START, TIME_END FROM event LEFT JOIN room ON event.ID_ROOM=room.ID_ROOM WHERE MONTH(TIME_START) = '$bulan' AND YEAR(TIME_START) = '$tahun'");
		$result	= $value->result_array();
		return $result;
	}

	public function get_event($room,$date,$time1,$time2){
		$value = $this->db->query("SELECT ID_EVENT, EVENTNAME, ID_ROOM,TIME_START, TIME_END FROM `event` WHERE ID_ROOM='$room' and DATE(TIME_START)='$date' AND ('$time1' >= TIME(TIME_START) OR '$time2' >= TIME(TIME_START))AND ('$time1' <= TIME(TIME_END) OR '$time2' <= TIME(TIME_END))");
		$result	= $value->result_array();
		return $result;
	}

	
	public function getEventById($idevent){
		$value = $this->db->query("SELECT e.ID_EVENT, r.ID_ROOM, r.ROOMNAME, e.EVENTNAME, e.EVENTINITIATOR, e.INITIATORNOTELP, e.INITIATOREMAIL, e.EVENTLOCATION, e.EVENTDESCRIPTION, e.REFERENCELETTERPATH, e.TIME_START, e.TIME_END FROM event e, room r WHERE e.ID_ROOM = r.ID_ROOM AND e.ID_EVENT = '".$idevent."'");
		$result	= $value->result_array();
		return $result;
	}

	public function getEventIdFromReservation($idreservation)
	{
		$value = $this->db->query("SELECT e.ID_EVENT FROM event e, reservation r WHERE e.ID_ROOM = r.ID_ROOM AND e.TIME_START = r.TIME_START AND e.TIME_END = r.TIME_END AND r.ID_RESERVATION = '".$idreservation."'");
		$result	= $value->result_array();
		return $result;
	}

}
?>