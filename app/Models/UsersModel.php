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
			$query = $builder->where([$key => $value]);
		}
		return $query->get()->getResult();
	}


	public function add_user($data) {
		$builder = $this->db->table('users');

		$builder->insert($data);

		return true;
	}

	public function get_all_user_in_session($session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$query = $builder->where(['game_session_id' => $session_id]);
		return $query->get()->getResult();

	}

	public function get_user_token($session_id, $user_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$query = $builder->where(['game_session_id' => $session_id]);
		$query = $builder->where(['user_id' => $user_id]);
		return $query->get()->getResult();
	}

	public function add_token($session_id, $user_id, $token) {
		$builder = $this->db->table('game_sessions_enrollements');

		$data = [
			'token' => $token,
		];
	
		$builder->where('game_session_id', $session_id);
		$builder->where('user_id', $user_id);

		$builder->update($data);
		
		return true;
	}
}
