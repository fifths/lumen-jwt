<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class PostController extends BaseController
{

    public function __construct()
    {
        $this->middleware('api.auth');
    }

    /**
     * @api {get} /post Request Post information
     * @apiName GetPost
     * @apiGroup Post
     *
     * @apiParam {Number} page page number.
     *
     * @apiSuccess {String} title
     * @apiSuccess {String} content
     */
    public function index()
    {
        $post = Post::where('user_id', $this->user()->id)->paginate();
        return response()->json($post);
    }

    public function show($post_id)
    {
        $post = Post::find($post_id);
        $this->authorize('view', $post);
        return response()->json($post);
    }

    public function store()
    {
        $rules = array(
            'title' => 'required|string',
            'content' => 'required|string',
        );
        $this->validate(Request::instance(), $rules);
        $this->authorize('create', Post::class);
        $post = new Post();
        $post->title = Input::get('title');
        $post->content = Input::get('content');
        Auth::user()->posts()->save($post);
        return response()->json($post);
    }

    public function update($post_id)
    {
        $rules = array(
            'title' => 'string',
            'content' => 'string',
        );
        $this->validate(Request::instance(), $rules);
        $post = Post::find($post_id);
        $this->authorize('update', $post);
        try {
            $title = Input::get('title');
            if (!empty($title)) {
                $post->title = $title;
            }
            $content = Input::get('content');
            if (!empty($content)) {
                $post->content = $content;
            }
            $post->save();
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Post not updated',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($post_id)
    {
        $post = Post::find($post_id);
        $this->authorize('delete', $post);
        $rs = $post->delete();
        return response()->json($rs);
    }
}