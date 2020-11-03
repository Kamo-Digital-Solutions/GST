<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Stopka\OpenviduPhpClient\OpenVidu;
use Stopka\OpenviduPhpClient\OpenViduRoleEnum;

use Stopka\OpenviduPhpClient\Session\SessionPropertiesBuilder;
use Stopka\OpenviduPhpClient\Session\Token\TokenOptionsBuilder;

use App\Models\UsersModel;


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

		// For every user, create tokens 

		// First we get all users enrolled in this session
		$usersModel = new UsersModel();
		$users = $usersModel->get_all_user_in_session($id);

		// If we want to send data to user, we put it here
		$tokenData = "";
		foreach ($users as $user) {			
			// Create a token
			$tokenOptions = new TokenOptionsBuilder();
			$tokenOptions->setRole(OpenViduRoleEnum::PUBLISHER)
						->setData(json_encode($tokenData));
			$token = $session->generateToken($tokenOptions->build());

			// Add token to the user table

			$usersModel->add_token($id, $user->id, $token);
		}

		echo "Done";

	}

	public function get_token($sessionid) {
		$session = session();

		// Check if he logged in
		if(!isset($_SESSION['logged_in'])) {
			return redirect()->to('/auth/signin');
		}

		// Check database and return a token for the current user.
		// Get user id
		$user_id = $_SESSION['user_id'];
		$usersModel = new UsersModel();

		$token = $usersModel->get_user_token($sessionid, $user_id)[0]->token;

        echo json_encode([
            'token' => $token,
		]);
		
	}

	public function test() {
		$OPENVIDU_URL = "https://localhost:4443 "; // Where the OpenVidu server is located.
		$OPENVIDU_SECRET = "16379284-8725-4411-82fd-6dabdf2ca468"; // Our OpenVidu Pro Key
		$openvidu = new OpenVidu($OPENVIDU_URL, $OPENVIDU_SECRET);
		var_dump($openvidu->getActiveSessions());
	}
}
