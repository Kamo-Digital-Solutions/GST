<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class UsersModel extends Model 
{
	protected $db;
	protected $validation;

	public function __construct()
	{
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
	}

	public function get_where($data) {
		$builder = $this->db->table('users');
		foreach($data as $key => $value) {
			$builder->where([$key => $value]);
		}
		return $builder->get()->getResult();
	}


	public function add_user($data) {
		$builder = $this->db->table('users');

		$builder->insert($data);

		return true;
	}

	public function get_user_session($user_id, $room_id) {
		
		$builder = $this->db->table('game_sessions');
		$builder->select('session_id');
		$builder->join('game_sessions_enrollements', 'game_sessions_enrollements.game_session_id = game_sessions.id');
		$builder->where(['game_sessions_enrollements.user_id' => $user_id]);
		$builder->where('game_sessions.id', $room_id);

		return $builder->get()->getResult();
	}

}
