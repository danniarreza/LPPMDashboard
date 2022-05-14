<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EventArchive extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insertArchive($data){
		$this->db->insert('eventarchive', $data);
	}

	function getArchive($id){
		$query = $this->db->query("select ID_EVENTARCHIVE, PATH from eventarchive where ID_EVENT = '$id'");
		return $query->result_array();
	}

}
?>