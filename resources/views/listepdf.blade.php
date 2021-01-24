@extends('layouts.app')

@section('content')
<div class="container">

<div id="search">
<form action="/search"  method="get">
<input type ="search" name="search" id="recher" class="form -control"><button class="btn btn-primary" type="submit">search</button>
</form>
</div>
<div id="resultats"></div>
<!--resultat ajax -->
<div class="col-md-5" align ="right">
<a href= "{{ url('/student/pdf') }}" class ="btn btn-danger">Convert into PDF</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">nom</th>
      <th scope="col">adresse</th>
      <th scope="col">age</th>
      <th scope="col">edit</th>
      <th scope="col">delete</th>
    </tr>
  </thead>
  <tbody>

   @foreach($result as $resultats)
    <tr>
      <td>{{ $resultats->nom }}</td>
      <td>{{ $resultats->adresse }}</td>
      <td>{{ $resultats->age }}</td>
      <td><a href ="edit/{{$resultats->id}}">Edit</a></td>
      <td><a href ="delete/{{$resultats->id}}">delete</a></td>
      
    </tr>
    @endforeach
  </tbody>
</table>
<div id="zapo"></div>
<div class="pagition">
{{ $result->links() }}
</div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
   
    $('#search').keyup(function() {
      var search = $('#recher').val();
  
     $('#zapo').html(search);
    $('.table').hide();
   

});
});
</script>



@endsection
