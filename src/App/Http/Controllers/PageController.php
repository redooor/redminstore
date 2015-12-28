<?php namespace Redooor\Redminstore\App\Http\Controllers;

use Validator;
use Redooor\Redminportal\App\Models\Page;

class PageController extends Controller
{
    public function showHome()
    {
        return view('redminstore::pages.home');
    }
    
    public function loadPage($slug)
    {
        $inputs = array('slug' => $slug);
        $rules = array('slug' => 'required|alpha_dash');
        $validation = Validator::make($inputs, $rules);
        
        if ($validation->passes()) {
            $page = Page::where('slug', $slug)->where('private', false)->first();
            
            if ($page) {
                return view('redminstore::pages.view')
                    ->with('page', $page);
            }
        }
        
        return view('redminstore::general.404');
    }
}
