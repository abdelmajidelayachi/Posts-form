<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $like = Like::where('post_id', $request->id)->where('user_id', Auth::user()->id)->get();
        // check if the post liked to dislike it 
        if (count($like) > 0) {
            // $like = Like::find($like->id);
            $like[0]->delete();
            return response()->json([
                'success' => true,
                'message' => 'disliked'
            ]);
        }

        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->post_id = $request->id;
        $like->save();
        return response()->json([
            'success' => true,
            'message' => 'liked'
        ]);
    }
}
