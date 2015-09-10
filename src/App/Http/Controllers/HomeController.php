<?php namespace Redooor\Redminstore\App\Http\Controllers;

class HomeController extends Controller {
    
	public function getIndex()
	{
		return view('redminstore::pages.view');
	}

}
