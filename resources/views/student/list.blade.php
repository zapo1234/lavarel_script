@extends('layouts.app')

@section('content')
<a href="{{ URL::to('/student/pdf') }}">Export PDF</a>
    <table>
        <tr>
            <th>Name</th>
            <th>adresse</th>
            <th>pays</th>
        </tr>
        @foreach ($students as $student)
        <tr>
            <td>{{ trim(strip_tags( $student->nom)) }}</td>
            <td>{{ $student->adresse }}</td>
            <td>{{ $student->age }}</td>
        </tr>
        @endforeach
    </table>
    
</div>

@endsection