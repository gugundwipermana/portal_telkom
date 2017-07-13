<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class CommentArticle extends CI_Model {

	public function getAll()
	{
		$query = <<< __query

__query;

		return $this->db->query($query);
	}
 	






 	public function countByArticle($article_id)
 	{
 		$query = <<< __query
 		select count(*) jum from B_COMMENT_ARTICLES a where a.ARTICLE_ID = '$article_id'
__query;
		
		return $this->db->query($query);
 	}


 	public function getByArticle($article_id)
 	{
 		$query = <<< __query
 		select
	        a.*,
	        b.NAME
	    from 
	        B_COMMENT_ARTICLES a 
	        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
	    where 
	        a.ARTICLE_ID = '$article_id'
__query;
		
		return $this->db->query($query);
 	}
 	
}