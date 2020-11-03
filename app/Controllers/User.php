<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;

class User extends Controller {

	public function index() {
		
		$session = session();

		if(!isset($_SESSION['logged_in'])) {
			echo view('base/header');
			echo view('user/dashboard');
			echo view('base/footer');
		} else {
			return redirect()->to('/auth/signin');
		}			
	}

	public function get_username() {
		$session = session();
		$usersModel = new UsersModel();

        $query = $usersModel->get_where([
			'id' => $_SESSION['user_id'],
		]);

		$username = $query[0]->firstname;
		$username .= " ".$query[0]->lastname;

		echo json_encode([
			'username' => $username,
			'id' => $_SESSION['user_id'],
			'logged_in' => $_SESSION['logged_in']
		]);

	}

}
