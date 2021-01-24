@extends('layouts.app')

@section('title','inscription user')
@section('content')
<div class="container">

@if (session('status'))
<div class="alert alert-success" role="alert">
	{{ session('status') }}

@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
{{ session('failed') }}
</div>
@endif

<form method="POST" action="{{ route('creates') }}">
@csrf

 <div>Envoyer votre message</div>



  <div class="form-group">
    <label for="formGroupExampleInput">nom</label>
    <input type="text" class="form-control" id="formGroupExampleInput" name="nom" placeholder="" required>
  @if($errors->has('nom'))
  <div class="error">{{$errors->first('nom') }}</div>
  @endif
  </div>
  <div class="form-group">
    <label for="formGroupExampleInput2">email</label>
    <input type="email" class="form-control" id="formGroupExampleInput2" name="email" placeholder="" required>
  </div>

  <div class="form-group">
    <label for="formGroupExampleInput2">Votre message</label>
    <textarea  class="form-control" id="formGroupExampleInput2" name="message" placeholder="" required></textarea>
   
</div>

  <button type="submit" class="btn btn-primary"> {{ __('enregister') }}</button>
</form>
                                

</div>
@endsection

