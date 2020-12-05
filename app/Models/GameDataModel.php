<?php namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class GameDataModel extends Model 
{
	protected $db;

	public function __construct()
	{
        $this->db = \Config\Database::connect();
	}

	public function get_data($owner_id, $game_session_id) {
		$builder = $this->db->table('game_data');
		
		$builder->select('data');

		$builder->where('game_session_id', $game_session_id);
		$builder->where('owner_id', $owner_id);


		return $builder->get()->getResult();
	}

	public function get_current_data($game_session_id) {
		$builder = $this->db->table('game_data');
		$builder->select('current_data');
		$builder->where('game_session_id', $game_session_id);
		
		return $builder->get()->getResult();
	}

	public function set_current_data($game_session_id, $owner_id, $data) {
		$builder = $this->db->table('game_data');
		$builder->where('game_session_id', $game_session_id);
		$builder->where('owner_id', $owner_id);

		$array = [
			'current_data'   => urlencode($data),
		];
	
		$builder->update($array);

		return true;

	}

	public function get_game_type($id) {
		$builder = $this->db->table('game_sessions');
		$builder->select('game_id');
		$builder->where('id', $id);

		return $builder->get()->getResult();

	}

}
