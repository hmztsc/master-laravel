@extends('layouts.app')

@section('title','Update')

@section('content')

<h1 class="my-5">Update Post :</h1>

<form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST">
   @csrf
   @method('PUT')
   @include('posts.partials.form')
   
   <input type="submit" name="submit" class="btn btn-primary" value="Update">

</form>

@endsection