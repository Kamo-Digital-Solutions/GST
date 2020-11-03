<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;

class Auth extends Controller {

	public function signin() {
		$request = \Config\Services::request();
		$session = session();


        if(!isset($_SESSION['logged_in'])) {
			echo view('base/header');
			echo view('auth/signin');
			echo view('base/footer');
		} else {
			return redirect()->to('/');
		}			
	}

	public function VerifyLogin() {

		$request = \Config\Services::request();
		$session = session();

		$usersModel = new UsersModel();


        $query = $usersModel->get_where([
			'email' => $request->getPost('email'),
			'password'=> md5($request->getPost('password'))
		]);

        if(count($query) == 1) {
            foreach ($query as $row) {			
				$session->set('logged_in','true');
                $session->set('user_id',$row->id);
                $session->set('team_id',$row->team_id);
                return redirect()->to('/');
            }
		} else {
			// Show error msg
            echo "<h1>Login Failed! May Be Username or Password Invalid</h1>";
		}
	}

	public function logout() {

		$request = \Config\Services::request();
		$session = session();

        unset($_SESSION['logged_in']);
        session_destroy();
		return redirect()->to('/auth/signin');
	}

	public function signup() {

		$request = \Config\Services::request();
		$session = session();


        if(!isset($_SESSION['logged_in'])) {
			echo view('base/header');
			echo view('auth/signup');
			echo view('base/footer');
		} else {
			return redirect()->to('/');
		}			
	}

	public function registration() {

		$request = \Config\Services::request();

		$usersModel = new UsersModel();

		$email = $request->getPost("email");
		$team_id  = $request->getPost("chooseteam");

		$verifyEmail = $usersModel->get_where(['email' => $email]);
		$countTeamMem = $usersModel->get_where(['team_id' => $team_id]);
		if(count($verifyEmail)>0) {
			echo "Email Exist Please Change Email";
		} else if(count($countTeamMem) >= 6) {
			echo "Team is Full";
		} else {
			// Uploading Image
			$file = $request->getFile("picture");

			if (!$file->isValid()) {
				throw new \RuntimeException($file->getErrorString().'('.$file->getError().')');
			} else {
	
				// Store the image on writable/uploads/users folder.
				$newName = $file->getRandomName();
				$path = $file->store('users/', $newName);
	
				$data = [
					'firstname' => $request->getPost('firstname'),
					'lastname' => $request->getPost('lastname'),
					'email' => $request->getPost('email'),
					'country' => $request->getPost('country'),
					'state' => $request->getPost('state'),
					'city' => $request->getPost('city'),
					'password' => md5($request->getPost('password')),
					'team_id' => $request->getPost('chooseteam'),
					'picture' => $newName,
				];

				echo $usersModel->add_user($data);
			}

		}
		return redirect()->to('/');
	}
}
