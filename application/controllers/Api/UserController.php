<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User');

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
		$response = $this->User->getAll()->result();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getById($id)
	{
		$response = $this->User->getById($id)->row();

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}




	/**
	 * ----------------------------------------------
	 * AUTHORIZATION
	 * ----------------------------------------------
	 *
	 *
	 */

	public function login()
	{
		// $username = $this->input->post('username');
		// $password = $this->input->post('password');

		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$username = $input_data['email'];
		$password = $input_data['password'];

		$result = $this->User->login($username, $password);

		if($result) {
			date_default_timezone_set('Europe/Bucharest');
			// $tw = date('Y') . (int)ceil(date('m')/3);

			$response['token'] = 'Basic '.$this->getToken($username);
		} else {
			$response['errors'] = '{"type": "invalid"}';
		}

		$this->output
			 ->set_status_header(200)
			 ->set_content_type('application/json', 'utf-8')
			 ->set_output(json_encode($response, JSON_PRETTY_PRINT))
			 ->_display();
			 exit;
	}

	public function getToken($username)
	{
		$token = array();
		$token['username'] = $username;
		// $token['tw'] = $tw;

		return  JWT::encode($token, 'token');
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
         
        $config['upload_path'] = './assets/users/';
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
        	'url' => base_url().'/assets/users/'.$fileName,
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
	 *
	 */

	public function store()
	{
		$input_data = json_decode(trim(file_get_contents('php://input')), true);

		$bidang_id = $input_data['bidang_id'];
		$name = $input_data['name'];
		$email = $input_data['email'];
		$password = $input_data['password'];
		$avatar = $input_data['avatar'];
		$color = $input_data['color'];


		$data = array(

			'BIDANG_ID'		=> $bidang_id,
			'NAME'			=> $name,
			'EMAIL'			=> $email,
			'PASSWORD'		=> $password,
			'AVATAR'		=> $avatar,
			'COLOR'			=> $color
		);

		$this->db->insert('B_USERS', $data);

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
		$this->db->delete('B_USERS', $data_delete);

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

		$bidang_id = $input_data['bidang_id'];
		$name = $input_data['name'];
		$email = $input_data['email'];
		$password = $input_data['password'];
		$avatar = $input_data['avatar'];
		$color = $input_data['color'];

		$data = array(
			'BIDANG_ID'		=> $bidang_id,
			'NAME'			=> $name,
			'EMAIL'			=> $email,
			'PASSWORD'		=> $password,
			'AVATAR'		=> $avatar,
			'COLOR'			=> $color
		);

		$where = array(
			'ID' => $id
		);

		$this->db->where($where);
		$this->db->update('B_USERS',$data);

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