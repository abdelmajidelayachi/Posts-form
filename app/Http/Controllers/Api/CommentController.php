<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;
        $comment->save();
        return response()->json(['success'=>true, 'message'=>'comment added']);
    }
    public function update(Request $request)
    {
        $comment = Comment::find($request->id);
        // check if the user own comment
        if($comment->user_id != Auth::user()->id)
        {
            return response()->json(['success'=>false,'message'=>'unauthorized access']);

        }
        $comment->comment=$request->comment;
        $comment->update();
        return response()->json(['success'=>true,"message"=>'comment edited']);

    }
    public function delete(Request $request)
    {
        $comment = Comment::find($request->id);
        // check if the user own comment
        if($comment->user_id != Auth::user()->id)
        {
            return response()->json(['success'=>false,'message'=>'unauthorized access']);

        }
        $comment->delete();
        return response()->json(['success'=>true,"message"=>'comment deleted']);

    }

    public function comments(Request $request)
    {
        $comments = Comment::where('post_id',$request->id)->orderBy('id','desc')->get();
        foreach($comments as $comment)
        {
            $comment->user;
        }
        return response()->json(['success'=>true,'comments'=>$comments]);
    }


}
