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

	public function get_where($data) {
		$builder = $this->db->table('game_sessions_enrollements');
		foreach($data as $key => $value) {
			$query = $builder->getWhere([$key => $value]);
		}
		return $query->getResult();
	}

	public function is_host($data) {
		$builder = $this->db->table('game_sessions_enrollements');
		$query = $builder->getWhere(['user_id' => $data]);
		$query = $builder->getWhere(['is_host' => 1]);

		return $query->getResult();
	}


}
