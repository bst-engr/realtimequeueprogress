<?php namespace App\Http\Controllers;

use \App\Models\Contacts;
use Illuminate\Routing\Controller as BaseController;  // <<< See here - no real class, only an alias
use View;
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	private $contacts;
	public function __construct(){
		$this->contacts = new Contacts();
	}

	public function dashboard()
	{
		$this->contacts->preparePusherList();
		return View::make('home.dashboard');
	}

	public function contactList() {
		$this->contacts->preparePusherList();
		return "List Updated";
	}

	public function create() {

	}

	public function update($id) {
		$this->contacts->updateContact($id);
		$this->contacts->preparePusherList();
		return "Updated";
	}

}