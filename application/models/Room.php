<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function insertNewRoom($array)
	{
		$this->db->insert('reservation', $array);
	}

	public function getAllRoom()
	{
		$value = $this->db->query("SELECT ID_ROOM, ROOMNAME, CAPACITY, ADDITIONALINFO FROM room where ID_ROOM != 5 order by ROOMNAME");
		$result	= $value->result_array();
		return $result;
	}

	public function getRoom($id)
	{
		$value = $this->db->query("SELECT ID_ROOM, ROOMNAME, CAPACITY, ADDITIONALINFO FROM room WHERE ID_ROOM = '".$id."'");
		$result	= $value->result_array();
		return $result;
	}

	public function edit_ruangan($data, $id){
		$this->db->update('room', $data, array('ID_ROOM' => $id ));
	}

	public function delete_ruangan($id){
		$this->db->delete('room', array('ID_ROOM' => $id ));
	}

	public function insert_room($array){
		$this->db->insert('Room', $array);
	}

}
?>