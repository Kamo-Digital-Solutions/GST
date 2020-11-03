<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;

use App\Models\AdminRoomModel;
use App\Models\GameDataModel;

class AdminRoom extends Controller {

	public function index($id) {
		return view('admin_room/index');
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
