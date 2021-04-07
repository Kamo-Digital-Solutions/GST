<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class AdminRoomModel extends Model 
{
	protected $db;
	protected $validation;

	public function __construct()
	{
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();
	}

	// there is an error here
	public function get_where($data) {
		$builder = $this->db->table('game_sessions_enrollements');
		foreach($data as $key => $value) {
			$query = $builder->getWhere([$key => $value]);
		}
		return $query->getResult();
	}

	public function is_host($data) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->where('user_id', $data);
		$builder->where('is_host', 1);

		return $builder->get()->getResult();
	}

	public function add_session_id($id, $session_id) {
		$builder = $this->db->table('game_sessions');

		$data = [
			'session_id' => $session_id,
		];
	
		$builder->where('id', $id);

		$builder->update($data);
		
		return true;
	}

	public function get_jeopardy_categories() {
		$builder = $this->db->table('jeopardy_category');

		return $builder->get()->getResult();
	}

}
