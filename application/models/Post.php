<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Model {

	public function getAll()
	{
		$query = <<< __query

			select a.*, b.NAME 
		    from 
		        B_POSTS a
		        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
		    order by a.ID DESC

__query;

		return $this->db->query($query);
	}

	public function getById($id)
	{
		$query = <<< __query

			select a.*, b.NAME 
		    from 
		        B_POSTS a 
		        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
		    where a.ID = '$id'

__query;

		return $this->db->query($query);
	}

//	public function getActive()
//	{
//		$query = <<< __query
//		SELECT * 
//		FROM
//			B_POSTS a
//		WHERE
//			EXISTS (
//				SELECT b.POST_ID, COUNT(*) from B_POST_APPROVES b
//				WHERE
//					a.ID = b.POST_ID
//				GROUP BY b.POST_ID
//				HAVING count(*) >= 3
//			)
//		ORDER BY a.ID DESC
//__query;
//
//		return $this->db->query($query);
//	}
 	
 	public function getByUser($user_id)
 	{
 		$query = <<< __query

			SELECT 
				* 
			FROM B_POSTS a
			WHERE
				a.USER_ID = '$user_id'
			ORDER BY a.ID DESC

__query;

		return $this->db->query($query);
 	}

 	// mengambil POST yang harus di approve olah user tersebut
 	public function getByApproveUser($user_id)
 	{
 		$query = <<< __query

			select a.*, c.NAME 
		    from 
		        B_POSTS a
		        INNER JOIN B_POST_APPROVES b ON (a.ID = b.POST_ID)
		        INNER JOIN B_USERS c ON (a.USER_ID = c.ID)
		    where
		        b.USER_ID = '$user_id'

		        AND b.APPROVE = 'n'

		        AND NOT EXISTS (
		            SELECT z.POST_ID, COUNT(*) from B_POST_APPROVES z
		            WHERE
		                a.ID = z.POST_ID
		                AND z.APPROVE = 'y'
		            GROUP BY z.POST_ID
		            HAVING count(*) >= 3
		        )

		    order by a.ID DESC
__query;

		return $this->db->query($query);
 	}



 	public function getLimit($start, $end)
	{
		$query = <<< __query
			SELECT 
		        z.*,
		        b.NAME
		    FROM 
		        (
		            SELECT 
		                a.*,
		                row_number() over (order by ID) rnk
		            FROM 
		                B_POSTS a
		        ) z
		        INNER JOIN B_USERS b ON (z.USER_ID = b.ID)
		    WHERE 
		        rnk BETWEEN $start AND $end
		        -- TER APPROVE 3 ORANG
		        and EXISTS (
		            SELECT b.POST_ID, COUNT(*) from B_POST_APPROVES b
		            WHERE
		                z.ID = b.POST_ID
		                AND b.APPROVE = 'y'
		            GROUP BY b.POST_ID
		            HAVING count(*) >= 3
		        )
		    order by z.ID DESC
__query;

		return $this->db->query($query);
	}



 	/**
	 * ----------------------------------------
	 * IMAGE
	 * ----------------------------------------
	 *
	 **/

 	public function getImage($id)
 	{
 		$query = <<< __query

			select * 
		    from 
		        B_POST_IMAGES a 
		    where a.POST_ID = '$id'
__query;

		return $this->db->query($query);
 	}




 	/**
	 * ----------------------------------------
	 * TAG
	 * ----------------------------------------
	 *
	 **/

 	public function getTag($id)
 	{
 		$query = <<< __query

			select a.*, b.NAME, b.ICON
		    from 
		        B_POST_TAGS a
		        INNER JOIN B_TAGS b ON (a.TAG_ID = b.ID)
		    where 
				a.POST_ID = '$id'
__query;

		return $this->db->query($query);
 	}
 	
	public function getByTag($tag_id)
	{
		$query = <<< __query
			select
		        *
		    from 
		        B_POSTS a
		        INNER JOIN B_POST_TAGS b ON (a.ID = b.POST_ID)
		    where
		        b.TAG_ID = '$tag_id'
		    order by a.ID DESC
__query;

		return $this->db->query($query);
	}




	/**
	 * ----------------------------------------
	 * APPROVE
	 * ----------------------------------------
	 *
	 **/

	public function getUserApprove($id)
	{
		$query = <<< __query
		select 
	        a.*,
	        b.NAME
	    from 
	        B_POST_APPROVES a 
	        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
	    where
	        a.POST_ID = '$id'
__query;

		return $this->db->query($query);
	}




	/**
	 * ----------------------------------------
	 * LIKE
	 * ----------------------------------------
	 *
	 **/

	public function countLike($id)
	{
		$query = <<< __query
		select count(*) JUM from B_LIKE_POSTS a
	    where
	        a.POST_ID = '$id'
__query;

		return $this->db->query($query);
	}

	public function getLikeUser($id)
	{
		$query = <<< __query
		select
	        a.*,
	        b.NAME
	    from 
	        B_LIKE_POSTS a
	        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
	    where
	        a.POST_ID = '$id'
__query;

		return $this->db->query($query);
	}

}