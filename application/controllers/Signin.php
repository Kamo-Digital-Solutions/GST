<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {

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
        if(!isset($_SESSION['logged_in'])  ):

        $this->load->view('resourcefiles/header');
		$this->load->view('signin');
		$this->load->view('resourcefiles/footer');

        else:
redirect(base_url('index.php/Welcome'), 'refresh');
        endif;
    }
    
    public function VerifyLogin(){


        $query = $this->db->get_where('teams',array(
            'email' => $this->input->post('email'),
            'password'=> md5($this->input->post('password'))
        
        )
    );

        if($query->num_rows() > 0):
            
            foreach ($query->result() as $row)
            {
                $this->session->set_userdata('logged_in','true');
                $this->session->set_userdata('user_id',$row->id);
                $this->session->set_userdata('team_id',$row->team_id);
                redirect(base_url('index.php/Welcome'), 'refresh');

            }
            

        else:
            echo "<h1>Login Failed! May Be Username or Password Invalid</h1>";
        endif;    

        

    }

    public function logout(){
        unset($_SESSION['logged_in']);
        session_destroy();
        redirect(base_url('index.php/Signin'), 'refresh');

    }


}

