<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->desc = $request->desc;

        // lets check if post has photo
        if($request->photo !='')
        {
            $photo = time().'jpg';
            // store image in public link with command : php artisan storage:link
            file_put_contents('storage/posts/'.$photo,base64_decode($request->photo));
            $post->photo=$photo;
        }
        $post->save();
        $post->user;
        return response()->json(['success'=>true,'message'=>'posted','post'=>$post]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $post = Post::find($request->id);
        // check if the user edit his own post
        if(Auth::user()->id != $post->user_id)
        {
            return response()->json(['success'=>false,'message'=>'unauthorized access']);
        }
        $post->desc =$request->desc;
        $post->update();
        return response()->json([
            'success'=>true,
            'message'=> 'Post edited'
        ]);
    }
    public function delete(Request $request)
    {
        $post = Post::find($request->id);
        // check if the user delete his own post
        if(Auth::user()->id != $post->user_id)
        {
            return response()->json(['success'=>false,'message'=>'unauthorized access']);
        }
        // check if the post has photo 
        if($post->photo !='')
        {
            Storage::delete('public/posts/'.$post->photo);
        }
        $post->delete();
        return response()->json([
            'success'=>true,
            'message'=> 'Post deleted'
        ]);
    }
    public function posts()
    {
        $posts = Post::orderBy('id','desc')->get();
        foreach($posts as $post)
        {
            // get user of the post
            $post->user;
            // count number of comments
            $post['commentsCount']= count($post->comments);
            // count number of likes
            $post['likesCount']= count($post->likes);

            // check if the user likes his post
            $post['selfLike']= false;
            foreach($post->likes as $like)
            {
                if($like->user_id== $post->user->id)
                {
                    $post['selfLike']= true;
                    break;
                }
            }
        }
        return response()->json(['success'=>true, 'message'=>'posts','posts'=>$posts]);
    }
    
}
