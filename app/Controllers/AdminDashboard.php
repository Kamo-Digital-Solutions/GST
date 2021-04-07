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
			$adminRoomModel = new AdminRoomModel();

			$data = [
				"question" => $questionsModel->get_question($id),
				"categories" => $adminRoomModel->get_jeopardy_categories(),
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
				"category_id" => $request->getPost("categoryId"),
				"answer" => $request->getPost("questionAnswer"),
				"media_attachement" => $newName,
			];	
		} else {
			$data = [
				"question_text" => $request->getPost("questionText"),
				"category_id" => $request->getPost("categoryId"),
				"answer" => $request->getPost("questionAnswer"),
			];	
		}

		$id = $request->getPost("qId");
		$questionsModel->update_question($id, $data);
		
		return redirect()->to('/admin/dashboard/questions');
	}

	public function add_jeopardy() {
		if($this->isAdmin()) {
			$session = session();
			$adminRoomModel = new AdminRoomModel();

			$data = [
				"categories" => $adminRoomModel->get_jeopardy_categories()
			];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/jeopardy/add_game', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	public function update_jeopardy() {
		if($this->isAdmin()) {
			$session = session();
			$adminRoomModel = new AdminRoomModel();

			$data = [
				"categories" => $adminRoomModel->get_jeopardy_categories()
			];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/jeopardy/add_game', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	public function update_jeopardy_form() {
		if($this->isAdmin()) {
			$session = session();
			$adminRoomModel = new AdminRoomModel();

			$data = [
				"categories" => $adminRoomModel->get_jeopardy_categories()
			];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/jeopardy/add_game', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	// Categories

	public function categories() {
		if($this->isAdmin()) {
			$session = session();
			$adminRoomModel = new AdminRoomModel();

			$data = [
				"categories" => $adminRoomModel->get_jeopardy_categories()
			];
			
			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/jeopardy/categories', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}

	}

	public function add_category() {
		if($this->isAdmin()) {
			$session = session();

			$data = [
			];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/jeopardy/add_category', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}
	}

	public function add_category_form() {
		
		$request = \Config\Services::request();

		$questionsModel = new QuestionsModel();
				
		$data = [
			"name" => $request->getPost("categoryName"),
		];

		$questionsModel->add_category($data);
		
		return redirect()->to('/admin/dashboard/categories');

	}

	public function update_category($id) {
		if($this->isAdmin()) {
			$session = session();
			$questionsModel = new QuestionsModel();

			$categoryName = ($questionsModel->get_category($id))[0]->name;
			$data = [
				"id" => $id,
				"categoryName" => $categoryName,
			];

			echo view('admin_dashboard/base/header');
			echo view('admin_dashboard/jeopardy/update_category', $data);
			echo view('admin_dashboard/base/footer');
		} else {
			return redirect()->to('/');
		}

	}

	public function update_category_form() {
		$request = \Config\Services::request();

		$questionsModel = new QuestionsModel();
				
		$data = [
			"name" => $request->getPost("categoryName"),
		];

		$id = $request->getPost("cId");
		$questionsModel->update_category($id, $data);
		
		return redirect()->to('/admin/dashboard/categories');
	}

	public function delete_category($id) {
		$questionsModel = new QuestionsModel();
		$questionsModel->delete_category($id);

		return redirect()->to('/admin/dashboard/categories');
	}

	public function get_category_questions($id) {
		if($this->isAdmin()) {
			$session = session();
			$questionsModel = new QuestionsModel();

			$data = [
				"questions" => $questionsModel->get_category_questions($id)
			];

			echo json_encode([
				'data' => $data,
			]);	

		} else {
			echo json_encode([
				'eroor' => 'You are not an admin.',
			]);	
		}

	}

	// End of Categories


	public function add_jeopardy_form() {
		// TODO: Missing Media attachement!
		$request = \Config\Services::request();

		$questionsModel = new QuestionsModel();
				
		$scores = "[".$request->getPost("score1").",".$request->getPost("score2").",".$request->getPost("score3").",".$request->getPost("score4").",".$request->getPost("score5")."]";

		$data = [
			"scores_r1" => $scores,
			"scores_r2" => $scores,
			"categoryid_1" => $request->getPost("category1_1"),
			"categoryid_2" => $request->getPost("category1_2"),
			"categoryid_3" => $request->getPost("category1_3"),
			"categoryid_4" => $request->getPost("category1_4"),
			"categoryid_5" => $request->getPost("category1_5"),

			"categoryid_6" => $request->getPost("category2_1"),
			"categoryid_7" => $request->getPost("category2_2"),
			"categoryid_8" => $request->getPost("category2_3"),
			"categoryid_9" => $request->getPost("category2_4"),
			"categoryid_10" => $request->getPost("category2_5"),

			"final_jeopardy_question" => $request->getPost("questionText"),
			"final_jeopardy_answer" => $request->getPost("questionAnswer"),
			"final_jeopardy_score" => $request->getPost("final_jeopardy_score"),
			"double_jeopardy_r1" => "(".$request->getPost("category_double_r1").",".$request->getPost("category_question_double_r1").")",
			"double_jeopardy_r2" => "(".$request->getPost("category_double_r2").",".$request->getPost("category_question_double_r2").")",
		];

		$questionsModel->add_jeopardy($data);
		
		return redirect()->to('/admin/dashboard/games');

	}

	public function edit_jeopardy() {

	}

	public function delete_jeopardy() {

	}
}
