<?php namespace Redooor\Redminstore\App\Http\Controllers;

class PageController extends Controller {
    
	public function getIndex()
	{
		return view('redminstore::pages.view');
	}

}
