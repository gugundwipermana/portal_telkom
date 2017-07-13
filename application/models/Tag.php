<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends CI_Model {

	public function getAll()
	{
		$query = <<< __query

			SELECT 
				* 
			FROM B_TAGS a

__query;

		return $this->db->query($query);
	}


	public function getLimit($start, $end)
	{
		$query = <<< __query

			SELECT 
		        z.*,
		        (select count(*) from B_POST_TAGS b WHERE b.TAG_ID = z.ID) COUNT
		    FROM 
		        (
		            SELECT 
		                a.*,
		                row_number() over (order by ID) rnk
		            FROM 
		                B_TAGS a
		        ) z
		    WHERE rnk BETWEEN $start AND $end
		    ORDER BY COUNT DESC

__query;

		return $this->db->query($query);
	}


}