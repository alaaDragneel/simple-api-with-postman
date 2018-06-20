<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResourceTrait;

class PostsController extends Controller
{
    use ApiResourceTrait;
    
    protected $apiValidation = [ 'title' => 'required', 'body' => 'required' ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->api(Post::paginate(static::$paginate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create($this->apiValidate($this->apiValidation));

        if (! $post) return $this->error('Unknown Error', 500);
        
        return $this->api($post, null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! $post = Post::find($id) ) return $this->error('No Post Was Found', 404);
        
        return $this->api($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $this->apiValidate($this->apiValidation);
        
        if (! $post = Post::find($id) ) return $this->error('No Post Was Found', 404);

        $post->update($validated);

        if (! $post) return $this->error('Unknown Error', 500);
        
        return $this->api($post, null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! $post = Post::find($id) ) return $this->error('No Post Was Found', 404);

        $post->delete();
        
        return $this->api([], null, 200);
    }
}
