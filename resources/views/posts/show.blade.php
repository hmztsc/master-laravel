@extends('layouts.app')

@section('title', $post['title'])

@section('content')

<h1>
   {{ $post['title'] }}

   <small>
      @badge(['type' => 'primary', 'show' => now()->diffInMinutes($post->created_at) < 120])
         New
      @endbadge
   </small>
</h1>

<p>{{ $post['content'] }}</p>   

@updated(['date' => $post->created_at, 'name' => $post->user->name ])
@endupdated

<p>Currently read by {{ $counter }} people</p>

@forelse($post->comments as $comment)

<p>{{ $comment->content }}</p>

@updated(['date' => $post->created_at])
@endupdated

@empty

<p>No comments yet!</p>

@endforelse

@endsection