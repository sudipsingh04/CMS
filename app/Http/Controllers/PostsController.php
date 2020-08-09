<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $image = $request->image->store('posts');

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'image' => $image,
        ]);

        session()->flash('success', 'Post created successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->withPost($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'content', 'published_at']);

        if($request->hasFile('image')){
            $image = $request->image->store('posts');

            $post->deleteImage();
        }

        $data['image'] = $image;

        $post->update($data);

        session()->flash('success', 'Post updated successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->whereId($id)->firstOrFail();

        if ($post->trashed()) {

            $post->deleteImage();

            $post->forceDelete();

            session()->flash('success', 'Post deleted successfully');
        }else{
            $post->delete();

            session()->flash('success', 'Post trashed successfully');
        }

        return redirect(route('posts.index'));
    }

    /**
     * Display a list of all trashed posts
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->whereId($id)->firstOrFail();

        $post->restore();

        session()->flash('success', 'Post restored successfully');

        return redirect()->back();
    }
}
