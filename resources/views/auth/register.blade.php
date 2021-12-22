@extends('layouts.app')

@section('content')
<div class="row">
   <div class="col-md-4">
      <h1 class="mb-5">Register</h1>

      <form method="POST" action="{{ route('register') }}">
         @csrf

         <div class="form-group">
            <label for="name">Name</label>
            <input name="name" id="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : ''  }}">
            @if($errors->has('name'))
            <span class="invalid-feedback">
               <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
         </div>
         <div class="form-group">
            <label for="email">Email</label>
            <input name="email" id="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : ''  }}">
            @if($errors->has('email'))
            <span class="invalid-feedback">
               <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
         </div>
         <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : ''  }}">
            @if($errors->has('password'))
            <span class="invalid-feedback">
               <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
         </div>
         <div class="form-group">
            <label for="password_confirmation">Retyped Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
         </div>

         <button type="submit" class="btn btn-primary btn-blocked">Register</button>

      </form>
   </div>
</div>

@endsection