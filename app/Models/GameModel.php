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


	public function is_enrolled($session_id, $user_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->where('game_session_id', $session_id);
		$builder->where('user_id', $user_id);

		return $builder->get()->getResult();
	}

	public function get_teams($session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->select('team_id');
		$builder->orderBy('team_id', 'ASC');
		$builder->distinct();
		$builder->where('game_session_id', $session_id);

		return $builder->get()->getResult();
	}

	public function get_teams_name($session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->join('teams', 'teams.id = game_sessions_enrollements.team_id');
		$builder->select('team_id, team_name');
		$builder->orderBy('team_id', 'ASC');
		$builder->distinct();
		$builder->where('game_session_id', $session_id);

		return $builder->get()->getResult();
	}

	public function update_user_team($game_session, $user_id, $team_id) {
		
		$builder = $this->db->table('game_sessions_enrollements');

		$builder->where('game_session_id', $game_session);
		$builder->where('user_id', $user_id);

		$builder->set("team_id", $team_id);
		$builder->update();
		
		return true;
	}

	public function get_users_teams($session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->join('users', 'users.id = game_sessions_enrollements.user_id');
		$builder->join('teams', 'teams.id = game_sessions_enrollements.team_id');
		$builder->where('game_session_id', $session_id);

		return $builder->get()->getResult();
	}


	public function get_user_team_id($user_id, $session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->where('game_session_id', $session_id);
		$builder->where('user_id', $user_id);
		
		return $builder->get()->getResult();
	}

	public function get_user_state($user_id, $session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->select('mute, buzzer');
		$builder->where('game_session_id', $session_id);
		$builder->where('user_id', $user_id);

		return $builder->get()->getResult();
	}

	public function get_users_states($session_id) {
		$builder = $this->db->table('game_sessions_enrollements');
		$builder->select('user_id, mute, buzzer');
		$builder->where('game_session_id', $session_id);

		return $builder->get()->getResult();
	}


	public function set_user_state($user_id, $session_id, $field, $data) {
		$builder = $this->db->table('game_sessions_enrollements');

		$builder->where('game_session_id', $session_id);
		
		if($user_id > 0)
			$builder->where('user_id', $user_id);

		$builder->set($field, $data);
		$builder->update();
		
		return true;
	}

	public function get_games() {
		$builder = $this->db->table('game_data');
		$builder->join('users', 'users.id = game_data.owner_id');
		$builder->join('game_sessions', 'game_sessions.id = game_data.game_session_id');
		$builder->join('games', 'games.id = game_sessions.game_id');

		$builder->select('game_data.id as id, users.firstname as firstname, users.lastname as lastname, game_data.game_session_id as game_session_id, games.name as gametype');

		return $builder->get()->getResult();
	}
}
