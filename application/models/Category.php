<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Model {

	public function getAll()
	{
		$query = <<< __query

			SELECT 
				* 
			FROM B_CATEGORIES a

__query;

		return $this->db->query($query);
	}
 	
}