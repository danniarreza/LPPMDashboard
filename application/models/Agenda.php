<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function list_event(){
		return $query = $this->db->query("select ID, NAME, COLOR from eventagenda");
	}

	public function event_today($id,$tanggal){
		$query = $this->db->query("select TITLE, DESCRIPTION, LOCATION, TIME_START, TIME_END from agenda where ID_USER = '$id' and DATE(TIME_START)='$tanggal' and STATUS = 'Confirmed' order by FORMAT(TIME_START,'hh:mm') ");
		return $query->result_array();
	}

	public function jumlah_agenda_belum_approve($id){
		$query = $this->db->query("select count(*) as jumlah from agenda where ID_USER = '$id' and STATUS = 'Request'");
		return $query->result_array();
	}

	public function jumlah_agenda_today($id,$tanggal){
		$query = $this->db->query("select count(*) as jumlah from agenda where ID_USER = '$id' and DATE(TIME_START)='$tanggal' and STATUS = 'Confirmed'");
		return $query->result_array();
	}

	public function jumlah_agenda_ditolak($id){
		$query = $this->db->query("select count(*) as jumlah from agenda where ID_USER = '$id' and STATUS = 'Ditolak'");
		return $query->result_array();
	}

	public function jumlah_agenda_diconfirm($id){
		$query = $this->db->query("select count(*) as jumlah from agenda where ID_USER = '$id' and STATUS = 'Confirmed'");
		return $query->result_array();
	}


	public function get_undangan($data){
		return $query = $this->db->query("select user.nama from user join agenda on user.id=agenda.ID_USER where agenda.ID_ACARA='$data'");
		// return $result	= $query->result_array();
	}

	public function get_all_schedule(){
		$this->load->database();
		return $query = $this->db->query("select ID_AGENDA, ID_ACARA, ID_USER, TITLE, DESCRIPTION, eventagenda.NAME as NAMA_AGENDA, eventagenda.COLOR as WARNA, LOCATION, time_start as tanggal_mulai, time_end as tanggal_end, TIME_START as jam_mulai, TIME_END as jam_selesai, agenda.STATUS as STATUS, user.nama as undangan from agenda left join eventagenda on agenda.JENIS_AGENDA=eventagenda.ID join user on agenda.ID_USER=user.id");
	}

	public function input_data_event($array){
		$this->db->insert('eventagenda', $array);
	}

	public function delete_event($id){
		$this->db->delete('eventagenda', array('id' => $id));
	}

	public function get_schedule_on_date($date, $idevent){
	  $value = $this->db->query("SELECT A.ID_AGENDA, A.ID_ACARA, U.id, U.nama FROM AGENDA A, USER U WHERE A.ID_USER = U.ID AND A.JENIS_AGENDA = 1 AND DATE(A.TIME_START) <= '".$date."' AND DATE(A.TIME_END) >= '".$date."' AND A.ID_ACARA = '".$idevent."'");
	  $result = $value->result_array();
	  return $result;
	}

	public function get_schedule_on_month($bulan, $tahun, $idevent){
	  $value = $this->db->query("SELECT A.ID_AGENDA, A.ID_ACARA, U.id, U.nama FROM AGENDA A, USER U WHERE A.ID_USER = U.ID AND A.JENIS_AGENDA = 1 AND MONTH(A.TIME_START) <= '$bulan' AND YEAR(A.TIME_START) >= '$tahun' AND A.ID_ACARA = '".$idevent."'");
	  $result = $value->result_array();
	  return $result;
	}

	public function get_schedule_by_id_event($idevent)
	{
		$value = $this->db->query("SELECT A.ID_AGENDA, A.ID_ACARA, U.id, U.nama FROM AGENDA A, USER U WHERE A.ID_USER = U.ID AND A.JENIS_AGENDA = 1 and A.ID_ACARA = '".$idevent."' ");
	  $result = $value->result_array();
	  return $result;
	}

	public function insertNewAgenda($array){
		$this->db->insert('agenda', $array);
		return $this->db->insert_id();
	}

	public function confirm_agenda($data,$id){
		$this->db->update('agenda', $data, array('ID_AGENDA' => $id ));
	}

	public function select_all_schedule($nama){
		$this->load->database();
		return $query = $this->db->query("select ID_AGENDA, ID_ACARA, ID_USER, TITLE, DESCRIPTION, JENIS_AGENDA, eventagenda.NAME as NAMA_AGENDA, eventagenda.COLOR as WARNA, LOCATION, time_start as tanggal_mulai, time_end as tanggal_end, TIME_START as jam_mulai, TIME_END as jam_selesai, STATUS from agenda left join eventagenda on agenda.JENIS_AGENDA=eventagenda.ID where ID_USER = '$nama'");
	}

	public function selectEvent($id){
		$query = $this->db->query("select ID_ACARA, ID_AGENDA, agenda.ID_USER AS ID_USER, TITLE, DESCRIPTION, LOCATION, JENIS_AGENDA,time_start as tanggal_mulai, time_end as tanggal_end, agenda.STATUS as STATUS, user.nama as undangan from agenda join user on agenda.ID_USER=user.id where ID_AGENDA = '$id'");	
		return $query->result_array();
	}

	public function addEvent($data){
		$this->db->insert('schedule', $data);
	}

	public function cekAgenda($pimpinan,$tanggal,$time1, $time2){
		$query = $this->db->query("select ID_AGENDA, ID_ACARA, ID_USER, TITLE, DESCRIPTION, LOCATION, JENIS_AGENDA, TIME_START, TIME_END from agenda where ID_USER='$pimpinan' AND DATE(TIME_START)='$tanggal' AND ('$time1' >= TIME(TIME_START) OR '$time2' >= TIME(TIME_START))AND ('$time1' <= TIME(TIME_END) OR '$time2' <= TIME(TIME_END)) AND STATUS='Confirmed'");
		$result	= $query->result_array();
		return $result;
	}

	public function reminder(){
		$query = $this->db->query("select ID_AGENDA, ID_USER, TITLE, DESCRIPTION, LOCATION, TIME_START, TIME_END,email,nama from agenda join user on agenda.ID_USER = user.id where agenda.STATUS = 'Confirmed'");
		$result = $query->result_array();
		return $result;
	}



}
?>