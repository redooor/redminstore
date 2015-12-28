<?php namespace Redooor\Redminstore\App\Http\Controllers;

use Validator;
use Redooor\Redminportal\App\Models\Post;

class PostController extends Controller
{
    public function show404()
    {
        return view('redminstore::general.404');
    }
    
    public function loadPost($slug)
    {
        $inputs = array('slug' => $slug);
        $rules = array('slug' => 'required|alpha_dash');
        $validation = Validator::make($inputs, $rules);
        
        if ($validation->passes()) {
            $post = Post::where('slug', $slug)->where('private', false)->first();
            
            if ($post) {
                return view('redminstore::posts.view')
                    ->with('post', $post);
            }
        }
        
        return view('redminstore::general.404');
    }
}
