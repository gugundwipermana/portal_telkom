<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class PostController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Post');

		header('Access-Control-Allow-Origin: *'); 
		header('Access-Control-Allow-Credentials', 'true'); 
		header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS'); 
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token, Authorization');
		
		if ( "OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
		    die();
		}
	}


	public function getAll()
	{
		$response = $this->Post->getAll()->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getById($id)
	{
		$response = $this->Post->getById($id)->row();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

//	public function getActive()
//	{
//		$response = $this->Post->getActive()->result();
//
//		$this->output
//			 ->set_status_header(200)
//			 ->set_content_type('application/json', 'utf-8')
//			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
//			 ->_display();
//			 exit;
//	}

	public function getByUser($user_id)
	{
		$response = $this->Post->getByUser($user_id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getByApproveUser($user_id)
	{
		$response = $this->Post->getByApproveUser($user_id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getLimit($start, $end)
	{
		$response = $this->Post->getLimit($start, $end)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}


	// satukan pada getAll, getLimit
	public function getImage($id)
	{
		$response = $this->Post->getImage($id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getTag($id)
	{
		$response = $this->Post->getTag($id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getByTag($tag_id)
	{
		$response = $this->Post->getByTag($tag_id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getUserApprove($id)
	{
		$response = $this->Post->getUserApprove($id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function countLike($id)
	{
		$response = $this->Post->countLike($id)->row();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getLikeUser($id)
	{
		$response = $this->Post->getLikeUser($id)->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}








	/**
	 * ----------------------------------------------------------------------------
	 * UPLOAD
	 *
	 */

	public function upload()
	{
		$fileName = time().$_FILES['image_file']['name'];

		// echo 'Nama file: '.$fileName.'<br/>';
         
        $config['upload_path'] = './assets/posts/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'jpg|gif|png|jpeg|JPG|PNG';
        $config['max_size'] = 10000;
         
        $this->load->library('upload', $config);
         
        if ( ! $this->upload->do_upload('image_file'))
        {
        	$error = array('error' => $this->upload->display_errors());

        	echo "<br/>".$this->upload->display_errors();
        }
             


        $response = array(
        	'url' => base_url().'/assets/posts/'.$fileName,
        	'name' => $fileName
        );

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
	 * ----------------------------------------------------------------------------
	 *
	 *
	 */

	public function store()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$user_id = $input_data['user_id'];
		$description = $input_data['description'];

		$data = array(
			'USER_ID'		=> $user_id,
			'DESCRIPTION'	=> $description
		);

		$this->db->insert('B_POSTS', $data);

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
		$this->db->delete('B_POSTS', $data_delete);

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

		$user_id = $input_data['user_id'];
		$description = $input_data['description'];

		$data = array(
			'USER_ID'		=> $user_id,
			'DESCRIPTION'	=> $description
		);

		$where = array(
			'ID' => $id
		);

		$this->db->where($where);
		$this->db->update('B_POSTS',$data);

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
	

	// ------------------------------------------------------------------ IMAGE

	public function store_image()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$post_id = $input_data['post_id'];
		$image = $input_data['image'];
		$description = $input_data['description'];

		$data = array(
			'POST_ID'		=> $post_id,
			'IMAGE'			=> $image,
			'DESCRIPTION'	=> $description
		);

		$this->db->insert('B_POST_IMAGES', $data);

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

	public function delete_image($id)
	{
		$data_delete = array(
			'ID'		=> $id
		);
		$this->db->delete('B_POST_IMAGES', $data_delete);

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

	// ------------------------------------------------------- TAG

	public function store_tag()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$post_id = $input_data['post_id'];
		$tag_id = $input_data['tag_id'];

		$data = array(
			'POST_ID'		=> $post_id,
			'TAG_ID'		=> $tag_id
		);

		$this->db->insert('B_POST_TAGS', $data);

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

	public function delete_tag($id)
	{
		$data_delete = array(
			'ID'		=> $id
		);
		$this->db->delete('B_POST_TAGS', $data_delete);

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


	// ----------------------------------------------------------------------- LIKE

	public function store_like()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$post_id = $input_data['post_id'];
		$user_id = $input_data['user_id'];
		$type = $input_data['type'];

		$data = array(
			'POST_ID'		=> $post_id,
			'USER_ID'		=> $user_id,
			'TYPE'			=> $type
		);

		$this->db->insert('B_LIKE_POSTS', $data);

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

	public function delete_like($id)
	{
		$data_delete = array(
			'ID'		=> $id
		);
		$this->db->delete('B_LIKE_POSTS', $data_delete);

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


	// ----------------------------------------------------------------------- APPROVE

	public function store_approve()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$post_id = $input_data['post_id'];
		$user_id = $input_data['user_id'];
		$approve = $input_data['approve'];

		$data = array(
			'POST_ID'		=> $post_id,
			'USER_ID'		=> $user_id,
			'APPROVE'		=> $approve
		);

		$this->db->insert('B_POST_APPROVES', $data);

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

	public function update_approve($id)
	{
		$data = array(
			'APPROVE' => 'y'
		);
	 
		$where = array(
			'ID' => $id
		);
	 
		$this->db->where($where);
		$this->db->update('B_POST_APPROVES',$data);


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

}