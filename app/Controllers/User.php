<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;
use App\Models\GameModel;

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
		$request = \Config\Services::request();

		$session = session();
		$usersModel = new UsersModel();
		$gameModel = new GameModel();

        $query = $usersModel->get_where([
			'id' => $_SESSION['user_id'],
		]);

		$query2 = $gameModel->get_user_team_id($_SESSION['user_id'], $request->getGet("session_id"));

		$username = $query[0]->firstname;
		$username .= " ".$query[0]->lastname;
		
		echo json_encode([
			'username' => $username,
			'id' => $_SESSION['user_id'],
			'logged_in' => $_SESSION['logged_in'],
			'team_id' => $query2[0]->team_id
		]);

	}

}
