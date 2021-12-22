@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')

   <div class="row">
      <div class="col-md-8">
         {{-- @each('posts.partials.post',$posts,'post') --}}
         
         <h1 class="my-5">Blog Posts</h1>
         
         @forelse($posts as $key => $post)
         
         @include('posts.partials.post')
         
         @empty
         no content
         
         @endforelse
      </div>
      <div class="col-md-4">

         <div class="row ">
            <div class="col">

               @card(['title' => 'Most Commented'])
                  @slot('subtitle') What people are currently talking about @endslot
                  @slot('items')
                     <ul class="list-group list-group-flush">
                        @foreach($mostCommented as $post)
                        <li class="list-group-item">
                           <a href="{{ route('posts.show', ['post' => $post->id]) }}">
                              {{ $post->title }}
                           </a>
                        </li>
                        @endforeach
                     </ul>
                  @endslot
               @endcard

            </div>
         </div>

         <div class="row mt-4">
            <div class="col">

               @card(['title' => 'Most Active'])
                  @slot('subtitle') Users with most posts written @endslot
                  @slot('items', collect($mostActive)->pluck('name'))
               @endcard

            </div>
         </div>

         <div class="row mt-4">
            <div class="col">

               @card(['title' => 'Most Active In Last Month'])
                  @slot('subtitle') Users with most posts written in last month @endslot
                  @slot('items', collect($mostActiveLastMonth)->pluck('name'))
               @endcard

            </div>
         </div>

      </div>
   </div>

   
@endsection