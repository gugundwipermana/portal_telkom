<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Model {

	public function getBanner()
	{
		$query = <<< __query

			SELECT * FROM
		    (
		        SELECT * FROM B_ARTICLES a
		        WHERE
		            a.BANNER = 'y'
		        ORDER BY a.DATE_START DESC
		    ) z
		    WHERE
		        ROWNUM <= 3
		    order by z.ID DESC

__query;

		return $this->db->query($query);
	}

	public function getAll()
	{
		$query = <<< __query
			select * from B_ARTICLES a
    		order by a.ID DESC
__query;

		return $this->db->query($query);
	}

	public function getById($id)
	{
		$query = <<< __query
			select 
		        a.*,
		        b.NAME
		    from 
		        B_ARTICLES a
		        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
		    where
		        a.ID = '$id'
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
		                B_ARTICLES a
		        ) z
		        INNER JOIN B_USERS b ON (z.USER_ID = b.ID)
		    WHERE rnk BETWEEN $start AND $end
		    order by z.ID DESC
__query;

		return $this->db->query($query);
	}



	public function getPopular()
	{
		$query = <<< __query
			SELECT 
	            z.*,
	            c.NAME
	        FROM
	            (
	                select 
	                    a.*,
	                    (
	                        select
	                            case
	                                when
	                                    sum(b.STAR) > 0 
	                                THEN
	                                    sum(b.STAR) / count(*)
	                                else
	                                    0
	                                end
	                        from B_RATE_ARTICLES b
	                        where
	                            b.ARTICLE_ID = a.ID
	                    ) RATE
	                from 
	                    B_ARTICLES a
	                order by RATE DESC
	            ) z
	            INNER JOIN B_USERS c ON (z.USER_ID = c.ID)
	        WHERE
	            ROWNUM <= 5
__query;

		return $this->db->query($query);
	}


	public function getByCategory($category_id)
	{
		$query = <<< __query
			select a.*, b.NAME 
		    from 
		        B_ARTICLES a
		        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
		    where
		        a.CATEGORY_ID = '$category_id'
		    order by a.ID DESC
__query;

		return $this->db->query($query);
	}



	public function serach($title, $date_start, $date_end)
	{
// 		$where = '';
// 
// 		if($category != '') {
// 			$where .= "and a.CATEGORY = '".$category."'";
// 		} 
// 
// 		if($date_start != '' && $date_end) {
// 			$where .= "and a.DATE_START between '$date_start' and '$date_end'";
// 		}
// 
// 		$query = <<< __query
// 
// 			SELECT * FROM B_ARTICLES a
// 			WHERE
// 				a.TITLE like '%$title%'
// 				$where
// 			ORDER BY a.DATE_START DESC
// 
// __query;

		$query = <<< __query
			select a.*, b.NAME 
		    from 
		        B_ARTICLES a
		        INNER JOIN B_USERS b ON (a.USER_ID = b.ID)
		    where
		        a.TITLE like '%$title%'
		        or (
		            a.DATE_START between to_date('$date_start', 'dd-mm-yyyy') and to_date('$date_end', 'dd-mm-yyyy')
		            or a.DATE_END between to_date('$date_start', 'dd-mm-yyyy') and to_date('$date_end', 'dd-mm-yyyy')
		        )
__query;
		return $this->db->query($query);
	}




	/**
	 * ----------------------------------------
	 * RATE
	 * ----------------------------------------
	 *
	 **/

	public function countRate($id)
 	{
 		$query = <<< __query
 		select 
	        sum(a.STAR) / (select count(b.STAR) from B_RATE_ARTICLES b where b.ARTICLE_ID = '$id') STAR
	    from B_RATE_ARTICLES a
	    where
	        a.ARTICLE_ID = '$id'
	    group by 1
__query;
		
		return $this->db->query($query);
 	}
 	
}