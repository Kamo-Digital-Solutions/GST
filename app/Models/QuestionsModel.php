<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class QuestionsModel extends Model 
{
	protected $db;
	protected $validation;

	public function __construct()
	{
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
	}

    public function get_questions() {
		$builder = $this->db->table('questions');

		return $builder->get()->getResult();
    }


	public function add_question($data) {
		$builder = $this->db->table('questions');

		$builder->insert($data);
		
		return true;
	}

	public function get_question($id) {
		$builder = $this->db->table('questions');
		$builder->where('id', $id);

		return $builder->get()->getResult();
	}

	public function update_question($id, $data) {
		$builder = $this->db->table('questions');
		$builder->where('id', $id);
	
		$builder->update($data);

		return true;
	}

	public function delete_question($id) {
		$builder = $this->db->table('questions');

		$builder->where('id', $id);
		$builder->delete();

		return true;
	}


	// Linking questions with games

	public function link_question($question_id, $game_session_id) {

	}

	public function unlink_question($question_id, $game_session_id) {

	}

	// Genereate Game data

	public function generate_game_data() {

	}
	
}
