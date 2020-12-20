<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

use Stopka\OpenviduPhpClient\Session\SessionPropertiesBuilder;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;

use App\Models\UsersModel;
use App\Models\GameDataModel;
use App\Models\GameModel;
use App\Models\AdminRoomModel;


class ApiSession extends Controller {

	public function create_tokens($id) {
		$session = session();

		// todo: Add these to settings table
		$OPENVIDU_URL = "https://beta.gameshowtime.com/"; // Where the OpenVidu server is located.
		$OPENVIDU_SECRET = "16379284-8725-4411-82fd-6dabdf2ca468"; // Our OpenVidu Pro Key

		// If he is not logged in, Redirect to Login
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		// Else, Create a new session and new tokens
		$openvidu = new OpenVidu($OPENVIDU_URL, $OPENVIDU_SECRET);
		$sessionProperties = new SessionPropertiesBuilder();

		$session = $openvidu->createSession($sessionProperties->build());


		// Save the new session id to the db
		$adminRoomModel = new AdminRoomModel();
		
		$adminRoomModel->add_session_id($id, $session->getSessionId());

		//echo "Done";

	}

	public function get_token($sessionid) {
		$session = session();

		// Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		// Check database and return a game session for the current user.
		//
		$user_id = $_SESSION['user_id'];
		$usersModel = new UsersModel();

		$sessionID = $usersModel->get_user_session($user_id, $sessionid)[0]->session_id;

		// create a token for user

		// TEMP DATA
		// todo: Add these to settings table
		$OPENVIDU_URL = "https://beta.gameshowtime.com/"; // Where the OpenVidu server is located.
		$OPENVIDU_SECRET = "16379284-8725-4411-82fd-6dabdf2ca468"; // Our OpenVidu Pro Key
		
		$openvidu = new OpenVidu($OPENVIDU_URL, $OPENVIDU_SECRET);
		$sessionProperties = new SessionPropertiesBuilder();

		$session = $openvidu->createSession($sessionProperties->build());
		// END OF TEMP DATA

		$tokenData = "";

		$tokenOptions = new TokenOptionsBuilder();
		$tokenOptions->setRole(OpenViduRoleEnum::PUBLISHER)
					->setData(json_encode($tokenData));
		$token = $session->generateToken($tokenOptions->build(), (string) $sessionID);

		// If there is no token, create one
		if($token == false) {
			$this->create_tokens($sessionid);
			
			$sessionID = $usersModel->get_user_session($user_id, $sessionid)[0]->session_id;
			$tokenOptions = new TokenOptionsBuilder();
			$tokenOptions->setRole(OpenViduRoleEnum::PUBLISHER)
						->setData(json_encode($tokenData));	
			$token = $session->generateToken($tokenOptions->build(), (string) $sessionID);
		}
		// return token
        echo json_encode([
            'token' => $token,
		]);
		
	}

	// To get Mute and Buzzer states
	public function get_user_state() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getGet('game_session');
		$user_id = $request->getGet('user_id');

		$gameModel = new GameModel();
		//$user_id = $_SESSION['user_id'];

		if(isset($user_id)) {
			$data = $gameModel->get_user_state($user_id, $game_session);
			echo json_encode([
				'mute' => $data[0]->mute,
				'buzzer' => $data[0]->buzzer,
			]);	
		} else {
			$data = $gameModel->get_users_states($game_session);

			echo json_encode([
				'data' => $data,
			]);	

		}

	}

	// To set Mute and Buzzer states
	public function set_user_state() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in and he is the host
		if(!isset($_SESSION['logged_in']) || !$this->checkHost()) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getPost('game_session');
		$user_id = $request->getPost('user_id');
		$mute = $request->getPost('mute');
		$buzzer = $request->getPost('buzzer');

		$gameModel = new GameModel();
		if(!isset($user_id) || $user_id <= 0)
			$user_id = -1;
		if(isset($mute))
			$data = $gameModel->set_user_state($user_id, $game_session, 'mute', $mute);

		if(isset($buzzer))
			$data = $gameModel->set_user_state($user_id, $game_session, 'buzzer', $buzzer);

		return true;
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


	public function get_users_score() {
		$session = session();
		$request = \Config\Services::request();

		// Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getGet('game_session');

			// ToDo: Check if he is a participant in this game session

			$gameModel = new GameModel();
			//$user_id = $_SESSION['user_id'];

			$scores = $gameModel->get_users_score($game_session);

			$scores_results = [];
			foreach($scores as $score) {
				array_push($scores_results, [
					"user_id" => $score->user_id,
					"score" => $score->score
				]);
			}			
			// return token
			echo json_encode([
				'scores' => $scores_results,
			]);
			
			return true;
		
	}

	public function set_user_score() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getPost('game_session');
		$user_id = $request->getPost('user_id');
		$score = $request->getPost('score');

		// ToDo: Check if he is the host of this game session

		$gameModel = new GameModel();

		$gameModel->set_user_score($game_session, $user_id, $score);

		return $score;
	}

	public function set_current_game_data() {
		$session = session();
		$request = \Config\Services::request();
		 
		//Check if he logged in
		 if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getPost('game_session');

		$game_data = $request->getPost('game_data');

		$gameDataModel = new GameDataModel();

		$current_data = $gameDataModel->set_current_data($game_session, $_SESSION['user_id'], $game_data);

		//var_dump($current_data);
		return true;
	}

	public function get_current_game_data() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}
		
		$game_session = $request->getGet('game_session');
		
		$gameDataModel = new GameDataModel();

		$current_data = $gameDataModel->get_current_data($game_session);

		echo json_encode([
			'code' => urldecode($current_data[0]->current_data),
		]);
		
		return true;
	}

	public function get_teams_data() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in
		if(!isset($_SESSION['logged_in']) || !$this->checkHost()) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getGet('game_session');

		$gameModel = new GameModel();

		$data = $gameModel->get_users_teams($game_session);

		echo json_encode([
			'data' => $data,
		]);
	}

	public function get_teams_name() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in
		if(!isset($_SESSION['logged_in']) || !$this->checkHost()) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getGet('game_session');

		$gameModel = new GameModel();

		$data = $gameModel->get_teams_name($game_session);

		echo json_encode([
			'data' => $data,
		]);

	}

	public function update_user_team() {
		$session = session();
		$request = \Config\Services::request();

		//Check if he logged in
		if(!isset($_SESSION['logged_in']) || !$this->checkHost()) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getPost('game_session');
		$user_id = $request->getPost('user_id');
		$team_id = $request->getPost('team_id');
				
		$gameModel = new GameModel();

		$data = $gameModel->update_user_team($game_session, $user_id, $team_id);

		return true;
	}
}
