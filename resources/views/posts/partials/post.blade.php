

<h3>
   @if($post->trashed())
   <del>
   @endif
   <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="{{ $post->trashed() ? 'text-muted' : '' }}">{{ $post['title'] }}</a>
   @if($post->trashed())
   </del>
   @endif
</h3>

@updated(['date' => $post->created_at, 'name' => $post->user->name ])
@endupdated

@if($post->comments_count)
   <p>{{ $post->comments_count }} comments.</p>
@else 
   <p>No comments yet!</p>
@endif

@can(['update', 'delete'], $post)

<div class="mb-3">

   @can('update', $post)
   <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
   @endcan

   @if(!$post->trashed())

   @can('delete', $post)
   <form action="{{ route('posts.destroy',['post' => $post->id]) }}" class="d-inline" method="POST">
      @csrf
      @method('DELETE')
      <input type="submit" class="btn btn-danger" value="Delete!">
   </form>
   @endcan

   @endif

</div>
@endcan
   