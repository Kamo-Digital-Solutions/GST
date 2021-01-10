<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;

use App\Models\AdminRoomModel;
use App\Models\GameDataModel;

class AdminRoom extends Controller {

	public function index($id) {

		if($this->checkHost()) {
			$gameDataModel = new GameDataModel();

			$data = $gameDataModel->get_game_type($id);

			if($data[0]->game_id == 3)
				return view('admin_room/fortune/index');
			else if ($data[0]->game_id == 1) {
				return view('admin_room/jeopardy/index');
			} else if($data[0]->game_id == 4) {
				return view('admin_room/family_feud/index');
			} else {
				return redirect()->to('/');
			}
		} else {
			return redirect()->to('/');
		}
	}

	public function teams ($id) {
		if($this->checkHost()) {
			return view('admin_room/teams');
		} else {
			return redirect()->to('/');
		}
	}

	public function isHost() {
		$session = session();

		$adminRoomModel = new AdminRoomModel();
        $query = $adminRoomModel->is_host($_SESSION['user_id']);
		if(count($query) > 0) {
			echo json_encode([
				'result' => 'true',
			]);
		} else {
			echo json_encode([
				'result' => 'false',
			]);
		}
	}

	public function checkHost() {
		$session = session();

		$adminRoomModel = new AdminRoomModel();
        $query = $adminRoomModel->is_host($_SESSION['user_id']);
		if(count($query) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function get_game_session_data() {
		$session = session();
		$request = service('request');

		$owner_id = $_SESSION['user_id'];
		$game_session_id = $request->getPost('game_session_id');

		$gameDataModel = new GameDataModel();

		$data = $gameDataModel->get_data($owner_id, $game_session_id);

		echo json_encode([
			'result' => $data,
		]);
	}
}
