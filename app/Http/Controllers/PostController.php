<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

use App\PostComment;
use App\Post;
use App\User;

class PostController extends Controller
{
    public function index()
    {
        if (request(['edit'])) {
            $post = Post::find(request(['id']));
            return $post;

        }
    	if(request( [ 'month', 'year' ])) {
            $posts = Post::latest()->filter( request( [ 'month', 'year' ] ))->get();
        }
        else{
            $posts = Post::latest()->get();   
        }

        return view('posts.index', compact('posts'));
    }


    public function show( Post $post )
    {
    	return view('posts.show', compact('post'));
    }


    public function create()
    {
    	return view('posts.create');
    }


    public function store( PostRequest $request )
    {   
        
        auth()->user()->publish(
            new Post(request(['title','body']))
        );
    	return redirect()->route('index',[
    		'msg' => 'Good Jobs'
    	]);
    }

    public function update(Request $request)
    {
        $post = Post::where('id', $request->id)->update([
            'body'  => $request->body,
        ]);
        // return $post;
        return response()->json($request->body);
    }

    
}
