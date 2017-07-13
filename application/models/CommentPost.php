<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class CommentPost extends CI_Model {

	public function getAll()
	{
		$query = <<< __query

__query;

		return $this->db->query($query);
	}
 	






 	public function countByPost($post_id)
 	{
 		$query = <<< __query
 		select count(*) JUM from B_COMMENT_POSTS a
	    where
	        a.POST_ID = '$post_id'
__query;
		
		return $this->db->query($query);
 	}


 	public function getByPost($post_id)
 	{
 		$query = <<< __query
	 		select a.*, b.NAME
	    from 
	        B_COMMENT_POSTS a
	        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
	    where
	        a.POST_ID = '$post_id'
__query;
		
		return $this->db->query($query);
 	}
 	
}