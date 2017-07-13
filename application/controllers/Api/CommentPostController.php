<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class CommentPostController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('CommentPost');

		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Credentials', 'true'); 
		header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS'); 
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token, Authorization');
		
		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		    die();
		}
	}



	public function countByPost($post_id)
	{
		$response = $this->CommentPost->countByPost($post_id)->row();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getByPost($post_id)
	{
		$response = $this->CommentPost->getByPost($post_id)->result();

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

		$post_id = $input_data['post_id'];
		$user_id = $input_data['user_id'];
		$description = $input_data['description'];

		$data = array(
			'POST_ID'		=> $post_id,
			'USER_ID'			=> $user_id,
			'DESCRIPTION'		=> $description
		);

		$this->db->insert('B_COMMENT_POSTS', $data);

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
		$this->db->delete('B_COMMENT_POSTS', $data_delete);

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