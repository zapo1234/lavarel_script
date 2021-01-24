@extends('layouts.app')

@section('title','inscription user')
@section('content')
<div class="container">

@if (session('status'))
<div class="alert alert-success" role="alert">
	{{ session('status') }}
</div>
@elseif(session('failed'))
<div class="alert alert-danger" role="alert">
{{ session('failed') }}
</div>
@endif

<form method="POST" action="{{ route('store') }}" enctype = "multipart/form-data">
@csrf
  <div class="form-group">
    
   <input type="file" name="file" required>
  <button type="submit" class="btn btn-primary"> {{ __('upload') }}</button>
</form>

<div class="container" >
<h1>liste des image enregsitré</h1>

<div class="image_img">

@foreach($image as $images) 
<div><span class="card">{{ $images->title }}<span><br/>

<img src ="{{asset('upload')}}/{{ $images->name }}" with="100" height="100"><a href ="/delete_img/{{$images->id}}">delete</a>

</div>

@endforeach

</div>

</div>

</div>
@endsection


