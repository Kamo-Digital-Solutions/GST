<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class GameModel extends Model 
{
	protected $db;
	protected $validation;

	public function __construct()
	{
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
	}

	public function set_user_score($game_session_id, $user_id, $score) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->where('game_session_id', $game_session_id);
		$builder->where('user_id', $user_id);

		$builder->set('score', 'score+'.$score, FALSE);
		$builder->update();
		
		return true;

	}

	public function get_users_score($session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->where('game_session_id', $session_id);

		return $builder->get()->getResult();
	}

}