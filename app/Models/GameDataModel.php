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

		$query = $builder->getWhere(['owner_id' => $owner_id]);
		$query = $builder->getWhere(['game_session_id' => $game_session_id]);

		return $query->getResult();
	}

}
