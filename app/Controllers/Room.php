<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\GameModel;

class Room extends Controller {

	public function index($id) {

		$session = session();
		$gameModel = new GameModel();
        $query = $gameModel->is_enrolled($id, $_SESSION['user_id']);
		if(count($query) > 0) {
			return view('room/index');
		} else {
			return redirect()->to('/auth/signin');
		}
	}

	public function getTeams($id) {
		$gameModel = new GameModel();
		$query = $gameModel->get_teams($id);
		$teams = [];
		foreach($query as $q) {
			if($q->team_id) {
				array_push($teams, $q->team_id);
			}
		}
		echo json_encode([
			'result' => $teams,
		]);

	}
}
