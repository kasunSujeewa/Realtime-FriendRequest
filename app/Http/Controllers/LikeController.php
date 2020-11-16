<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $like = new Like;
        $like->post_id = $id;
        $like->user_id = Auth::user()->id;
        $like->status = $request->status;
        $like->save();
        return response()->json(['like' => $like, 'message' => "succesful reacted"]);
    }
    public function remove($id)
    {
        $like = Like::where('post_id', $id)->where('user_id', Auth::user()->id)->first();
        $like->delete();
        return response()->json(['message' => "succesful reacted"]);
    }
    public function update(Request $request, $id)
    {
        $like = Like::where('post_id', $id)->where('user_id', Auth::user()->id)->first();
        $like->status = $request->status;
        $like->save();
        return response()->json(['message' => "succesful reacted"]);
    }
    public function Likes($id)
    {
        $post = Post::find($id);
        $like = collect($post->likes->pluck('user_id'));
        $dislike = collect($post->dislikes->pluck('user_id'));
        return response()->json(['like' => $like, 'dislike' => $dislike]);
    }
}
