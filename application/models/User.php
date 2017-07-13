<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

	public function login($username, $password) 
	{
		$query = <<< __query
			SELECT *
			FROM
				B_USERS a
			WHERE
				a.EMAIL = '$username'
				and a.PASSWORD = '$password'
__query;

		$data = $this->db->query($query);
		if($data->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getIdByToken($token) 
 	{
 		$result = JWT::decode($token, 'token');
 		return $result;
 	}





 	public function getAll()
	{
		$query = <<< __query

			select *
		    from 
		        B_USERS a

__query;

		return $this->db->query($query);
	}

	public function getById($id)
	{
		$query = <<< __query

			select *
		    from 
		        B_USERS a 
		    where a.ID = '$id'

__query;

		return $this->db->query($query);
	}
 	
}