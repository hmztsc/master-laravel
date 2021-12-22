@extends('layouts.app')

@section('title','asds')

@section('content')

<form action="{{ route('posts.store') }}" method="POST">
   @csrf

   <h1 class="my-5">Add Blog Post</h1>

   @include('posts.partials.form')
   
   <input type="submit" name="submit" class="btn btn-primary btn-block" value="Submit">

</form>

@endsection