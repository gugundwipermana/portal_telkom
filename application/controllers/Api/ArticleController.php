<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ArticleController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Article');

		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Credentials', 'true'); 
		header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS'); 
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token, Authorization');
		
		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		    die();
		}
	}


	public function getBanner()
	{
		$response = $this->Article->getBanner()->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getAll()
	{
		$response = $this->Article->getAll()->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getById($id)
	{
		$response = $this->Article->getById($id)->row();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getLimit($start, $end)
	{
		$response = $this->Article->getLimit($start, $end)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getPopular()
	{
		$response = $this->Article->getPopular()->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getByCategory($category_id)
	{
		$response = $this->Article->getByCategory($category_id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function serach($title, $date_start, $date_end)
	{
		$response = $this->Article->serach($title, $date_start, $date_end)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function countRate($id)
	{
		$response = $this->Article->countRate($id)->row();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}














	/**
	 * ----------------------------------------------------------------------------
	 * STORE, DELETE, UPDATE
	 *
	 */

	public function store()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$category_id = $input_data['category_id'];
		$user_id = $input_data['user_id'];
		$title = $input_data['title'];
		$description = $input_data['description'];
		$image = $input_data['image'];
		$longitude = $input_data['longitude'];
		$latitude = $input_data['latitude'];
		$date_start = $input_data['date_start'];
		$date_end = $input_data['date_end'];
		$banner = $input_data['banner'];

		$data = array(

			'CATEGORY_ID'		=> $category_id,
			'USER_ID'			=> $user_id,
			'TITLE'				=> $title,
			'DESCRIPTION'		=> $description,
			'IMAGE'				=> $image,
			'LONGITUDE'			=> $longitude,
			'LATITUDE'			=> $latitude,
			'DATE_START'		=> $date_start,
			'DATE_END'			=> $date_end,
			'BANNER'			=> $banner
		);

		$this->db->insert('B_ARTICLES', $data);

		$response = array(
			'Success'	=> true,
			'Info'		=> 'Save success'
		);

		$this->output
			 ->set_status_header(201)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function delete($id)
	{
		$data_delete = array(
			'ID'		=> $id
		);
		$this->db->delete('B_ARTICLES', $data_delete);

		$response = array(
			'Success'	=> true,
			'Info'		=> 'Delete success'
		);

		$this->output
			 ->set_status_header(201)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function update($id)
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$category_id = $input_data['category_id'];
		$user_id = $input_data['user_id'];
		$title = $input_data['title'];
		$description = $input_data['description'];
		$image = $input_data['image'];
		$longitude = $input_data['longitude'];
		$latitude = $input_data['latitude'];
		$date_start = $input_data['date_start'];
		$date_end = $input_data['date_end'];
		$banner = $input_data['banner'];

		$data = array(

			'CATEGORY_ID'		=> $category_id,
			'USER_ID'			=> $user_id,
			'TITLE'				=> $title,
			'DESCRIPTION'		=> $description,
			'IMAGE'				=> $image,
			'LONGITUDE'			=> $longitude,
			'LATITUDE'			=> $latitude,
			'DATE_START'		=> $date_start,
			'DATE_END'			=> $date_end,
			'BANNER'			=> $banner
		);

		$where = array(
			'ID' => $id
		);

		$this->db->where($where);
		$this->db->update('B_ARTICLES',$data);

		$response = array(
			'Success'	=> true,
			'Info'		=> 'Update success'
		);

		$this->output
			 ->set_status_header(201)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}



	// --------------------------------------------------------------------------------

	public function store_rate()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$article_id = $input_data['article_id'];
		$user_id = $input_data['user_id'];
		$star = $input_data['star'];

		$data = array(
			'ARTICLE_ID'		=> $article_id,
			'USER_ID'			=> $user_id,
			'STAR'				=> $star
		);

		$this->db->insert('B_RATE_ARTICLES', $data);

		$response = array(
			'Success'	=> true,
			'Info'		=> 'Save success'
		);

		$this->output
			 ->set_status_header(201)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function delete_rate($id)
	{
		$data_delete = array(
			'ID'		=> $id
		);
		$this->db->delete('B_RATE_ARTICLES', $data_delete);

		$response = array(
			'Success'	=> true,
			'Info'		=> 'Delete success'
		);

		$this->output
			 ->set_status_header(201)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

}