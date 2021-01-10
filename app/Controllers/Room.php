<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\GameModel;
use App\Models\GameDataModel;

class Room extends Controller {

	public function index($id) {

		$session = session();
		$gameModel = new GameModel();
        $query = $gameModel->is_enrolled($id, $_SESSION['user_id']);
		if(count($query) > 0) {
			$gameDataModel = new GameDataModel();

			$data = $gameDataModel->get_game_type($id);

			if($data[0]->game_id == 3) {
				return view('room/fortune/index');
			} else if ($data[0]->game_id == 1) {
				return view('room/jeopardy/index');
			} else if($data[0]->game_id == 4) {
				return view('room/family_feud/index');
			} else {
				return redirect()->to('/auth/signin');
			}
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
