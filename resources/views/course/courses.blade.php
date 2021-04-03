@extends('templates.main-template')
@section('content')
    <h1>{{$groupName}}</h1>
    @include('template-parts.courses')

@endsection

