<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\IncomingRequest;

use App\Models\AdminRoomModel;
use App\Models\GameDataModel;
use App\Models\GameModel;
use App\Models\QuestionsModel;

class AdminDashboard extends Controller {

	public function isAdmin() {
		$session = session();
        return true;
		$adminRoomModel = new AdminRoomModel();
        $query = $adminRoomModel->is_host($_SESSION['user_id']);
		if(count($query) > 0) {
			return true;
		} else {
			return false;
		}
	}

    public function index() {
        if($this->isAdmin()) {
			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/index');
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}

    }

	public function games() {
		if($this->isAdmin()) {
			$gameModel = new GameModel();
			$games = $gameModel-> get_games();
			
			$data = [
				"games" => $games
			];
			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/games', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	// Questions
	public function questions() {
		if($this->isAdmin()) {
			$questionsModel = new QuestionsModel();
			$questions = $questionsModel-> get_questions();
			
			$data = [
				"questions" => $questions
			];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/questions', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	public function add_question() {
		if($this->isAdmin()) {

			$data = [];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/add_question', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	public function add_question_form() {
		$request = \Config\Services::request();

		$questionsModel = new QuestionsModel();
		
		$file = $this->request->getFile('mediaInputFile');
		
		/*
		.jpg/png, .mp3, .mov/.mp4
		echo $file->guessExtension();
		*/

		$newName = $file->getRandomName();
		$file->move(WRITEPATH.'uploads', $newName);

		$data = [
			"question_text" => $request->getPost("questionText"),
			"answer" => $request->getPost("questionAnswer"),
			"media_attachement" => $newName,
			"created_at" => date('Y-m-d H:i:s', time())
		];

		$questionsModel->add_question($data);
		
		return redirect()->to('/admin/dashboard/questions');
	}

	public function delete_question($id) {
		$questionsModel = new QuestionsModel();
		$questionsModel->delete_question($id);

		return redirect()->to('/admin/dashboard/questions');

	}

	public function update_question($id) {
		
		if($this->isAdmin()) {

			$questionsModel = new QuestionsModel();
		
			$data = [
				"question" => $questionsModel->get_question($id),
				"id" => $id
			];
	
			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/update_question', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}

	}

	public function update_question_form() {
		$request = \Config\Services::request();

		$questionsModel = new QuestionsModel();
		
		$file = $this->request->getFile('mediaInputFile');
		
		/*
		.jpg/png, .mp3, .mov/.mp4
		echo $file->guessExtension();
		*/
		if($file->isValid()) {
			$newName = $file->getRandomName();
			$file->move(WRITEPATH.'uploads', $newName);
			$data = [
				"question_text" => $request->getPost("questionText"),
				"answer" => $request->getPost("questionAnswer"),
				"media_attachement" => $newName,
			];	
		} else {
			$data = [
				"question_text" => $request->getPost("questionText"),
				"answer" => $request->getPost("questionAnswer"),
			];	
		}

		$id = $request->getPost("qId");
		$questionsModel->update_question($id, $data);
		
		return redirect()->to('/admin/dashboard/questions');
	}

	public function add_game() {

	}

	public function edit_game() {

	}

	public function delete_game() {

	}
}
