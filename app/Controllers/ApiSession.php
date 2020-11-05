<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

use Stopka\OpenviduPhpClient\Session\SessionPropertiesBuilder;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;

use App\Models\UsersModel;
use App\Models\GameModel;
use App\Models\AdminRoomModel;


class ApiSession extends Controller {

	public function create_tokens($id) {
		$session = session();

		// todo: Add these to settings table
		$OPENVIDU_URL = "https://localhost:4443 "; // Where the OpenVidu server is located.
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

		echo "Done";

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
		$OPENVIDU_URL = "https://localhost:4443 "; // Where the OpenVidu server is located.
		$OPENVIDU_SECRET = "16379284-8725-4411-82fd-6dabdf2ca468"; // Our OpenVidu Pro Key
		
		$openvidu = new OpenVidu($OPENVIDU_URL, $OPENVIDU_SECRET);
		$sessionProperties = new SessionPropertiesBuilder();

		$session = $openvidu->createSession($sessionProperties->build());
		// END OF TEMP DATA

		$tokenData = "";

		$tokenOptions = new TokenOptionsBuilder();
		$tokenOptions->setRole(OpenViduRoleEnum::PUBLISHER)
					->setData(json_encode($tokenData));
		$token = $session->generateToken($tokenOptions->build(), $sessionID);


		// return token
        echo json_encode([
            'token' => $token,
		]);
		
	}

	public function get_users_score($session_id) {
		$session = session();
		$request = \Config\Services::request();

		// Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		$game_session = $request->getPost('game_session');

			// ToDo: Check if he is a participant in this game session

			$gameModel = new GameModel();
			//$user_id = $_SESSION['user_id'];

			$scores = $gameModel->get_users_score($session_id);

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

		// Check if he logged in
		//if(!isset($_SESSION['logged_in'])) {
		//	return redirect()->to('/auth/signin');
		//}

		$game_session = $request->getPost('game_session');
		$user_id = $request->getPost('user_id');
		$score = $request->getPost('score');

		// ToDo: Check if he is the host of this game session

		$gameModel = new GameModel();

		$gameModel->set_user_score($game_session, $user_id, $score);

		return $score;
	}
}
