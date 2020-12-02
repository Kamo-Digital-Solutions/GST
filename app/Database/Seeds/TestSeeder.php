<?php namespace APP\Database\Seeds;

class TestSeeder extends \CodeIgniter\Database\Seeder {
	public function run() {

		////////////////////////////////////////////////////////
		// Users Model
		////////////////////////////////////////////////////////

		$data = [
			'firstname' => 'Hichem',
			'lastname' => 'Raz',
			'email' => 'hichemraz@gmail.com',
			'country' => 'USA',
			'state' => 'NY',
			'city' => 'NYC',
			'password' => '6ebe76c9fb411be97b3b0d48b791a7c9', // Paasword: 987654321
			'team_id' => '',
			'picture' => '',
		];
		// Using Query Builder
		$this->db->table("users")->insert($data);

		// We will add another user as a host/admin
		$data = [
			'firstname' => 'admin',
			'lastname' => 'admouna',
			'email' => 'hichem@gmail.com',
			'country' => 'USA',
			'state' => 'NY',
			'city' => 'NYC',
			'password' => '25f9e794323b453885f5181f1b624d0b', // Paasword: 123456789
			'team_id' => '',
			'picture' => '',
		];
		// Using Query Builder
		$this->db->table("users")->insert($data);

		// More user data for teams

		$data = [
			'firstname' => 'Mike',
			'lastname' => 'Simpsong',
			'email' => 'mike@gmail.com',
			'country' => 'USA',
			'state' => 'NY',
			'city' => 'NYC',
			'password' => '6ebe76c9fb411be97b3b0d48b791a7c9', // Paasword: 987654321
			'team_id' => '',
			'picture' => '',
		];
		// Using Query Builder
		$this->db->table("users")->insert($data);

		$data = [
			'firstname' => 'Ronaldo',
			'lastname' => 'Gon',
			'email' => 'ronaldo@gmail.com',
			'country' => 'USA',
			'state' => 'NY',
			'city' => 'NYC',
			'password' => '6ebe76c9fb411be97b3b0d48b791a7c9', // Paasword: 987654321
			'team_id' => '',
			'picture' => '',
		];
		// Using Query Builder
		$this->db->table("users")->insert($data);



		////////////////////////////////////////////////////////
		// Games Model
		////////////////////////////////////////////////////////

		///////////////
		// Jeopardy ///
		///////////////
		$data = [
			'name' => 'Jeopardy',
		];
		// Using Query Builder
		$this->db->table("games")->insert($data);

		//////////////////////
		// Deal or no deal ///
		//////////////////////
		$data = [
			'name' => 'Deal or no deal',
		];
		// Using Query Builder
		$this->db->table("games")->insert($data);

		//////////////////////
		// Wheel of fortune //
		//////////////////////

		$data = [
			'name' => 'Wheel of fortune',
		];
		// Using Query Builder
		$this->db->table("games")->insert($data);
		

		//////////////////
		// Family Feud ///
		//////////////////

		$data = [
			'name' => 'Family Feud',
		];
		// Using Query Builder
		$this->db->table("games")->insert($data);


		////////////////////////////////////////////////////////
		// Game Session Model
		////////////////////////////////////////////////////////


		// Example of Jeopardy Game

		$data = [
			'game_id' => 1,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("game_sessions")->insert($data);

		// Example of Wheel of fortune Game

		$data = [
			'game_id' => 3,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("game_sessions")->insert($data);


		////////////////////////////////////////////////////////
		// Game Session Enrollments Model
		////////////////////////////////////////////////////////

		// Jeopardy Game

		$data = [
			'game_session_id' => 1,
			'team_id' => 1,
			'user_id' => 1,
			'score' => 0,
			'rank' => 0,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);

		$data = [
			'game_session_id' => 1,
			'team_id' => 1,
			'user_id' => 3,
			'score' => 0,
			'rank' => 0,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);

		$data = [
			'game_session_id' => 1,
			'team_id' => 2,
			'user_id' => 4,
			'score' => 0,
			'rank' => 0,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);

		// We will add another game enrollments for the host/admin
		$data = [
			'game_session_id' => 1,
			'user_id' => 2,
			'score' => 0,
			'rank' => 0,
			'is_host' => 1,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);


		///////////////////////
		// Wheel of fortune //
		//////////////////////


		$data = [
			'game_session_id' => 2,
			'team_id' => 1,
			'user_id' => 1,
			'score' => 0,
			'rank' => 0,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);

		$data = [
			'game_session_id' => 2,
			'team_id' => 2,
			'user_id' => 3,
			'score' => 0,
			'rank' => 0,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);

		$data = [
			'game_session_id' => 2,
			'team_id' => 2,
			'user_id' => 4,
			'score' => 0,
			'rank' => 0,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);


		// We will add another game enrollments for the host/admin
		$data = [
			'game_session_id' => 2,
			'user_id' => 2,
			'score' => 0,
			'rank' => 0,
			'is_host' => 1,
		];
		// Using Query Builder
		$this->db->table("game_sessions_enrollements")->insert($data);
		

		////////////////////////////////////////////////////////
		// Teams Model
		////////////////////////////////////////////////////////

		$data = [
			'team_name' => "The Wolfs",
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("teams")->insert($data);


		$data = [
			'team_name' => "Virus",
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("teams")->insert($data);


		////////////////////////////////////////////////////////
		// Members Model
		////////////////////////////////////////////////////////

		$data = [
			'user_id' => 1,
			'team_id' => 1,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("members")->insert($data);


		$data = [
			'user_id' => 3,
			'team_id' => 1,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("members")->insert($data);


		$data = [
			'user_id' => 4,
			'team_id' => 2,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("members")->insert($data);

		////////////////////////////////////////////////////////
		// Game Data Model
		////////////////////////////////////////////////////////

		// Jeopardy
		// [{"category":"Final Jeopardy","questions":[{"points":9000,"question":"Name the three gifts given by the Wise Men and the Bible reference.","answer":"Gold, Frankincense, and Myrrh<br/>(Ref: Matthew 2:11)"}]},{"category":"Pop Culture","questions":[{"points":100,"question":"This reindeer shares a name with a famous symbol of Valentine’s Day.","answer":"Cupid"},{"points":200,"question":"Animated 2004 film about a train that carries kids to the North Pole on Christmas Eve.","answer":"Polar Express"},{"points":300,"question":"Holiday celebrated in Canada, the U.K., and several other British Commonwealth countries on the day after Christmas.","answer":"Boxing Day"},{"points":400,"question":"Governor of California, Arnold Schwarzenegger, plays a father who tries to buy a toy for his son in this movie.","answer":"Jingle All the Way"},{"points":500,"question":"Actor who plays the thief, Harry Lime, in Home Alone 1 and Home Alone 2.","answer":"Joe Pesci"}]},{"category":"Jesus' Birth","questions":[{"points":100,"question":"These two Gospels do <strong>NOT</strong> account the birth of Jesus.","answer":"Mark and John"},{"points":200,"question":"How did the shepherds learn of Christ's birth?<br><ul><li>A new star in the sky</li><li>The magi told them</li><li>An angel appeared to them</li><li>Shepherds don’t exist</li></ul>","answer":"An angel appeared to them<br/>(Ref: Luke 2:8-9)"},{"points":300,"question":"Where was Jesus when the magi came to visit Him?","answer":"In a house<br/>(Ref: Matthew 2:11)"},{"points":400,"question":"In a dream, an angel tells Joseph to name his child Jesus, for it was prophesied that a virgin would give birth and call her son Immanuel. What does Immanuel mean?","answer":"God With Us"},{"points":500,"question":"The magi ask Herod where Christ is to be born. Herod summons his priests and scribes, who know the location of the birth because of the prophecy of this man.","answer":"Micah<br/>(Ref: Micah 5:2 & Matthew 2:6)"}]},{"category":"Christmas Carols","questions":[{"points":100,"question":"The first seven words to Jingle Bell Rock.","answer":"Jingle Bell, Jingle Bell, Jingle Bell Rock"},{"points":200,"question":"This Christmas hymn’s second verse begins with “O sing, choirs of angels\"","answer":"O Come All Ye Faithful"},{"points":300,"question":"This Christmas song’s second verse begins with \"The cattle are lowing\"","answer":"Away in a Manger"},{"points":400,"question":"On the tenth day, my true love gave to me.","answer":"10 Lords-a-Leaping"},{"points":500,"question":"This Christmas carol was composed by Franz Xaver Gruber to lyrics by Joseph Mohr in 1818.","answer":"Silent Night"}]},{"category":"History Tells Us...","questions":[{"points":100,"question":"This many Christmas turkeys were sold in 2013 across the U.K.<br><ul><li>1 million</li><li>10 million</li><li>20 million</li></ul>","answer":"10 million"},{"points":200,"question":"This Christmas decoration was originally made from strands of silver.","answer":"Tinsel"},{"points":300,"question":"This traditional Christmas decoration is actually a parasitic plant.","answer":"Mistletoe"},{"points":400,"question":"This Christmas carol became the first song ever broadcast from space in 1965.","answer":"Jingle Bells"},{"points":500,"question":"Stollen is the traditional fruit cake of this country.","answer":"Germany"}]},{"category":"I know what you did last Sunday!","questions":[{"points":100,"question":"This person had a solo for the BASIC Fellowship's Christmas Choir.","answer":"Brian Tung"},{"points":200,"question":"Our church is participating in this special offering this month.","answer":"Lottie Moon Christmas Offering"},{"points":300,"question":"The BASIC Fellowship sang this song last Sunday.","answer":"Joyful, Joyful, We Adore Thee"},{"points":400,"question":"In “O little town of Bethlehem” where do the silent stars go by?","answer":"Above the deep and dreamless sleep"},{"points":500,"question":"What passage was Pastor Steve's sermon based on?","answer":"Matthew 1:18-25"}]}]
		$data = [
			'owner_id' => 2,
			'data' => '',
			'game_session_id' => 1,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("game_data")->insert($data);

		// Wheel of fortune
		$data = [
			'owner_id' => 2,
			'data' => '',
			'game_session_id' => 2,
			'created_at' => date('Y-m-d H:i:s', time()),
		];
		// Using Query Builder
		$this->db->table("game_data")->insert($data);


	}
}
