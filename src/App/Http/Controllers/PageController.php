<?php namespace Redooor\Redminstore\App\Http\Controllers;

use Validator;
use Redooor\Redminportal\App\Models\Page;

class PageController extends Controller
{
    public function showHome()
    {
        $pages = Page::where('private', false)->get();
        
        return view('redminstore::pages.home')->with('pages', $pages);
    }
    
    public function loadPage($slug)
    {
        $pages = Page::where('private', false)->get();
        
        $inputs = array('slug' => $slug);
        $rules = array('slug' => 'required|alpha_dash');
        $validation = Validator::make($inputs, $rules);
        
        if ($validation->passes()) {
            $page = Page::where('slug', $slug)->where('private', false)->first();
            if ($page) {
                return view('redminstore::pages.view')
                    ->with('pages', $pages)
                    ->with('page_content', $page->content);
            }
        }
        
        return view('redminstore::general.404')->with('pages', $pages);
    }
}
