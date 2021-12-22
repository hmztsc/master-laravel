@extends('layouts.app')

@section('title','Contact Page')

@section('content')
<h1 class="my-5">Contact Page</h1>

<p>This is a contact page.</p>

@can('home.secret')
   <p>
      <a href="{{ route('secret') }}">This is secret contact details.</a>
   </p>
@endcan

@endsection