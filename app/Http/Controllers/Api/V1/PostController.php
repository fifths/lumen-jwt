<?php
/**
 * Created by PhpStorm.
 * User: fifths
 * Date: 17-7-13
 * Time: 下午5:01
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class PostController extends BaseController
{

    /**
     * Return whole list of posts
     * No authorization required
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Post::paginate());
    }

    /**
     * Create new post
     * Only if the Posts' policy allows it
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
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

    /**
     * Update post
     * Only if the Posts' policy allows it
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($post_id)
    {
        $rules = array(
            'title' => 'required|string',
            'content' => 'required|string',
        );
        $this->validate(Request::instance(), $rules);

        $post = Post::find($post_id);
        $this->authorize('update', $post);

        try {
            $post->title = Input::get('title');
            $post->content = Input::get('content');
            $post->save();

            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Post not updated',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}