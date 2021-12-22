@extends('layouts.app')

@section('content')
<h1 class="mb-5">Login</h1>

<div class="row">
   <div class="col-md-4">
      <form action="{{ route('login') }}" method="POST">
         @csrf

         <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? " is-invalid" : "" }}">
         
            @if($errors->has('email'))
            <span class="invalid-feedback">
               <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
         </div>

         <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control{{ $errors->has('password') ? " is-invalid" : "" }}">
         
            @if($errors->has('password'))
            <span class="invalid-feedback">
               <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
         </div>

         <div class="form-group">
            <div class="form-check">
               <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

               <label for="remember" class="form-check-label">
                  Remember
               </label>
            </div>
         </div>
         
         <button type="submit" class="btn btn-primary btn-block">Login</button>
      </form>
   </div>
</div>  

@endsection