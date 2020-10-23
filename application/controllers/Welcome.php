<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true):
		

		$data = $this->db->get_where("teams",array("team_id" => $_SESSION['team_id']));
		$result['output'] = $data->result_array();
		

		

		
		

		
		
		$this->load->view('resourcefiles/header');
		$this->load->view('welcome_message',$result);
		$this->load->view('resourcefiles/footer');

		else:
			redirect(base_url('index.php/Signin'), 'refresh');
		endif;	


	}


}



