<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	-  -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(isset($_SESSION['logged_in']) == false):
		$this->load->view('resourcefiles/header');
		$this->load->view('signup');
		$this->load->view('resourcefiles/footer');
		else:
			redirect(base_url('index.php/Welcome'), 'refresh');
		endif;	
	}


		public function registeration(){
		//$this->db
		$email = $this->input->post('email');
		$team_id  = $this->input->post('chooseteam');
		$countryState  = $this->input->post('country').",".$this->input->post('state').",".$this->input->post('city');

		$verifyEmail = $this->db->get_where('teams',array('email' => $email ));
		$countTeamMem = $this->db->get_where('teams',array('team_id' => $team_id));
	
	
		if($verifyEmail->num_rows() > 0):
			echo "Email Exist Please Change Email";
		elseif($countTeamMem->num_rows() >= 6):
			echo "Team is Full";
		else:

			$config['upload_path']          = "./assets/upload/";
			$config['allowed_types']        = 'gif|jpg|png';

			$config['encrypt_name'] = true;
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('picture'))
			{
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
			}
else{
	
	$data = $this->upload->data();
	$filename  = $data['file_name'];

	if($this->db->insert('teams',array(
		'firstname' => $this->input->post('firstname'),
		'lastname' => $this->input->post('lastname'),
		'email' => $this->input->post('email'),
		'statecity' =>$countryState,
		'password' => md5($this->input->post('')),
		'team_id' => $this->input->post('chooseteam'),
		'picture' => $filename,
)) == TRUE):

echo "Member registered";


else:
	
	echo "Failed";
endif;

}

		endif;	
	

	}

}

