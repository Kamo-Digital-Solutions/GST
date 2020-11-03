<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Room extends Controller {

	public function index($id) {
		$session = session();
        if(isset($_SESSION['logged_in'])) {
			return view('room/index');
		} else {
			return redirect()->to('/auth/signin');
		}
	}
}
