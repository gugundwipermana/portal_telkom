<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Info extends CI_Model {

	public function getActive()
	{
		$query = <<< __query

			SELECT 
				* 
			FROM B_INFOS a
			WHERE
				a.EXPIRED > systimestamp

__query;

		return $this->db->query($query);
	}
 	
}