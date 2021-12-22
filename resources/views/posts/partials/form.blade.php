
<div class="form-group">
   <label for="title">Title</label>
   <input type="text" name="title" id="title" class="form-control" value="{{ old('title',optional($post ?? null)->title) }}">
</div>

@error('title') 
   <div class="alert alert-danger"> {{ $message }} </div>
@enderror

<div class="form-group">
   <label for="content">Content</label>
   <input type="text" name="content" id="content" class="form-control" value="{{ old('content', optional($post ?? null)->content) }}">
</div>

@if ($errors->any())
   <div class="form-group">
      <ul class="list-group">
         @foreach ($errors->all() as $error)
            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
         @endforeach
      </ul>
   </div>
@endif
