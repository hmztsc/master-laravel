<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mostCommented = Cache::remember('mostCommented', now()->addSeconds(10), function () {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive = Cache::remember('mostActive', now()->addSeconds(10), function () {
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonth = Cache::remember('mostActiveLastMonth', now()->addSeconds(10), function () {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
                'mostCommented' => $mostCommented,
                'mostActive' => $mostActive,
                'mostActiveLastMonth' => $mostActiveLastMonth
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $post = BlogPost::create($validated);

        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
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
        // abort_if(!isset($this->posts[$id]), 404);

        $post = Cache::remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with('comments')->findOrFail($id);
        });

        // $sessionId = session()->getId();
        
        // $counterKey = "blog-post-{$id}-counter";
        // $usersKey = "blog-post-{$id}-users";

        // $users = Cache::get($usersKey, []);
        // $usersUpdate = [];
        // $diffrence = 0;
        // $now = now();

        // foreach ($users as $session => $lastVisit) {
        //     if ($now->diffInMinutes($lastVisit) >= 1) {
        //         $diffrence--;
        //     } else {
        //         $usersUpdate[$session] = $lastVisit;
        //     }
        // }

        // if (
        //     !array_key_exists($sessionId, $users)
        //     || $now->diffInMinutes($users[$sessionId]) >= 1
        // ) {
        //     $diffrence++;
        // }

        // $usersUpdate[$sessionId] = $now;
        // Cache::forever($usersKey, $usersUpdate);

        // if (!Cache::has($counterKey)) {
        //     Cache::forever($counterKey, 1);
        // } else {
        //     Cache::increment($counterKey, $diffrence);
        // }

        // $counter = Cache::get($counterKey);

        $cacheName = "blog-post-{$id}-users";
        $session_id = session()->getId();
        $now = now();

        $users = Cache::get($cacheName, []);
        $users[$session_id] = $now;

        $updatedUsers = [];
        
        foreach($users as $session => $lastVisit){
            if($now->diffInMinutes($lastVisit) < 1 ){
                $updatedUsers[$session] = $lastVisit;
            }
        }

        Cache::forever($cacheName, $updatedUsers);
        $counter = count($updatedUsers);

        return view('posts.show', [
            'post' => $post,
            'counter' => $counter
        ]);

        // return view('posts.show', ['post' => BlogPost::with(['comments' => function($query){
        //     return $query->latest();
        // }])->findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post', $post)){
        //     abort(403, "You can't edit this blog post!");
        // }

        $this->authorize('update', $post);


        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post', $post)){
        //     abort(403, "You can't edit this blog post!");
        // }

        $this->authorize('update', $post);

        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Update success.');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('delete-post', $post)){
        //     abort(403, "You can't delete this blog post!");
        // }

        $this->authorize('delete', $post);

        $post->delete();

        session()->flash('status', 'Blog post was delete!');

        return redirect()->route('posts.index');
    }
}
